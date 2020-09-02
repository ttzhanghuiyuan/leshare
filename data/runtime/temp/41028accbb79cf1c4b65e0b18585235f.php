<?php /*a:2:{s:84:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/trail_class_user/edit.html";i:1597568843;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1596947788;}*/ ?>
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
			<li><a href="<?php echo url('trail_class_user/index'); ?>"><?php echo lang('试听用户管理'); ?></a></li>
			<li><a href="<?php echo url('trail_class_user/add'); ?>"><?php echo lang('试听用户添加'); ?></a></li>
			<li class="active"><a>编辑试听用户</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('TrailClassUser/editPost'); ?>">
			<div class="form-group">
				<label for="input-phone" class="col-sm-2 control-label"><span class="form-required">*</span><?php echo lang('试听用户电话'); ?></label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-phone" name="phone" value="<?php echo $phone; ?>">
				</div>
			</div>

			<div class="form-group">
				<label for="input-user-name" class="col-sm-2 control-label"><span class="form-required">*</span><?php echo lang('试听用户姓名'); ?></label>
				<div class="col-md-6 col-sm-10">
					<input type="text" class="form-control" id="input-user-name" name="user_name" value="<?php echo $user_name; ?>">
				</div>
			</div>

			<!--购买意向-->
			<div class="form-group">
				<label for="input-buy-purpose" class="col-sm-2 control-label"><span class="form-required">*</span><?php echo lang('购买意向'); ?></label>
				<div class="col-md-6 col-sm-10">
					<select id="input-buy-purpose" class="form-control" name="buy_purpose" style="width: 150px;">
						<?php if(is_array($buy_purpose_arr) || $buy_purpose_arr instanceof \think\Collection || $buy_purpose_arr instanceof \think\Paginator): if( count($buy_purpose_arr)==0 ) : echo "" ;else: foreach($buy_purpose_arr as $key=>$vo): $type_selected=isset($buy_purpose)&&$buy_purpose==$key?"selected":""; ?>
							<option value="<?php echo $key; ?>" <?php echo $type_selected; ?>><?php echo $vo; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>

			<!--            渠道-->
			<div class="form-group">
				<label for="input-channel-id" class="col-sm-2 control-label"><span class="form-required">*</span><?php echo lang('渠道'); ?></label>
				<div class="col-md-6 col-sm-10">
					<select id="input-channel-id" class="form-control" name="channel_id" style="width: 150px;">
						<?php if(is_array($channel_list) || $channel_list instanceof \think\Collection || $channel_list instanceof \think\Paginator): if( count($channel_list)==0 ) : echo "" ;else: foreach($channel_list as $key=>$vo): $channel_selected=isset($channel_id)&&$channel_id==$vo['id']?"selected":""; ?>
							<option value="<?php echo $vo['id']; ?>" <?php echo $channel_selected; ?>><?php echo $vo['channel_name']; ?></option>
						<?php endforeach; endif; else: echo "" ;endif; ?>
					</select>
				</div>
			</div>

			<div class="form-group">
				<label for="input-desc-str" class="col-sm-2 control-label"><span class="form-required">*</span><?php echo lang('描述'); ?></label>
				<div class="col-md-6 col-sm-10">
					<textarea class="form-control" id="input-desc-str" name="desc_str"><?php echo $desc_str; ?><?php echo $buy_purpose; ?><?php echo $channel_id; ?></textarea>
				</div>
			</div>


			<div class="form-group">
				<div class="col-sm-offset-2 col-sm-10">
					<input type="hidden" name="id" value="<?php echo $id; ?>" />
					<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
					<a class="btn btn-default" href="javascript:history.back(-1);"><?php echo lang('BACK'); ?></a>
				</div>
			</div>
		</form>
	</div>
	<script src="/static/js/admin.js"></script>
</body>
</html>