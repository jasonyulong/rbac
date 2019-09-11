<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"/opt/web/zs/apps/rbac/public/../application/v1/view/login/index.html";i:1555055990;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692264;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
<head>
    <!-- 加载样式及META信息 -->
    <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<link rel="shortcut icon" href="/favicon.ico" />
<!-- Tell the browser to be responsive to screen width -->
<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
<!-- Bootstrap 4 -->
<!-- Bootstrap Core CSS -->
<link href="/vendor/bootstrap/css/bootstrap.min.css?v=<?php echo $config['site']['version']; ?>" rel="stylesheet">
<!-- Custom CSS -->
<link href="/dist/css/app.min.css?v=<?php echo $config['site']['version']; ?>" rel="stylesheet">
<!-- Custom CSS -->
<link href="/dist/css/extend.min.css?v=<?php echo $config['site']['version']; ?>" rel="stylesheet">
<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>
</head>
<body class="login-body">
<div class="container">
    <div class="row">
        <div class="col-md-4 col-md-offset-4" style="padding-top:20%;">
            <form role="form" id="loginForm" action="<?php echo url($config['url']['login']); ?>" method="post">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <img src="/dist/img/logo.png" width="50" height="50">
                        <h3 class="panel-title">RBAC</h3>
                    </div>
                    <div class="login-panel-body">

                        <fieldset>
                            <div class="form-group">
                                <input class="form-control" placeholder="Username / ID" name="username" type="text"
                                       data-rule="required;" data-msg-required="请填写姓名/工号"
                                       autofocus>
                            </div>
                            <div class="form-group">
                                <input class="form-control" placeholder="Password" name="password" type="password"
                                       data-msg-required="请填写正确的密码"
                                       data-rule="required;"
                                       autocomplete="off">
                            </div>
                        </fieldset>

                    </div>
                    <p class="text-danger small login-tips"><i class="fa fa-bullhorn"></i>请注意正确的输入,密码错误<?php echo $config['site']['loginfailure']; ?>次将锁号一天</p>
                    <div class="panel-footer">
                        <!-- Change this to a button or input when using this as a form -->
                        <button class="btn btn-primary btn-block" type="submit" id="submit">Login</button>
                        <div class="copyright">Copyright © 2018-2025 Jeoshi All rights reserved</div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- 加载JS脚本 -->
<!-- jQuery 3 -->
<script src="/vendor/jquery/jquery.min.js"></script>
<!-- require -->
<script src="/dist/js/require.js" data-main="/dist/js/require-main.js"></script>
</body>
</html>