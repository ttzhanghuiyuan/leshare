<?php /*a:2:{s:81:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/student_card/index.html";i:1600585118;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo url('student_card/index'); ?>"><?php echo lang('学生会员卡'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('StudentCard/index'); ?>">
			学生电话:
			<input type="text" class="form-control" name="phone" style="width: 130px;" value="<?php echo input('request.phone/s',''); ?>" placeholder="请输入<?php echo lang('学生电话'); ?>">
            卡片名称:
            <input type="text" class="form-control" name="card_name" style="width: 130px;" value="<?php echo input('request.card_name/s',''); ?>" placeholder="请输入<?php echo lang('卡片名称'); ?>">
			卡片类型:
			<select class="form-control" name="card_type" id="input-card-type" style="width: 150px;">
				<?php if(is_array($card_type_list) || $card_type_list instanceof \think\Collection || $card_type_list instanceof \think\Paginator): if( count($card_type_list)==0 ) : echo "" ;else: foreach($card_type_list as $key=>$vo): $type_selected=isset($card_type_selected)&&$card_type_selected==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $type_selected; ?>><?php echo $vo; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			启用:
			<select class="form-control" name="enable_flag" id="input-enable-flag" style="width: 150px;">
				<?php if(is_array($enable_flag_list) || $enable_flag_list instanceof \think\Collection || $enable_flag_list instanceof \think\Paginator): if( count($enable_flag_list)==0 ) : echo "" ;else: foreach($enable_flag_list as $key=>$vo): $flag_selected=isset($enable_flag_selected)&&$enable_flag_selected==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $flag_selected; ?>><?php echo $vo; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			<input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('StudentCard/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th><?php echo lang('学生姓名'); ?></th>
					<th><?php echo lang('会员卡名称'); ?></th>
					<th><?php echo lang('会员卡类型'); ?></th>
					<th><?php echo lang('总次数'); ?></th>
					<th><?php echo lang('有效期'); ?></th>
					<th><?php echo lang('冻结次数'); ?></th>
					<th><?php echo lang('冻结最少天数'); ?></th>
					<th><?php echo lang('每周次数'); ?></th>
					<th><?php echo lang('学习次数'); ?></th>
					<th><?php echo lang('剩余次数'); ?></th>
					<th><?php echo lang('上次学习时间'); ?></th>
					<th><?php echo lang('是否启用'); ?></th>
					<th><?php echo lang('创建日期'); ?></th>
					<th width="140"><?php echo lang('ACTIONS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($student_card) || $student_card instanceof \think\Collection || $student_card instanceof \think\Paginator): if( count($student_card)==0 ) : echo "" ;else: foreach($student_card as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['name']; ?>-<?php echo $vo['student_id']; ?></td>
					<td><?php echo $vo['card_name']; ?></td>
					<td>
						<?php if($vo['card_type'] == 0): ?>
							<?php echo lang('-'); else: ?>
                            <?php echo $card_type_list[$vo['card_type']]; ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['study_num']; ?></td>
					<td>
						<?php if($vo['effect_start'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d',$vo['effect_start']); ?>
						<?php endif; if($vo['effect_end'] == 0): else: ?>
							至<?php echo date('Y-m-d',$vo['effect_end']); ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['freeze_num']; ?></td>
					<td><?php echo $vo['freeze_min_day']; ?>天</td>
					<td><?php echo $vo['week_num']; ?></td>
					<td><?php echo $vo['learned_num']; ?></td>
					<td><?php echo $vo['study_num']-$vo['learned_num']; ?></td>
					<td>
						<?php if($vo['last_learn_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i',$vo['last_learn_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['enable_flag'] == 1): ?>
							<?php echo lang('启用'); else: ?>
							<?php echo lang('未启用'); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['create_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i',$vo['create_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<a class="btn btn-xs btn-primary"
						   href='<?php echo url("student_card/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
						<a class="btn btn-xs btn-primary"
						   href='<?php echo url("student_card/buckle",array("id"=>$vo["id"])); ?>'><?php echo lang('扣课'); ?></a>
						<a class="btn btn-xs btn-danger js-ajax-delete"
						   href="<?php echo url('student_card/delete',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
					</td>
				</tr>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo $page; ?></div>
	</div>
	<script src="/static/js/admin.js"></script>
</body>
</html>