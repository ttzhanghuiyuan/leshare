<?php /*a:2:{s:74:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/student/add.html";i:1597583817;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
			<li><a href="<?php echo url('student/index'); ?>"><?php echo lang('学生管理'); ?></a></li>
			<li class="active"><a href="<?php echo url('student/add'); ?>"><?php echo lang('学生添加'); ?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('student/addpost'); ?>">
			<!--学生姓名-->
			<div class="form-group">
				<label for="input-name" class="col-sm-2 control-label">
					<span class="form-required">*</span>
					<?php echo lang('学生姓名'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-name" name="name">
				</div>
			</div>

            <!--学生昵称-->
			<div class="form-group">
				<label for="input-nick" class="col-sm-2 control-label">
					<?php echo lang('学生昵称'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-nick" name="nick">
				</div>
			</div>

			<!--年龄-->
			<div class="form-group">
				<label for="input-age" class="col-sm-2 control-label">
					<?php echo lang('年龄'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-age" name="age">
				</div>
			</div>

            <!--家长姓名-->
			<div class="form-group">
				<label for="input-parent-name" class="col-sm-2 control-label">
					<?php echo lang('家长姓名'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-parent-name" name="parent_name">
				</div>
			</div>

			<!--电话号码-->
			<div class="form-group">
				<label for="input-phone" class="col-sm-2 control-label">
					<span class="form-required">*</span>
					<?php echo lang('电话号码'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-phone" name="phone">
				</div>
			</div>

            <!--生日-->
			<div class="form-group">
				<label for="input-birthday" class="col-sm-2 control-label">
					<?php echo lang('生日'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input class="js-date"
						   type="text"
						   id="input-birthday"
						   placeholder="2013-01-04"
						   name="birthday">
				</div>
			</div>

			<!--性别-->
			<div class="form-group">
				<label for="input-buy-purpose" class="col-sm-2 control-label">
					<?php echo lang('性别'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<select id="input-buy-purpose" class="form-control" name="sex" style="width: 150px;">
						<?php if(is_array($sex) || $sex instanceof \think\Collection || $sex instanceof \think\Paginator): if( count($sex)==0 ) : echo "" ;else: foreach($sex as $key=>$vo): ?>
							<option value="<?php echo $key; ?>"><?php echo $vo; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('ADD'); ?></button>
				</div>
			</div>
		</form>
	</div>
	<script src="/static/js/admin.js"></script>
</body>
</html>