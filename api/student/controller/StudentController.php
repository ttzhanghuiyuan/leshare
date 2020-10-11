<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: pl125 <xskjs888@163.com>
// +----------------------------------------------------------------------

namespace api\student\controller;

use app\admin\model\BookClassModel;
use app\admin\model\BuckleHourModel;
use app\admin\model\ClassScheduleModel;
use app\admin\model\StudentCardModel;
use app\admin\model\VipCardModel;
use cmf\controller\RestBaseController;
use think\Db;
use think\db\exception\DataNotFoundException;
use think\db\exception\ModelNotFoundException;
use think\db\Query;
use think\Exception;
use think\exception\DbException;
use think\exception\ErrorException;
use think\exception\PDOException;
use think\exception\ThrowableError;
use think\Log;

class StudentController extends RestBaseController
{
    const APPID = 'wx03df51c21dc4151c';
    const APP_SECRET = '0bb0a23969c302ad1bf789403d47b675';

    /**
     * @api {POST} https://www.loshare.club/api.php/student/student/matchUser 1-用户首次登录验证绑定
     * @apiVersion 1.0.0
     * @apiGroup NEED
     * @apiDescription 注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份
     *
     * @apiParam {String} open_id 小程序open_id-非空
     * @apiParam {String} wx_nick 微信昵称
     * @apiParam  {String} header_url 头像链接
     * @apiParam {String} phone 后台号码-非空
     * @apiParam  {String} pass 后台密码-非空
     *
     * @apiSuccess {Object} code 返回码
     * @apiSuccess {Object} msg  中文解释
     * @apiSuccess {String[]} data  返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    {
     *      "code": 1,
     *      "msg": "验证成功!",
     *      "data": ""
     *    }
     */
    public function matchUser()
    {
        $openId = trim($this->request->param('open_id'));
        $wxNick = trim($this->request->param('wx_nick'));
        $headerUrl = trim($this->request->param('header_url'));
        $phone = trim($this->request->param('phone'));
        $pass = trim($this->request->param('pass'));

        //验证参数
        if (!$openId) $this->error('缺少关键参数open_id');
        if (!$phone) $this->error('缺少关键参数phone');
        if (!$pass) $this->error('缺少关键参数pass');

        //验证手机号和密码
        $studentId = Db::name('student')
            ->where('phone', $phone)
            ->where('pass', $pass)
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->value('id');

        if (!$studentId) $this->error('验证手机号密码失败,请联系学校!');

        $updateFlag = Db::name('student')
            ->where('id', $studentId)
            ->update([
                'wx_nick' => $wxNick,
                'header_url' => $headerUrl,
                'open_id' => $openId,
            ]);

        $this->success('验证成功!');
    }


    /**
     * @api {POST} https://www.loshare.club/api.php/student/student/getClassLevel 2-获取课程等级
     * @apiVersion 1.0.0
     * @apiGroup NEED
     *
     * @apiSuccess {Object} code 返回码
     * @apiSuccess {Object} msg  中文解释
     * @apiSuccess {String[]} data  返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *      "code": 1,
     *      "msg": "成功",
     *      "data": {
     *        "list": [
     *          {
     *            "id": 1,
     *            "name": "轮滑初级"
     *          },
     *          {
     *            "id": 2,
     *            "name": "轮滑中级"
     *          }
     *        ]
     *      }
     *    }
     */
    public function getClassLevel()
    {
        //获取课程等级
        $classLevelList = Db::name('class_level')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->field('id,name')
            ->select();

        $this->success('成功', [
            'list' => $classLevelList,
        ]);
    }

