<?php /*a:2:{s:84:"/home/abner/leshare/public/themes/admin_simpleboot3/user/admin_user_action/edit.html";i:1596947788;s:70:"/home/abner/leshare/public/themes/admin_simpleboot3/public/header.html";i:1596947788;}*/ ?>
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
        <li><a href="<?php echo url('AdminUserAction/index'); ?>">用户操作管理</a></li>
        <li class="active"><a>编辑用户操作</a></li>
    </ul>
    <form method="post" class="form-horizontal js-ajax-form margin-top-20" action="<?php echo url('AdminUserAction/editPost'); ?>">
        <div class="form-group">
            <label for="input-score" class="col-sm-2 control-label">积分</label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" id="input-score" name="score" value="<?php echo $score; ?>">
                <p class="help-block">用户操作时积分更改，可以为负</p>
            </div>
        </div>
        <div class="form-group">
            <label for="input-coin" class="col-sm-2 control-label">金币</label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" id="input-coin" name="coin" value="<?php echo $coin; ?>">
                <p class="help-block">用户操作时金币更改，可以为负</p>
            </div>
        </div>
        <div class="form-group">
            <label for="input-cycle_type" class="col-sm-2 control-label">周期类型</label>
            <div class="col-md-6 col-sm-10">
                <select name="cycle_type" id="input-cycle_type" class="form-control">
                    <option value="0">不限</option>
                    <option value="1">天</option>
                    <option value="2">小时</option>
                    <option value="3">永久</option>
                </select>
                <p class="help-block">用户操作时奖励周期类型</p>
            </div>
        </div>
        <div class="form-group">
            <label for="input-cycle_time" class="col-sm-2 control-label">周期时间</label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" id="input-cycle_time" name="cycle_time" value="<?php echo $cycle_time; ?>">
                <p class="help-block">用户操作时奖励周期时间</p>
            </div>
        </div>
        <div class="form-group">
            <label for="input-reward_number" class="col-sm-2 control-label">奖励次数</label>
            <div class="col-md-6 col-sm-10">
                <input type="text" class="form-control" id="input-reward_number" name="reward_number"
                       value="<?php echo $reward_number; ?>">
                <p class="help-block">用户操作时奖励次数</p>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-10">
                <input type="hidden" name="id" value="<?php echo $id; ?>">
                <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo lang('SAVE'); ?></button>
                <a class="btn btn-default" href="<?php echo url('AdminUserAction/index'); ?>"><?php echo lang('BACK'); ?></a>
            </div>
        </div>
    </form>
</div>
<script src="/static/js/admin.js"></script>
<script>
    $('#input-cycle_type').val("<?php echo $cycle_type; ?>");
</script>
</body>
</html>