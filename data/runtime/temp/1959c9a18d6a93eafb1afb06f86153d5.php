<?php /*a:2:{s:76:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/student/index.html";i:1606527090;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
			<li class="active"><a href="<?php echo url('student/index'); ?>"><?php echo lang('学生管理'); ?></a></li>
			<li><a href="<?php echo url('student/add'); ?>"><?php echo lang('学生添加'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('Student/index'); ?>">
            电话:
            <input type="text" class="form-control" name="phone" style="width: 130px;" value="<?php echo input('request.phone/s',''); ?>" placeholder="请输入<?php echo lang('学生电话'); ?>">
			姓名:
			<input type="text" class="form-control" name="name" style="width: 130px;" value="<?php echo input('request.name/s',''); ?>" placeholder="请输入<?php echo lang('学生姓名'); ?>">
			昵称:
			<input type="text" class="form-control" name="nick" style="width: 130px;" value="<?php echo input('request.nick/s',''); ?>" placeholder="请输入<?php echo lang('学生昵称'); ?>">
			校区:
			<select class="form-control" name="school_id" id="input-school-id" style="width: 150px;">
				<?php if(is_array($school_list_for_select) || $school_list_for_select instanceof \think\Collection || $school_list_for_select instanceof \think\Paginator): if( count($school_list_for_select)==0 ) : echo "" ;else: foreach($school_list_for_select as $key=>$vo): $flag_selected=isset($school_id_selected)&&$school_id_selected==$vo['id']?"selected":""; ?>
					<option value="<?php echo $vo['id']; ?>" <?php echo $flag_selected; ?>><?php echo $vo['school_name']; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			<input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('Student/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th><?php echo lang('姓名'); ?></th>
					<th><?php echo lang('校区'); ?></th>
					<th><?php echo lang('昵称'); ?></th>
					<th><?php echo lang('微信昵称'); ?></th>
					<th><?php echo lang('年龄'); ?></th>
					<th><?php echo lang('家长姓名'); ?></th>
					<th><?php echo lang('电话号码'); ?></th>
					<th><?php echo lang('生日'); ?></th>
					<th><?php echo lang('性别'); ?></th>
					<th><?php echo lang('密码'); ?></th>
					<th><?php echo lang('创建日期'); ?></th>
					<th width="140"><?php echo lang('ACTIONS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($student) || $student instanceof \think\Collection || $student instanceof \think\Paginator): if( count($student)==0 ) : echo "" ;else: foreach($student as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['name']; ?></td>
					<td>
						<?php if($vo['school_id'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo $school_list[$vo['school_id']]['school_name']; ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['nick']; ?></td>
					<td><?php echo $vo['wx_nick']; ?></td>
					<td><?php echo $vo['age']; ?></td>
					<td><?php echo $vo['parent_name']; ?></td>
					<td><?php echo $vo['phone']; ?></td>
					<td>
						<?php if($vo['birthday'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d',$vo['birthday']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['sex'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo $sex[$vo['sex']]; ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['pass']; ?></td>
					<td>
						<?php if($vo['create_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i:s',$vo['create_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<a class="btn btn-xs btn-primary"
						   href='<?php echo url("student/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
						<a class="btn btn-xs btn-primary"
						   href="<?php echo url('student_card/add',array('id'=>$vo['id'])); ?>"><?php echo lang('绑卡'); ?></a>
						<a class="btn btn-xs btn-danger js-ajax-delete"
						   href="<?php echo url('student/delete',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
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