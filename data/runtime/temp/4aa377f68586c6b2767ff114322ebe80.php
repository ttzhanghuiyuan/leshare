<?php /*a:2:{s:80:"/home/abner/leshare/public/themes/admin_simpleboot3/admin/student_card/edit.html";i:1598746432;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1598770981;}*/ ?>
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
        <li class="active"><a>编辑学生会员卡</a></li>
    </ul>
    <form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('StudentCard/editPost'); ?>">
        <!--有效期开始-->
        <div class="form-group">
            <label for="input-effect-start" class="col-sm-2 control-label">
                <?php echo lang('有效期开始'); ?>
            </label>
            <div class="col-md-6 col-sm-10">
                <input value="<?php echo $effect_start; ?>"
                       class="js-date"
                       type="text"
                       id="input-effect-start"
                       placeholder="2013-01-04"
                       name="effect_start">
            </div>
        </div>

        <!--有效期结束-->
        <div class="form-group">
            <label for="input-effect-end" class="col-sm-2 control-label">
                <?php echo lang('有效期结束'); ?>
            </label>
            <div class="col-md-6 col-sm-10">
                <input value="<?php echo $effect_end; ?>"
                       class="js-date"
                       type="text"
                       id="input-effect-end"
                       placeholder="2013-01-04"
                       name="effect_end">
            </div>
        </div>

        <!--可冻结次数-->
        <div class="form-group">
            <label for="input-freeze-num" class="col-sm-2 control-label">
                <?php echo lang('可冻结次数'); ?>
            </label>
            <div class="col-md-6 col-sm-10">
                <input value="<?php echo $freeze_num; ?>" type="text" class="form-control" id="input-freeze-num" name="freeze_num">
            </div>
        </div>

        <!--冻结间隔天数-->
        <div class="form-group">
            <label for="input-freeze-min-day" class="col-sm-2 control-label">
                <?php echo lang('冻结间隔天数'); ?>
            </label>
            <div class="col-md-6 col-sm-10">
                <input value="<?php echo $freeze_min_day; ?>" type="text" class="form-control" id="input-freeze-min-day" name="freeze_min_day">
            </div>
        </div>

        <!--是否生效-->
        <div class="form-group">
            <label class="col-sm-2 control-label">
                <?php echo lang('是否生效'); ?>
            </label>
            <div class="col-md-6 col-sm-10">
                <select class="form-control" name="enable_flag" id="input-enable-flag" style="width: 150px;">
                    <?php if(is_array($enable_flag_list) || $enable_flag_list instanceof \think\Collection || $enable_flag_list instanceof \think\Paginator): if( count($enable_flag_list)==0 ) : echo "" ;else: foreach($enable_flag_list as $key=>$vo): $flag_selected=isset($enable_flag)&&$enable_flag==$key?"selected":""; ?>
                        <option value="<?php echo $key; ?>" <?php echo $flag_selected; ?>><?php echo $vo; ?></option>
                    <?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
            </div>
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="id" value="<?php echo $id; ?>"/>
                <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
                <a class="btn btn-default" href="javascript:history.back(-1);"><?php echo lang('BACK'); ?></a>
            </div>
        </div>
    </form>
</div>
<script src="/static/js/admin.js"></script>
</body>
</html>