    /**
     * @api {POST} https://www.loshare.club/api.php/student/student/getTodayClassInfo 3-获取今日课表
     * @apiVersion 1.0.0
     * @apiGroup NEED
     *
     * @apiParam {Int} level_id 课程等级
     * @apiParam {String} date 选择日期
     *
     * @apiSuccess {Object} code 返回码
     * @apiSuccess {Object} msg  中文解释
     * @apiSuccess {String[]} data  返回数据
     * @apiSuccess {Int} data.list.start_hour  开始时
     * @apiSuccess {Int} data.list.start_minute  开始分
     * @apiSuccess {Int} data.list.end_hour  结束时
     * @apiSuccess {Int} data.list.end_minute  结束分
     * @apiSuccess {Int} data.list.left_num  剩余可预约课节数
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *    {
     *      "code": 1,
     *      "msg": "成功",
     *      "data": {
     *        "list": [
     *          {
     *            "id": 1,
     *            "study_num": 10,
     *            "start_hour": 10,
     *            "start_minute": 10,
     *            "end_hour": 11,
     *            "end_minute": 30,
     *            "left_num": 10
     *          }
     *        ]
     *      }
     *    }
     */
    public function getTodayClassInfo()
    {
        $levelId = trim($this->request->param('level_id'));
        $date = trim($this->request->param('date'));

        //获取今天周几
        $week = date("N", strtotime($date));

        $bookList = [];
        $nowDate = strtotime($date);
        $nowDateEnd = strtotime('+ 1 day', $nowDate);
        //获取常规课程
        $regularClass = Db::name('class_schedule')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where('enable_flag', ClassScheduleModel::CLASS_ENABLE)
            ->where('sch_type', ClassScheduleModel::REGULAR_SCH)
            ->where(function (Query $query) use ($levelId, $week) {
                if ($levelId) {
                    $query->where('level_id', $levelId);
                }

                //周几
                if ($week) {
                    $query->where('week', $week);
                }
            })
            ->field('id,study_num,start_hour,start_minute,end_hour,end_minute')
            ->select()->toArray();
        //获取今日临时课程
        $temporaryClass = Db::name('class_schedule')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where('enable_flag', ClassScheduleModel::CLASS_ENABLE)
            ->where('sch_type', ClassScheduleModel::TEMPORARY_SCH)
            ->where('class_date', $nowDate)
            ->where(function (Query $query) use ($levelId) {
                if ($levelId) {
                    $query->where('level_id', $levelId);
                }
            })
            ->field('id,study_num,start_hour,start_minute,end_hour,end_minute')
            ->select()->toArray();

        //合并数组
        $classList = array_merge($regularClass, $temporaryClass);

        //数组排序
        array_multisort(array_column($classList, 'start_hour'), SORT_ASC, $classList);

        //获取今天已报名数量
        if ($classList) {
            $classIds = array_column($classList, 'id');
            $bookList = Db::name('book_class')
                ->where('class_sch_id', 'in', $classIds)
                ->where('cancel_flag', BookClassModel::UN_CANCEL)
                ->where('class_start_time', 'between', [$nowDate, $nowDateEnd])
                ->group('class_sch_id')
                ->column('class_sch_id,count(*) booked_num');
        }

        //组合数据
        foreach ($classList as &$item) {
            $classId = $item['id'];
            $bookNum = $bookList[$classId] ?? 0;
            $studyNum = $item['study_num'];
            $item['start_minute'] = $item['start_minute'] ? $item['start_minute'] : '00';
            $item['end_minute'] = $item['end_minute'] ? $item['end_minute'] : '00';
            $item['left_num'] = ($studyNum - $bookNum) > 0 ? ($studyNum - $bookNum) : 0;
        }

        $this->success('成功', [
            'list' => $classList,
        ]);
    }

    /**
     * @api {POST} https://www.loshare.club/api.php/student/student/getUserInfo 4-获取用户剩余课时
     * @apiVersion 1.0.0
     * @apiGroup NEED
     *
     * @apiDescription 注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份(本接口需要)
     *
     *
     * @apiSuccess {Object} code 返回码
     * @apiSuccess {Object} msg  中文解释
     * @apiSuccess {String[]} data  返回数据
     * @apiSuccess {Int} data.left_num  剩余课时
     * @apiSuccess {Int} data.card_type  卡片类型 1次数卡 2时间卡
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "code": 1,
     *         "msg": "成功",
     *         "data": {
     *             "left_num": 16,
     *             "card_type": 1,
     *         }
     *     }
     */
    public function getUserInfo()
    {
        $studentId = $this->getUserId();

        $cardInfo = Db::name('student_card')
            ->where('student_id', $studentId)
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where('enable_flag', StudentCardModel::ENABLE)
            ->field('id,study_num,learned_num,card_type,effect_start,effect_end')
            ->find();

        $leftNum = $cardInfo['study_num'] - $cardInfo['learned_num'];
        $leftNum = $leftNum > 0 ? $leftNum : 0;

        //次数卡显示剩余天数
        if ($cardInfo['card_type'] == VipCardModel::TIMES_VIP_CARD) {
            $leftNum = ceil(($cardInfo['effect_end'] - $cardInfo['effect_start']) / (3600 * 24));
            $leftNum = $leftNum > 0 ? $leftNum : 0;
        }

        $this->success('成功', [
            'left_num' => $leftNum,
            'card_type' => $cardInfo['card_type'],
        ]);
    }

