<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:68:"/opt/web/zs/apps/rbac/public/../application/v1/view/login/locks.html";i:1555380318;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;}*/ ?>
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

<body class="hold-transition lockscreen">
<div class="lockscreen-wrapper">
    <div class="lockscreen-logo">
        超时锁屏
    </div>
    <!-- User name -->
    <div class="lockscreen-name"><?php echo (isset($admin['username']) && ($admin['username'] !== '')?$admin['username']:''); ?></div>

    <!-- START LOCK SCREEN ITEM -->
    <div class="lockscreen-item">
        <!-- lockscreen image -->
        <div class="lockscreen-image">
            <img src="<?php echo (isset($admin['avatar']) && ($admin['avatar'] !== '')?$admin['avatar']:'/dist/img/avatar.png'); ?>" alt="User Image">
        </div>
        <!-- /.lockscreen-image -->
        <!-- lockscreen credentials (contains the form) -->
        <form class="lockscreen-credentials" method="POST" id="locks-form"
              action="<?php echo url($config['url']['locks'], ['url' => $url]); ?>">
            <div class="input-group">
                <input type="hidden" name="username" value="<?php echo $users['username']; ?>">
                <input type="password" class="form-control" id="pd-form-password" placeholder="<?php echo __('Password'); ?>"
                       name="password" autocomplete="off" value="" data-msg-required="请填写正确的密码"
                       data-rule="required;" autofocus/>
                <div class="input-group-btn">
                    <button type="submit" class="btn"><i class="fa fa-arrow-right text-muted"></i></button>
                </div>
                <span class="msg-box n-right" for="pd-form-password"></span>
            </div>
        </form>
    </div>
    <!-- /.lockscreen-item -->
    <div class="help-block text-center">
        Enter your password to retrieve your session
    </div>
    <div class="text-center">
        <a href="<?php echo url($config['url']['login'], ['url' => $url]); ?>" class="text-primary">Or sign in as a different user</a>
    </div>
    <div class="lockscreen-footer text-center small">
        Copyright &copy; 2018-2025 <b>Jeoshi</b><br>
        All rights reserved
    </div>
</div>
<!-- 加载JS脚本 -->
<!-- jQuery 3 -->
<script src="/vendor/jquery/jquery.min.js"></script>
<!-- require -->
<script src="/dist/js/require.js" data-main="/dist/js/require-main.js"></script>
<script language="javascript">
    //防止页面后退
    history.pushState(null, null, document.URL);
    window.addEventListener('popstate', function () {
        history.pushState(null, null, document.URL);
    });
</script>
</body>
</html>