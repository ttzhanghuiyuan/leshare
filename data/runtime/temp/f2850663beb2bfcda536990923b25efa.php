<?php /*a:2:{s:75:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/vip_card/add.html";i:1598168264;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1596947788;}*/ ?>
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
    <style>
        form .input-order {
            margin-bottom: 0px;
            padding: 0 2px;
            width: 42px;
            font-size: 12px;
        }

        form .input-order:focus {
            outline: none;
        }

        .table-actions {
            margin-top: 5px;
            margin-bottom: 5px;
            padding: 0px;
        }

        .table-list {
            margin-bottom: 0px;
        }

        .form-required {
            color: red;
        }
    </style>
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
			<li><a href="<?php echo url('vip_card/index'); ?>"><?php echo lang('会员卡管理'); ?></a></li>
			<li class="active"><a href="<?php echo url('vip_card/add'); ?>"><?php echo lang('会员卡添加'); ?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('vip_card/addpost'); ?>">
            <!--会员卡名称-->
			<div class="form-group">
				<label for="input-card-name" class="col-sm-2 control-label">
					<span class="form-required">*</span>
					<?php echo lang('会员卡名称'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-card-name" name="card_name">
				</div>
			</div>

            <!--会员卡类型-->
			<div class="form-group">
				<label for="input-card-type" class="col-sm-2 control-label">
					<span class="form-required">*</span>
					<?php echo lang('会员卡类型'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<select class="form-control" name="card_type" id="input-card-type" style="width: 150px;">
						<?php if(is_array($card_type_list) || $card_type_list instanceof \think\Collection || $card_type_list instanceof \think\Paginator): if( count($card_type_list)==0 ) : echo "" ;else: foreach($card_type_list as $key=>$vo): $type_selected=isset($card_type_selected)&&$card_type_selected==$key?"selected":""; ?>
							<option value="<?php echo $key; ?>" <?php echo $type_selected; ?>><?php echo $vo; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>

			<!--学习次数-->
			<div class="form-group">
				<label for="input-study-num" class="col-sm-2 control-label">
					<?php echo lang('学习次数'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-study-num" name="study_num">
				</div>
			</div>

			<!--每周学习次数-->
			<div class="form-group">
				<label for="input-week-num" class="col-sm-2 control-label">
					<?php echo lang('每周学习次数'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-week-num"
						   name="week_num">
				</div>
			</div>

			<!--有效期-->
			<div class="form-group">
				<label for="input-effect-day" class="col-sm-2 control-label">
					<?php echo lang('有效期(天)'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-effect-day"
						   name="effect_day">
				</div>
			</div>

			<!--默认冻结次数-->
			<div class="form-group">
				<label for="input-default-freeze-num" class="col-sm-2 control-label">
					<?php echo lang('默认冻结允许次数'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-default-freeze-num"
						   name="default_freeze_num">
				</div>
			</div>

			<!--默认冻结最小天数-->
			<div class="form-group">
				<label for="input-default-freeze-min-day" class="col-sm-2 control-label">
					<?php echo lang('默认冻结最小天数'); ?>
				</label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-default-freeze-min-day"
						   name="default_freeze_min_day">
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