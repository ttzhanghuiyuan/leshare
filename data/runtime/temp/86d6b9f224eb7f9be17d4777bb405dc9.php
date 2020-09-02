<?php /*a:2:{s:80:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/class_level/index.html";i:1598752991;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
			<li class="active"><a href="<?php echo url('class_level/index'); ?>"><?php echo lang('课程等级'); ?></a></li>
			<li><a href="<?php echo url('class_level/add'); ?>"><?php echo lang('课程等级添加'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('ClassLevelChannel/index'); ?>">
            课程等级:
            <input type="text" class="form-control" name="name" style="width: 120px;" value="<?php echo input('request.channel_name/s',''); ?>" placeholder="请输入<?php echo lang('课程等级名称'); ?>">
            <input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('ClassLevelChannel/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th><?php echo lang('课程等级'); ?></th>
					<th><?php echo lang('添加时间'); ?></th>
					<th><?php echo lang('更新时间'); ?></th>
					<th><?php echo lang('删除'); ?></th>
					<th width="140"><?php echo lang('ACTIONS'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($class_level) || $class_level instanceof \think\Collection || $class_level instanceof \think\Paginator): if( count($class_level)==0 ) : echo "" ;else: foreach($class_level as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['name']; ?></td>
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
						<a class="btn btn-xs btn-primary"
						   href='<?php echo url("class_level/edit",array("id"=>$vo["id"])); ?>'><?php echo lang('EDIT'); ?></a>
						<a class="btn btn-xs btn-danger js-ajax-delete"
						   href="<?php echo url('class_level/delete',array('id'=>$vo['id'])); ?>"><?php echo lang('DELETE'); ?></a>
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