    /**
     * @api {POST} https://www.loshare.club/api.php/student/student/bookClass 5-约课
     * @apiVersion 1.0.0
     * @apiGroup NEED
     *
     * @apiParam {Int} cs_id 课表id
     * @apiParam {String} class_date 约课时间eg:2020-09-02
     *
     * @apiDescription 注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份(本接口需要)
     *
     *
     * @apiSuccess {Object} code 返回码
     * @apiSuccess {Object} msg  中文解释
     * @apiSuccess {String[]} data  返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "code": 1,
     *         "msg": "成功",
     *         "data": "",
     *     }
     */
    public function bookClass()
    {
        $studentId = $this->getUserId();
        $csId = $this->request->param('cs_id', 0, 'intval');
        $classDate = trim($this->request->param('class_date'));
        if (!$csId) $this->error('未选择课程!');
        if (!$classDate) $this->error('未选择约课时间');
        //检查学生和会员卡和约课限制
        try {
            $this->checkStudent($studentId, $csId, $classDate);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }
        //检查课程情况
        try {
            $this->checkClassSchedule($csId, $classDate);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        //执行约课
        try {
            $this->doBookClass($studentId, $csId, $classDate);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->success('成功');
    }

    /**
     * @desc:约课
     * @date:2020/8/30 下午8:39
     * @param $studentId
     * @param $csId
     * @param $classDate
     * @return bool :maxed
     * @throws Exception
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @throws PDOException
     * @author:abner<turing_zhy@163.com>
     */
    private function doBookClass($studentId, $csId, $classDate)
    {
        $nowTime = time();
        //获取课程信息
        $csInfo = Db::name('class_schedule')
            ->alias('cs')
            ->join('class_level cl', 'cs.level_id = cl.id', 'left')
            ->where('cs.enable_flag', ClassScheduleModel::CLASS_ENABLE)
            ->where('cs.delete_flag', self::DELETE_FLAG_FALSE)
            ->field('cl.name cl_name,cs.start_hour,cs.start_minute,end_hour,end_minute')
            ->find();

        if (!$csInfo) exception('未找到课表信息!');

        //整理上课时间
        $start_minute = $csInfo['start_minute'] ? $csInfo['start_minute'] : '00';
        $classStart = "$classDate {$csInfo['start_hour']}:$start_minute:00";
        $end_minute = $csInfo['end_minute'] ? $csInfo['end_minute'] : '00';
        $classEnd = "$classDate {$csInfo['end_hour']}:$end_minute:00";
        $classStart = strtotime($classStart);
        $classEnd = strtotime($classEnd);

        $bookData = [
            'student_id' => $studentId,
            'class_sch_id' => $csId,
            'level_name' => $csInfo['cl_name'],
            'class_start_time' => $classStart,
            'class_end_time' => $classEnd,
            'create_time' => $nowTime,
            'update_time' => $nowTime,
        ];

        //获取学生会员卡信息
        $cardInfo = Db::name('student_card')
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where('enable_flag', StudentCardModel::ENABLE)
            ->where('student_id', $studentId)
            ->field('id,learned_num,last_learn_time')
            ->find();

        if (!$cardInfo) exception('获取会员卡信息失败!');

        $cardData = [
            'learned_num' => $cardInfo['learned_num'] + 1,
            'last_learn_time' => $cardInfo['last_learn_time'] > $classStart ? $cardInfo['last_learn_time'] : $classStart,
        ];

        $buckleData = [
            'student_id' => $studentId,
            'sc_id' => $cardInfo['id'],
            'description' => "学员约课扣课时",
            'hour' => BuckleHourModel::BOOK_USE_HOUR,
            'create_time' => $nowTime,
            'update_time' => $nowTime,
        ];

        //添加约课记录
        Db::startTrans();
        $logFlag = Db::name('book_class')->insert($bookData);
        if (!$logFlag) {
            Db::rollback();
            exception('添加约课记录失败!');
        }

        //扣课时相关
        $cardFlag = Db::name('student_card')
            ->where('id', $cardInfo['id'])
            ->update($cardData);

        if (!$cardFlag) {
            Db::rollback();
            exception('扣课时失败!');
        }

        //添加课时消耗记录
        $buckleFlag = Db::name('buckle_hour_log')->insert($buckleData);
        if (!$buckleFlag) {
            Db::rollback();
            exception('添加课时消耗记录失败!');
        }

        Db::commit();
        return true;
    }

    /**
     * @desc: 检查课表情况
     * @date:2020/8/30 下午7:45
     * @param $csId
     * @param $classDate
     * @return bool :maxed
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @author:abner<turing_zhy@163.com>
     */
    private function checkClassSchedule($csId, $classDate)
    {
        //获取课表情况
        $csInfo = Db::name('class_schedule')
            ->where('id', $csId)
            ->field(
                'study_num,start_hour,start_minute,end_hour,end_minute,class_date,sch_type,' .
                'enable_flag,delete_flag'
            )->find();

        if ($csInfo['delete_flag'] == self::DELETE_FLAG_TRUE) exception('课表已被删除!');
        if ($csInfo['enable_flag'] != ClassScheduleModel::CLASS_ENABLE) exception('课表已无效,请刷新页面!');
        $start_minute = $csInfo['start_minute'] ? $csInfo['start_minute'] : '00';
        $classStart = "$classDate {$csInfo['start_hour']}:$start_minute:00";
        $timeNow = time();
        if (strtotime($classStart) <= $timeNow) exception('已经开课,不可预约!');

        //获取当天预约情况
        $classDate = strtotime($classDate);
        $classDateEnd = strtotime('+ 1 day', $classDate);
        $dateBookNum = Db::name('book_class')
            ->where('class_sch_id', $csId)
            ->where('class_start_time', 'between', [$classDate, $classDateEnd])
            ->where('cancel_flag', BookClassModel::UN_CANCEL)
            ->count();

        if ($dateBookNum >= $csInfo['study_num']) exception('课程已约满,请选择其它课程!');

        return true;
    }

    /**
     * @desc:检查学生状态
     * @date:2020/8/30 下午6:29
     * @param: $studentId 学生id
     * @param: $csId 课表id
     * @param: $classDate 约课时间
     * @return bool :maxed
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @author:abner<turing_zhy@163.com>
     */
    private function checkStudent($studentId, $csId, $classDate)
    {
        $now = time();
        $monday = strtotime('this week monday', $now);
        $sunday = strtotime('this week sunday', $now);
        $classDate = strtotime($classDate);
        //检查约课时间在本周
        if ($classDate < $monday || $classDate > $sunday) {
            exception('只能预约本周课程!');
        }

        //检查学生
        $studentInfo = Db::name('student')
            ->where('id', $studentId)
            ->field('id,delete_flag')
            ->find();

        if (!$studentInfo) exception('未找到学生信息!');
        if ($studentInfo['delete_flag'] == self::DELETE_FLAG_TRUE) exception('学生被删除,请联系学校!');

        //检查会员卡信息
        $cardInfo = Db::name('student_card')
            ->where('student_id', $studentId)
            ->where('enable_flag', StudentCardModel::ENABLE)
            ->field(
                'delete_flag,enable_flag,learned_num,study_num,freeze_to_day,effect_start,effect_end,' .
                'card_type,week_num'
            )
            ->find();
        if (!$cardInfo) exception('未找到会员卡信息');
        if ($cardInfo['delete_flag'] == self::DELETE_FLAG_TRUE) exception('会员卡被删除，请联系学校!');
        if ($cardInfo['freeze_to_day'] > $now) exception('还未到解冻时间');
        if ($cardInfo['learned_num'] >= $cardInfo['study_num']) exception('会员卡已消费结束,请及时充值!');
        if ($cardInfo['effect_start'] > $now) exception('会员卡还未到开始使用时间!');;
        if ($cardInfo['effect_end'] < $now) exception('会员卡已过期!');

        //检查该学生约课情况
        $classDateEnd = strtotime('+ 1 day', $classDate);
        $bookFlag = Db::name('book_class')
            ->where('student_id', $studentId)
            ->where('class_sch_id', $csId)
            ->where('class_start_time', 'between', [$classDate, $classDateEnd])
            ->where('cancel_flag', BookClassModel::UN_CANCEL)
            ->value('id');
        if ($bookFlag) exception('你已经预约了当日该节课程!');

        //检查该学生改周约课情况
        $weekStart = strtotime('this week Monday', $classDate);
        $weekEnd = strtotime('last week Monday', $classDate);
        $weekBookNum = Db::name('book_class')
            ->where('student_id', $studentId)
            ->where('class_start_time', 'between', [$weekStart, $weekEnd])
            ->where('cancel_flag', BookClassModel::UN_CANCEL)
            ->count();
        if ($cardInfo['card_type'] == VipCardModel::TIME_VIP_CARD && $weekBookNum >= $cardInfo['week_num']) {
            exception("本周预约超过限制{$cardInfo['week_num']}次");
        }

        return true;
    }

    /**
     * @api {POST} https://www.loshare.club/api.php/student/student/freezeClass 6-冻结课程
     * @apiVersion 1.0.0
     * @apiGroup NEED
     *
     * @apiParam {String} start_date 冻结开始eg:2020-09-02
     * @apiParam {String} end_date 冻结结束eg:2020-09-31
     *
     * @apiDescription 注意绑定用户后，需要在请求头加上Open-Id --小程序open_id，确认用户身份(本接口需要)
     *
     *
     * @apiSuccess {Object} code 返回码
     * @apiSuccess {Object} msg  中文解释
     * @apiSuccess {String[]} data  返回数据
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *         "code": 1,
     *         "msg": "成功",
     *         "data": "",
     *     }
     */
    public function freezeClass()
    {
        $studentId = $this->getUserId();
        $startDate = trim($this->request->param('start_date'));
        $endDate = trim($this->request->param('end_date'));
        trace('abner_test' . $startDate, 'info');
        trace('abner_test' . $endDate, 'info');
        //检测冻结
        try {
            $this->checkFreezeStatus($studentId, $startDate, $endDate);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        //执行冻结
        try {
            $this->doFreeze($studentId, $startDate, $endDate);
        } catch (Exception $e) {
            $this->error($e->getMessage());
        }

        $this->success('成功');
    }

    /**
     * @desc: 执行冻结
     * @date:2020/8/31 上午7:27
     * @param $studentId
     * @param $startDate
     * @param $endDate
     * @return bool :maxed
     * @throws DataNotFoundException
     * @throws DbException
     * @throws ModelNotFoundException
     * @throws Exception
     * @throws PDOException
     * @author:abner<turing_zhy@163.com>
     */
    private function doFreeze($studentId, $startDate, $endDate)
    {
        $cardInfo = Db::name('student_card')
            ->where('student_id', $studentId)
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where('enable_flag', StudentCardModel::ENABLE)
            ->field('id,had_freeze_num,freeze_timestamp')
            ->find();

        if (!$cardInfo) exception('未找到会员卡信息!');

        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        $timeNow = time();

        $cardData = [
            'freeze_to_day' => $endDate,
            'had_freeze_num' => $cardInfo['had_freeze_num'] + 1,
            'freeze_timestamp' => $cardInfo['freeze_timestamp'] + ($endDate - $startDate),
        ];

        $logData = [
            'student_id' => $studentId,
            'st_card_id' => $cardInfo['id'],
            'freeze_start' => $startDate,
            'freeze_end' => $endDate,
            'create_time' => $timeNow,
            'update_time' => $timeNow,
        ];

        //冻结会员卡
        Db::startTrans();
        $freezeFlag = Db::name('student_card')
            ->where('id', $cardInfo['id'])
            ->update($cardData);

        if (!$freezeFlag) {
            Db::rollback();
            exception('冻结会员卡失败!');
        }

        //记录冻结日志
        $logFlag = Db::name('freeze_log')->insert($logData);

        if (!$logFlag) {
            Db::rollback();
            exception('记录冻结日志失败!');
        }

        Db::commit();

        return true;
    }

    /**
     * @desc:检查冻结状态
     * @date:2020/8/30 下午9:51
     * @param: $studentId 学生id
     * @param: $startDate 冻结时段
     * @param: $endDate 冻结时段
     * @return bool :maxed
     * @throws DataNotFoundException
     * @throws ModelNotFoundException
     * @throws DbException
     * @author:abner<turing_zhy@163.com>
     */
    private function checkFreezeStatus($studentId, $startDate, $endDate)
    {
        $cardInfo = Db::name('student_card')
            ->where('student_id', $studentId)
            ->where('delete_flag', self::DELETE_FLAG_FALSE)
            ->where('enable_flag', StudentCardModel::ENABLE)
            ->field(
                'freeze_num,freeze_to_day,had_freeze_num,freeze_min_day,effect_start,effect_end,' .
                'freeze_timestamp'
            )
            ->find();

        if (!$cardInfo) exception('未找到会员卡信息!');
        $timeNow = time();
        if ($timeNow < $cardInfo['freeze_to_day']) exception('会员卡还在冻结状态!');
        if ($cardInfo['had_freeze_num'] >= $cardInfo['freeze_num']) {
            exception('冻结次数已达上限!');
        }

        //冻结时间判断
        $startDate = strtotime($startDate);
        $endDate = strtotime($endDate);
        if ($endDate <= $startDate) exception('冻结开始时间大于结束时间!');
        if ($endDate - $startDate < $cardInfo['freeze_min_day'] * 24 * 60 * 60) {
            exception("冻结最小间隔为{$cardInfo['freeze_min_day']}天!");
        }
        if ($endDate - $startDate > $cardInfo['effect_end'] - $cardInfo['effect_start'] - $cardInfo['freeze_timestamp']) {
            exception('总冻结时长不可超过有效期!');
        }

        return true;
    }

    /**
     * @api {POST} https://www.loshare.club/api.php/student/student/getOpenId 7-获取openid
     * @apiVersion 1.0.0
     * @apiGroup NEED
     *
     * @apiParam {String} code 前端login时获取的code
     *
     * @apiSuccess {Object} code 返回码
     * @apiSuccess {Object} msg  中文解释
     * @apiSuccess {String[]} data  返回数据
     * @apiSuccess {String} data.session_key  会话密钥
     * @apiSuccess {String} data.openid  用户唯一标识
     *
     * @apiSuccessExample {json} Success-Response:
     *     HTTP/1.1 200 OK
     *     {
     *       "code": 1,
     *       "msg": "成功",
     *       "data": {
     *         "session_key": "/Lvkv4tifgACOOfPSeksGw==",
     *         "openid": "oOj735eFPwiNx9hRoIhgZDT12Mds"
     *       }
     *     }
     * @apiErrorExample {json} Error-Response:
     *    {
     *      "code": 0,
     *      "msg": "code been used, hints: [ req_id: UJjeEVDNRa-jd0LoA ]",
     *      "data": ""
     *    }
     */
    public function getOpenId()
    {
        $code = trim($this->request->param('code'));
        $secret = self::APP_SECRET;
        $appid = self::APPID;
        $url = "https://api.weixin.qq.com/sns/jscode2session?appid=" . $appid . "&secret=" . $secret . "&js_code=" . $code . "&grant_type=authorization_code";

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, 30);

        $content = curl_exec($ch);
        $status = (int)curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($status == 404) {
            return $status;
        }
        curl_close($ch);

        $contentArr = json_decode($content, true);

        if (isset($contentArr['errcode'])) {
            $this->error($contentArr['errmsg']);
        } else {
            $this->success('成功', $contentArr);
        }
    }
}
