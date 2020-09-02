<?php /*a:2:{s:79:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/student_card/add.html";i:1598173420;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
			<li><a href="<?php echo url('student_card/index'); ?>"><?php echo lang('学生会员卡'); ?></a></li>
			<li class="active"><a href="<?php echo url('student_card/add'); ?>"><?php echo lang('绑卡'); ?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('student_card/addpost'); ?>">
			<input value="<?php echo $student_id; ?>" name="student_id"  type="hidden">
			<!--学生信息展示-->
			<div class="form-group">
				<label for="input-student-name" class="col-sm-2 control-label">
					<span class="form-required">*</span>
					<?php echo lang('学生姓名'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input value="<?php echo $student_info['name']; ?>-<?php echo $student_info['id']; ?>" type="text" class="form-control" id="input-student-name" name="name">
				</div>
			</div>

			<!--卡片选择-->
			<div class="form-group">
				<label for="input-buy-purpose" class="col-sm-2 control-label">
					<span class="form-required">*</span>
					<?php echo lang('选择卡片'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<select id="input-buy-purpose" class="form-control" name="card_id" style="width: 150px;">
						<?php if(is_array($vip_card_list) || $vip_card_list instanceof \think\Collection || $vip_card_list instanceof \think\Paginator): if( count($vip_card_list)==0 ) : echo "" ;else: foreach($vip_card_list as $key=>$vo): ?>
							<option value="<?php echo $vo['id']; ?>"><?php echo $vo['card_name']; ?>-<?php echo $vo['card_type_str']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('绑定'); ?></button>
				</div>
			</div>
		</form>
	</div>
	<script src="/static/js/admin.js"></script>
</body>
</html>