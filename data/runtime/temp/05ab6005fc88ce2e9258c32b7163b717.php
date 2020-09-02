<?php /*a:2:{s:80:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/buckle_hour/index.html";i:1598919469;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
			<li class="active"><a href="<?php echo url('buckle_hour/index'); ?>"><?php echo lang('扣课记录'); ?></a></li>
		</ul>
        <form class="well form-inline margin-top-20" method="get" action="<?php echo url('BuckleHour/index'); ?>">
			学生姓名:
			<input type="text" class="form-control" name="name" style="width: 130px;" value="<?php echo input('request.name/s',''); ?>" placeholder="请输入<?php echo lang('学生电话'); ?>">
			<input type="submit" class="btn btn-primary" value="搜索" />
            <a class="btn btn-danger" href="<?php echo url('BuckleHour/index'); ?>">清空</a>
        </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th>ID</th>
					<th><?php echo lang('学生姓名'); ?></th>
					<th><?php echo lang('操作人ID'); ?></th>
					<th><?php echo lang('课时'); ?></th>
					<th><?php echo lang('描述'); ?></th>
					<th><?php echo lang('添加时间'); ?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($buckle_hour) || $buckle_hour instanceof \think\Collection || $buckle_hour instanceof \think\Paginator): if( count($buckle_hour)==0 ) : echo "" ;else: foreach($buckle_hour as $key=>$vo): ?>
				<tr>
					<td><?php echo $vo['id']; ?></td>
					<td><?php echo $vo['s_name']; ?></td>
					<td><?php echo $vo['opera_id']; ?></td>
					<td><?php echo $vo['hour']; ?></td>
					<td><?php echo $vo['description']; ?></td>
					<td>
						<?php if($vo['create_time'] == 0): ?>
							<?php echo lang('-'); else: ?>
							<?php echo date('Y-m-d H:i',$vo['create_time']); ?>
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