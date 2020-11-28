<?php /*a:2:{s:83:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/class_schedule/index.html";i:1606538095;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
			<li class="active"><a href="<?php echo url('class_schedule/index'); ?>"><?php echo lang('课表管理'); ?></a></li>
			<li><a href="<?php echo url('class_schedule/add'); ?>"><?php echo lang('课表添加'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('ClassSchedule/index'); ?>">
			校区:
			<select class="form-control" name="school_id" id="input-school-id" style="width: 150px;">
				<?php if(is_array($school_list) || $school_list instanceof \think\Collection || $school_list instanceof \think\Paginator): if( count($school_list)==0 ) : echo "" ;else: foreach($school_list as $key=>$vo): $flag_selected=isset($school_id)&&$school_id==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $flag_selected; ?>><?php echo $vo['school_name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			课表类型:
			<select class="form-control" name="sch_type" id="input-sch-type" style="width: 150px;">
				<?php if(is_array($sch_type_list) || $sch_type_list instanceof \think\Collection || $sch_type_list instanceof \think\Paginator): if( count($sch_type_list)==0 ) : echo "" ;else: foreach($sch_type_list as $key=>$vo): $st_selected=isset($sch_type_selected)&&$sch_type_selected==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $st_selected; ?>><?php echo $vo; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>

			课程等级:
			<select class="form-control" name="level_id" id="input-level-id" style="width: 150px;">
				<?php if(is_array($class_level_list) || $class_level_list instanceof \think\Collection || $class_level_list instanceof \think\Paginator): if( count($class_level_list)==0 ) : echo "" ;else: foreach($class_level_list as $key=>$vo): $li_selected=isset($level_id_selected)&&$level_id_selected==$vo['id']?"selected":""; ?>
					<option value="<?php echo $vo['id']; ?>" <?php echo $li_selected; ?>><?php echo $vo['name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>

			周:
			<select class="form-control" name="week" id="input-week" style="width: 150px;">
				<?php if(is_array($week_list) || $week_list instanceof \think\Collection || $week_list instanceof \think\Paginator): if( count($week_list)==0 ) : echo "" ;else: foreach($week_list as $key=>$vo): $w_selected=isset($week_selected)&&$week_selected==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $w_selected; ?>><?php echo $vo; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			启用:
			<select class="form-control" name="enable_flag" id="input-channel" style="width: 150px;">
				<?php if(is_array($enable_flag_list) || $enable_flag_list instanceof \think\Collection || $enable_flag_list instanceof \think\Paginator): if( count($enable_flag_list)==0 ) : echo "" ;else: foreach($enable_flag_list as $key=>$vo): $ef_selected=isset($enable_flag_selected)&&$enable_flag_selected==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $ef_selected; ?>><?php echo $vo; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>

            <input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('ClassSchedule/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th><?php echo lang('校区'); ?></th>
					<th><?php echo lang('课表类型'); ?></th>
					<th><?php echo lang('课程等级'); ?></th>
					<th><?php echo lang('周'); ?></th>
					<th><?php echo lang('班级容量'); ?></th>
					<th><?php echo lang('开始时间'); ?></th>
					<th><?php echo lang('结束时间'); ?></th>
					<th><?php echo lang('课程日期'); ?></th>
					<th><?php echo lang('报名人数'); ?></th>
					<th><?php echo lang('启用标识'); ?></th>
					<th><?php echo lang('创建时间'); ?></th>
					<th width="100"><?php echo lang('ACTIONS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($class_schedule) || $class_schedule instanceof \think\Collection || $class_schedule instanceof \think\Paginator): if( count($class_schedule)==0 ) : echo "" ;else: foreach($class_schedule as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td>
						<?php if($vo['school_id'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo $school_list[$vo['school_id']]['school_name']; ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['sch_type'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo $sch_type_list[$vo['sch_type']]; ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['name']; ?></td>
					<td>
						<?php if($vo['week'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo $week_list[$vo['week']]; ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['study_num']; ?></td>
					<td>
						<?php if($vo['start_hour'] == 0): ?>
							<?php echo lang('-'); else: if($vo['start_minute'] == 0): ?>
								<?php echo $vo['start_hour']; ?>:00
								<?php else: ?>
								<?php echo $vo['start_hour']; ?>:<?php echo $vo['start_minute']; ?>
							<?php endif; ?>
						<?php endif; ?>
					</td>

					<td>
						<?php if($vo['end_hour'] == 0): ?>
							<?php echo lang('-'); else: if($vo['end_minute'] == 0): ?>
								<?php echo $vo['end_hour']; ?>:00
								<?php else: ?>
								<?php echo $vo['end_hour']; ?>:<?php echo $vo['end_minute']; ?>
							<?php endif; ?>
						<?php endif; ?>
					</td>

					<td>
						<?php if($vo['class_date'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d',$vo['class_date']); ?>
						<?php endif; ?>
					</td>

					<td><?php echo $vo['book_num']; ?></td>

					<td>
						<?php if($vo['enable_flag'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo $enable_flag_list[$vo['enable_flag']]; ?>
						<?php endif; ?>
					</td>

					<td>
						<?php if($vo['create_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i:s',$vo['create_time']); ?>
						<?php endif; ?>
					</td>

					<td>
						<a class="btn btn-xs btn-primary"
						   href='<?php echo url("class_schedule/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
						<a class="btn btn-xs btn-danger js-ajax-delete"
						   href="<?php echo url('class_schedule/delete',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
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