<?php /*a:2:{s:82:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/class_schedule/edit.html";i:1598776704;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <!-- Set render engine for 360 browser -->
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->


    <link href="/themes/admin_simpleboot3/public/assets/themes/<?php echo cmf_get_admin_style(); ?>/bootstrap.min.css" rel="stylesheet">
    <link href="/themes/admin_simpleboot3/public/assets/simpleboot3/css/simplebootadmin.css" rel="stylesheet">
    <link href="/static/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

    <script type="text/javascript">
        //全局变量
        var GV = {
            ROOT: "/",
            WEB_ROOT: "/",
            JS_ROOT: "static/js/",
            APP: '<?php echo app('request')->module(); ?>'/*当前应用名*/
        };
    </script>
    <script src="/themes/admin_simpleboot3/public/assets/js/jquery-1.10.2.min.js"></script>
    <script src="/static/js/wind.js"></script>
    <script src="/themes/admin_simpleboot3/public/assets/js/bootstrap.min.js"></script>
    <script>
        Wind.css('artDialog');
        Wind.css('layer');
        $(function () {
            $("[data-toggle='tooltip']").tooltip({
                container:'body',
                html:true,
            });
            $("li.dropdown").hover(function () {
                $(this).addClass("open");
            }, function () {
                $(this).removeClass("open");
            });
        });
    </script>
    <?php if(APP_DEBUG): ?>
        <style>
            #think_page_trace_open {
                z-index: 9999;
            }
        </style>
    <?php endif; ?>
</head>
<body>
<div class="wrap">
    <ul class="nav nav-tabs">
        <li><a href="<?php echo url('class_schedule/index'); ?>"><?php echo lang('课表'); ?></a></li>
        <li><a href="<?php echo url('class_schedule/add'); ?>"><?php echo lang('课表添加'); ?></a></li>
        <li class="active"><a>课表编辑</a></li>
    </ul>
    <form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('ClassSchedule/editPost'); ?>">
        <div class="form-group">
            <!--课表类型-->
            <div class="form-group">
                <label for="input-sch-type" class="col-sm-2 control-label">
                    <span class="form-required">*</span><?php echo lang('课表类型'); ?></label>
                <div class="col-md-6 col-sm-10">
                    <select class="form-control" name="sch_type" id="input-sch-type" style="width: 150px;">
                        <?php if(is_array($sch_type_list) || $sch_type_list instanceof \think\Collection || $sch_type_list instanceof \think\Paginator): if( count($sch_type_list)==0 ) : echo "" ;else: foreach($sch_type_list as $key=>$vo): $st_selected=isset($sch_type)&&$sch_type==$key?"selected":""; ?>
                            <option value="<?php echo $key; ?>" <?php echo $st_selected; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>

            <!--课程等级-->
            <div class="form-group">
                <label for="input-level-id" class="col-sm-2 control-label">
                    <span class="form-required">*</span><?php echo lang('课程等级'); ?></label>
                <div class="col-md-6 col-sm-10">
                    <select class="form-control" name="level_id" id="input-level-id" style="width: 150px;">
                        <?php if(is_array($class_level_list) || $class_level_list instanceof \think\Collection || $class_level_list instanceof \think\Paginator): if( count($class_level_list)==0 ) : echo "" ;else: foreach($class_level_list as $key=>$vo): $li_selected=isset($level_id)&&$level_id==$key?"selected":""; ?>
                            <option value="<?php echo $vo['id']; ?>" <?php echo $li_selected; ?>><?php echo $vo['name']; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>

            <!--报名人数-->
            <div class="form-group">
                <label for="input-study-num" class="col-sm-2 control-label">
                    <span class="form-required">*</span><?php echo lang('班级容量'); ?></label>
                <div class="col-md-2 col-sm-3">
                    <input value="<?php echo $study_num; ?>" type="text" class="form-control" id="input-study-num" name="study_num">
                </div>
            </div>

            <!--课程开始时间-->
            <div class="form-group">
                <label for="input-start-hour" class="col-sm-2 control-label">
                    <span class="form-required">*</span><?php echo lang('开始时间-时'); ?></label>
                <div class="col-md-2 col-sm-3">
                    <input value="<?php echo $start_hour; ?>" type="text" class="form-control" id="input-start-hour" name="start_hour">
                </div>
            </div>

            <!--课程开始时间-->
            <div class="form-group">
                <label for="input-start-minute" class="col-sm-2 control-label">
                    <?php echo lang('开始时间-分'); ?>
                </label>
                <div class="col-md-2 col-sm-3">
                    <input value="<?php echo $start_minute; ?>" type="text" class="form-control" id="input-start-minute" name="start_minute">
                </div>
            </div>

            <!--课程结束时间-->
            <div class="form-group">
                <label for="input-end-hour" class="col-sm-2 control-label">
                    <span class="form-required">*</span><?php echo lang('结束时间-时'); ?></label>
                <div class="col-md-2 col-sm-3">
                    <input value="<?php echo $end_hour; ?>" type="text" class="form-control" id="input-end-hour" name="end_hour">
                </div>
            </div>

            <!--课程结束时间-->
            <div class="form-group">
                <label for="input-end-minute" class="col-sm-2 control-label">
                    <?php echo lang('结束时间-分'); ?>
                </label>
                <div class="col-md-2 col-sm-3">
                    <input value="<?php echo $end_minute; ?>" type="text" class="form-control" id="input-end-minute" name="end_minute">
                </div>
            </div>

            <!--课程时间-->
            <div class="form-group">
                <label for="input-class-date" class="col-sm-2 control-label">
                    <?php echo lang('课程时间'); ?>
                </label>
                <div class="col-md-2 col-sm-3">
                    <input class="js-date"
                           value="<?php echo $class_date; ?>"
                           type="text"
                           id="input-class-date"
                           placeholder="2013-01-04"
                           name="class_date">
                </div>
            </div>

            <!--启用标识-->
            <div class="form-group">
                <label for="input-enable-flag" class="col-sm-2 control-label">
                    <?php echo lang('启用'); ?>
                </label>
                <div class="col-md-3 col-sm-5">
                    <select class="form-control" name="enable_flag" id="input-enable-flag" style="width: 150px;">
                        <?php if(is_array($enable_flag_list) || $enable_flag_list instanceof \think\Collection || $enable_flag_list instanceof \think\Paginator): if( count($enable_flag_list)==0 ) : echo "" ;else: foreach($enable_flag_list as $key=>$vo): $ef_selected=isset($enable_flag)&&$enable_flag==$key?"selected":""; ?>
                            <option value="<?php echo $key; ?>" <?php echo $ef_selected; ?>><?php echo $vo; ?></option>
                        <?php endforeach; endif; else: echo "" ;endif; ?>
                    </select>
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
                <a class="btn btn-default" href="javascript:history.back(-1);"><?php echo lang('BACK'); ?></a>
            </div>
        </div>
    </form>
</div>
<script src="/static/js/admin.js"></script>
</body>
</html>