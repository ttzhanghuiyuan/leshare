<?php /*a:2:{s:77:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/vip_card/index.html";i:1598170715;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1596947788;}*/ ?>
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
			<li class="active"><a href="<?php echo url('vip_card/index'); ?>"><?php echo lang('会员卡管理'); ?></a></li>
			<li><a href="<?php echo url('vip_card/add'); ?>"><?php echo lang('会员卡添加'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('VipCard/index'); ?>">
            卡片名称:
            <input type="text" class="form-control" name="card_name" style="width: 130px;" value="<?php echo input('request.card_name/s',''); ?>" placeholder="请输入<?php echo lang('卡片名称'); ?>">
			卡片类型:
			<select class="form-control" name="card_type" id="input-channel" style="width: 150px;">
				<?php if(is_array($card_type_list) || $card_type_list instanceof \think\Collection || $card_type_list instanceof \think\Paginator): if( count($card_type_list)==0 ) : echo "" ;else: foreach($card_type_list as $key=>$vo): $type_selected=isset($card_type_selected)&&$card_type_selected==$key?"selected":""; ?>
					<option value="<?php echo $key; ?>" <?php echo $type_selected; ?>><?php echo $vo; ?></option>
				<?php endforeach; endif; else: echo "" ;endif; ?>
			</select>
			<input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('VipCard/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th><?php echo lang('名称'); ?></th>
					<th width="80"><?php echo lang('类型'); ?></th>
					<th><?php echo lang('总次数'); ?></th>
					<th><?php echo lang('有效期'); ?></th>
					<th><?php echo lang('冻结次数'); ?></th>
					<th><?php echo lang('冻结最少天数'); ?></th>
					<th><?php echo lang('每周次数'); ?></th>
					<th><?php echo lang('创建日期'); ?></th>
					<th><?php echo lang('修改日期'); ?></th>
					<th width="140"><?php echo lang('ACTIONS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($vip_card) || $vip_card instanceof \think\Collection || $vip_card instanceof \think\Paginator): if( count($vip_card)==0 ) : echo "" ;else: foreach($vip_card as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['card_name']; ?></td>
					<td>
						<?php if($vo['card_type'] == 0): ?>
							<?php echo lang('-'); else: ?>
                            <?php echo $card_type_list[$vo['card_type']]; ?>
						<?php endif; ?>
					</td>
					<td><?php echo $vo['study_num']; ?></td>
					<td><?php echo $vo['effect_day']; ?>天</td>
					<td><?php echo $vo['default_freeze_num']; ?></td>
					<td><?php echo $vo['default_freeze_min_day']; ?>天</td>
					<td><?php echo $vo['week_num']; ?></td>
					<td>
						<?php if($vo['create_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i',$vo['create_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<?php if($vo['update_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i',$vo['update_time']); ?>
						<?php endif; ?>
					</td>
					<td>
						<a class="btn btn-xs btn-primary"
						   href='<?php echo url("vip_card/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
						<a class="btn btn-xs btn-danger js-ajax-delete"
						   href="<?php echo url('vip_card/delete',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
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