<?php /*a:2:{s:80:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/trial_class/index.html";i:1596953240;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1596947788;}*/ ?>
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
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo url('trial_class/index'); ?>"><?php echo lang('ADMIN_USER_INDEX'); ?></a></li>
			<li><a href="<?php echo url('trial_class/add'); ?>"><?php echo lang('ADMIN_USER_ADD'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('TrialClass/index'); ?>">
            邮箱:
            <input type="text" class="form-control" name="channel_name" style="width: 120px;" value="<?php echo input('request.channel_name/s',''); ?>" placeholder="请输入<?php echo lang('渠道名称'); ?>">
            <input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('TrialClass/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th><?php echo lang('CHANNEL_NAME'); ?></th>
					<th><?php echo lang('CREATE_TIME'); ?></th>
					<th><?php echo lang('UPDATE_TIME'); ?></th>
					<th><?php echo lang('DELETE_FLAG'); ?></th>
					<th width="140"><?php echo lang('ACTIONS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($channel) || $channel instanceof \think\Collection || $channel instanceof \think\Paginator): if( count($channel)==0 ) : echo "" ;else: foreach($channel as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['channel_name']; ?></td>
					<td>
						<?php if($vo['create_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i:s',$vo['create_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['update_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i:s',$vo['update_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php switch($vo['delete_flag']): case "1": ?>
								<span class="label label-success">删除</span>
							<?php break; case "2": ?>
								<span class="label label-warning">未删除</span>
							<?php break; ?>
						<?php endswitch; ?>
					</td>
					<td>
						<?php if($vo['id'] == 1 || $vo['id'] == cmf_get_current_admin_id()): ?>
							<span class="btn btn-xs btn-primary disabled"><?php echo lang('EDIT'); ?></span>
							<span class="btn btn-xs btn-danger disabled"><?php echo lang('DELETE'); ?></span>
							<?php if($vo['trial_class_status'] == 1): ?>
								<span class="btn btn-xs btn-danger disabled"><?php echo lang('BLOCK_USER'); ?></span>
							<?php else: ?>
								<span class="btn btn-xs btn-warning disabled"><?php echo lang('ACTIVATE_USER'); ?></span>
							<?php endif; else: ?>
							<a class="btn btn-xs btn-primary" href='<?php echo url("trial_class/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
							<a class="btn btn-xs btn-danger js-ajax-delete" href="<?php echo url('trial_class/delete',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
							<?php if($vo['trial_class_status'] == 1): ?>
								<a class="btn btn-xs btn-danger js-ajax-dialog-btn" href="<?php echo url('trial_class/ban',array('id'=>$vo['id'])); ?>" data-msg="<?php echo lang('BLOCK_USER_CONFIRM_MESSAGE'); ?>"><?php echo lang('BLOCK_USER'); ?></a>
							<?php else: ?>
								<a class="btn btn-xs btn-warning js-ajax-dialog-btn" href="<?php echo url('trial_class/cancelban',array('id'=>$vo['id'])); ?>" data-msg="<?php echo lang('ACTIVATE_USER_CONFIRM_MESSAGE'); ?>"><?php echo lang('ACTIVATE_USER'); ?></a>
							<?php endif; ?>
						<?php endif; ?>
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