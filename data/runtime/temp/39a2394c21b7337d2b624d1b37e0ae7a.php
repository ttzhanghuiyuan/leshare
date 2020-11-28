<?php /*a:2:{s:79:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/book_class/index.html";i:1606543291;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
			<li class="active"><a href="<?php echo url('book_class/index'); ?>"><?php echo lang('约课记录'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('BookClass/index'); ?>">
			学生姓名:
			<input type="text" class="form-control" name="name" style="width: 130px;" value="<?php echo input('request.name/s',''); ?>" placeholder="请输入<?php echo lang('学生电话'); ?>">
			上课时间:
			<input class="js-date"
				   type="text"
				   id="input-date"
				   name="start_time"
				   value="<?php echo input('request.start_time/s',''); ?>">
			课表:
			<select class="form-control" name="schedule_id" id="input-schedule" style="width: 150px;">
				<?php if(is_array($schedule) || $schedule instanceof \think\Collection || $schedule instanceof \think\Paginator): if( count($schedule)==0 ) : echo "" ;else: foreach($schedule as $key=>$vo): $schedule_selected=isset($schedule_id_selected)&&$schedule_id_selected==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $schedule_selected; ?>><?php echo $vo['name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>

			校区:
			<select class="form-control" name="school_id" id="input-school-id" style="width: 150px;">
				<?php if(is_array($school_list) || $school_list instanceof \think\Collection || $school_list instanceof \think\Paginator): if( count($school_list)==0 ) : echo "" ;else: foreach($school_list as $key=>$vo): $flag_selected=isset($school_id)&&$school_id==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $flag_selected; ?>><?php echo $vo['school_name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>

			<input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('BookClass/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th><?php echo lang('学生姓名'); ?></th>
					<th><?php echo lang('校区'); ?></th>
					<th><?php echo lang('课程等级'); ?></th>
					<th><?php echo lang('是否取消'); ?></th>
					<th><?php echo lang('课程开始时间'); ?></th>
					<th><?php echo lang('课程结束时间'); ?></th>
					<th><?php echo lang('添加时间'); ?></th>
					<th width="140"><?php echo lang('ACTIONS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($book_class) || $book_class instanceof \think\Collection || $book_class instanceof \think\Paginator): if( count($book_class)==0 ) : echo "" ;else: foreach($book_class as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['s_name']; ?></td>
					<td>
						<?php if($vo['school_id'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo $school_list[$vo['school_id']]['school_name']; ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['level_name']; ?></td>
					<td>
						<?php if($vo['cancel_flag'] == 2): ?>
							<?php echo lang('未取消'); else: ?>
							<?php echo lang('取消'); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['class_start_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i',$vo['class_start_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['class_end_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i',$vo['class_end_time']); ?>
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
						   href='<?php echo url("book_class/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('修改'); ?></a>
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