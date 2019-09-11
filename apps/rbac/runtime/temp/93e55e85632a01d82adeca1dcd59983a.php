<?php if (!defined('THINK_PATH')) exit(); /*a:8:{s:76:"/opt/web/zs/apps/rbac/public/../application/v1/view/system/config/index.html";i:1554951767;s:61:"/opt/web/zs/apps/rbac/application/v1/view/layout/default.html";i:1554986348;s:58:"/opt/web/zs/apps/rbac/application/v1/view/common/meta.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/header.html";i:1555487665;s:57:"/opt/web/zs/apps/rbac/application/v1/view/common/map.html";i:1554891314;s:62:"/opt/web/zs/apps/rbac/application/v1/view/common/template.html";i:1553692263;s:60:"/opt/web/zs/apps/rbac/application/v1/view/common/script.html";i:1553692263;s:61:"/opt/web/zs/apps/rbac/application/v1/view/common/require.html";i:1553692263;}*/ ?>
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
    <!-- 自定义css -->
</head>
<body class="skin-blue fixed <?php echo $adaptive; ?>">
    <div id="wrapper">
        <!-- Navigation -->
<nav class="navbar navbar-default navbar-top navbar-static-top main-header" role="navigation" style="margin-bottom: 0">
    <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="<?php echo url('/'); ?>">ZS
            <small>v2.0</small>
        </a>
    </div>
    <a href="#" class="sidebar-toggle <?php if($adaptive): ?>open<?php endif; ?>" data-toggle="offcanvas" role="button">
        <i class="fa fa-bars"></i>
    </a>
    <ul class="nav navbar-top-links navbar-topbar navbar-left" role="tablist">
        <?php echo $navlist; ?>
        <li class="dropdown">
            <a href="<?php echo $config['app']['erpdomain']; ?>" class="dropdown-toggle" data-hover="dropdown"> <i class="fa fa-fw fa-cubes"></i> <span>ERP</span> <span class="pull-right-container"> </span></a>
        </li>
    </ul>
    <!-- /.navbar-header -->
    <ul class="nav navbar-top-links navbar-right">
        <!--<li class="dropdown">-->
            <!--<a class="dropdown-toggle" data-toggle="dropdown" href="#">-->
                <!--<i class="fa fa-bell fa-fw"></i>-->
                <!--<span class="label label-danger">4</span>-->
            <!--</a>-->
            <!--<ul class="dropdown-menu dropdown-messages notice-ul">-->
                <!--<li>-->
                    <!--<a href="#">-->
                        <!--<div>-->
                            <!--<strong>John Smith</strong>-->
                            <!--<span class="pull-right text-muted">-->
                                    <!--<em>Yesterday</em>-->
                                <!--</span>-->
                        <!--</div>-->
                        <!--<div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>-->
                    <!--</a>-->
                <!--</li>-->
                <!--<li>-->
                    <!--<a class="text-center" href="#">-->
                        <!--<strong>Read All Messages</strong>-->
                        <!--<i class="fa fa-angle-right"></i>-->
                    <!--</a>-->
                <!--</li>-->
            <!--</ul>-->
            <!--&lt;!&ndash; /.dropdown-messages &ndash;&gt;-->
        <!--</li>-->
        <!-- /.dropdown -->

        <li class="dropdown user user-menu">
            <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                <img src="/dist/img/avatar.png" class="user-image" alt="User Image"> <?php echo $users['username']; ?> <i class="fa fa-caret-down"></i>
            </a>
            <ul class="dropdown-menu dropdown-user">
                <li><a href="<?php echo url($config['url']['profile']); ?>"><i class="fa fa-user fa-fw"></i> 我的资料</a></li>
                <li class="divider"></li>
                <li><a href="<?php echo url($config['url']['logout']); ?>"><i class="fa fa-sign-out fa-fw"></i> 退出</a></li>
            </ul>
            <!-- /.dropdown-user -->
        </li>
        <!-- /.dropdown -->
    </ul>
    <!-- /.navbar-top-links -->
    <div class="navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav side-menu" id="side-menu">
                <?php echo $menulist; ?>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <!-- /.navbar-static-side -->
</nav>
        <!-- Full Width Column -->
        <div id="page-wrapper">
            <div class="row page-header content-header">
    <h3><?php if(isset($ruletitle)): ?><?php echo $ruletitle; else: ?><?php echo $rule_title; endif; ?></h3>
    <ol class="breadcrumb">
        <li><a href="/"><i class="fa fa-home"></i> <?php echo __('首页'); ?></a></li>
        <li><?php echo $rule_title; ?></li>
        <li class="active"><?php echo $method_title; ?></li>
    </ol>
</div>
            
<div class="nav-tabs-custom">
    <ul class="nav nav-tabs">
        <?php foreach($siteList as $index=>$vo): ?>
        <li class="<?php echo !empty($vo['active'])?'active':''; ?>"><a href="#<?php echo $vo['name']; ?>" data-toggle="tab"><?php echo __($vo['title']); ?></a></li>
        <?php endforeach; ?>
    </ul>
    <div id="myTabContent" class="tab-content">
        <?php foreach($siteList as $index=>$vo): ?>
        <div class="tab-pane fade <?php echo !empty($vo['active'])?'active in' : ''; ?>" id="<?php echo $vo['name']; ?>">
            <div class="widget-body no-padding">
                <form id="<?php echo $vo['name']; ?>-form" class="edit-form form-horizontal dialog-form" role="form" data-toggle="validator" method="POST" action="<?php echo url('/v1/system/config/save'); ?>">
                    <table class="table table-bordered table-hover" width="100%">
                        <thead>
                        <tr>
                            <th width="15%"><?php echo __('标题'); ?></th>
                            <th width="70%"><?php echo __('值'); ?></th>
                            <th width="15%"><?php echo __('调用名称'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php foreach($vo['list'] as $item): ?>
                        <tr>
                            <td class="text-right"><?php echo $item['title']; ?></td>
                            <td>
                                <div class="row">
                                    <div class="col-sm-8 col-xs-12">
                                        <?php switch($item['type']): case "string": ?>
                                        <input type="text" name="row[<?php echo $item['name']; ?>]" value="<?php echo $item['value']; ?>" class="form-control" data-rule="<?php echo $item['rule']; ?>" data-tip="<?php echo $item['tip']; ?>" <?php echo $item['extend']; ?> />
                                        <?php break; case "text": ?>
                                        <textarea name="row[<?php echo $item['name']; ?>]" class="form-control" data-rule="<?php echo $item['rule']; ?>" rows="5" data-tip="<?php echo $item['tip']; ?>" <?php echo $item['extend']; ?>><?php echo $item['value']; ?></textarea>
                                        <?php break; case "editor": ?>
                                        <textarea name="row[<?php echo $item['name']; ?>]" id="editor-<?php echo $item['name']; ?>" class="form-control editor" data-rule="<?php echo $item['rule']; ?>" rows="5" data-tip="<?php echo $item['tip']; ?>" <?php echo $item['extend']; ?>><?php echo $item['value']; ?></textarea>
                                        <?php break; case "array": ?>
                                        <dl class="fieldlist" data-name="row[<?php echo $item['name']; ?>]">
                                            <dd>
                                                <ins><?php echo __('键名'); ?></ins>
                                                <ins><?php echo __('键值'); ?></ins>
                                            </dd>
                                            <?php if(is_array($item['value']) || $item['value'] instanceof \think\Collection || $item['value'] instanceof \think\Paginator): if( count($item['value'])==0 ) : echo "" ;else: foreach($item['value'] as $key=>$val): ?>
                                            <dd class="form-inline">
                                                <input type="text" name="row[<?php echo $item['name']; ?>][field][]" class="form-control" value="<?php echo $key; ?>" size="10">
                                                <input type="text" name="row[<?php echo $item['name']; ?>][value][]" class="form-control" value="<?php echo $val; ?>" size="40">
                                                <span class="btn btn-sm btn-danger btn-remove"><i class="fa fa-times"></i></span>
                                            </dd>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                            <dd><a href="javascript:;" class="btn btn-sm btn-warning btn-append"><i class="fa fa-plus"></i> <?php echo __('Append'); ?></a></dd>
                                        </dl>
                                        <?php break; case "datetime": ?>
                                        <input type="text" name="row[<?php echo $item['name']; ?>]" value="<?php echo $item['value']; ?>" class="form-control datetimepicker" data-tip="<?php echo $item['tip']; ?>" data-rule="<?php echo $item['rule']; ?>" <?php echo $item['extend']; ?> />
                                        <?php break; case "number": ?>
                                        <input type="number" name="row[<?php echo $item['name']; ?>]" value="<?php echo $item['value']; ?>" class="form-control" data-tip="<?php echo $item['tip']; ?>" data-rule="<?php echo $item['rule']; ?>" <?php echo $item['extend']; ?> />
                                        <?php break; case "checkbox": if(is_array($item['content']) || $item['content'] instanceof \think\Collection || $item['content'] instanceof \think\Paginator): if( count($item['content'])==0 ) : echo "" ;else: foreach($item['content'] as $key=>$vo): ?>
                                        <label for="row[<?php echo $item['name']; ?>][]-<?php echo $key; ?>"><input id="row[<?php echo $item['name']; ?>][]-<?php echo $key; ?>" name="row[<?php echo $item['name']; ?>][]" type="checkbox" value="<?php echo $key; ?>" data-tip="<?php echo $item['tip']; ?>" <?php if(in_array(($key), is_array($item['value'])?$item['value']:explode(',',$item['value']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label>
                                        <?php endforeach; endif; else: echo "" ;endif; break; case "radio": if(is_array($item['content']) || $item['content'] instanceof \think\Collection || $item['content'] instanceof \think\Paginator): if( count($item['content'])==0 ) : echo "" ;else: foreach($item['content'] as $key=>$vo): ?>
                                        <label for="row[<?php echo $item['name']; ?>]-<?php echo $key; ?>"><input id="row[<?php echo $item['name']; ?>]-<?php echo $key; ?>" name="row[<?php echo $item['name']; ?>]" type="radio" value="<?php echo $key; ?>" data-tip="<?php echo $item['tip']; ?>" <?php if(in_array(($key), is_array($item['value'])?$item['value']:explode(',',$item['value']))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label>
                                        <?php endforeach; endif; else: echo "" ;endif; break; case "select": case "selects": ?>
                                        <select name="row[<?php echo $item['name']; ?>]<?php echo $item['type']=='selects'?'[]':''; ?>" class="form-control" data-tip="<?php echo $item['tip']; ?>" <?php echo $item['type']=='selects'?'multiple':''; ?>>
                                            <?php if(is_array($item['content']) || $item['content'] instanceof \think\Collection || $item['content'] instanceof \think\Paginator): if( count($item['content'])==0 ) : echo "" ;else: foreach($item['content'] as $key=>$vo): ?>
                                            <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($item['value'])?$item['value']:explode(',',$item['value']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
                                            <?php endforeach; endif; else: echo "" ;endif; ?>
                                        </select>
                                        <?php break; case "image": case "images": ?>
                                        <div class="form-inline">
                                            <input id="c-<?php echo $item['name']; ?>" class="form-control" size="50" name="row[<?php echo $item['name']; ?>]" type="text" value="<?php echo $item['value']; ?>" data-tip="<?php echo $item['tip']; ?>">
                                            <span><button type="button" id="plupload-<?php echo $item['name']; ?>" class="btn btn-danger plupload" data-input-id="c-<?php echo $item['name']; ?>" data-mimetype="image/*" data-multiple="<?php echo $item['type']=='image'?'false':'true'; ?>" data-preview-id="p-<?php echo $item['name']; ?>"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                                            <span><button type="button" id="fachoose-<?php echo $item['name']; ?>" class="btn btn-primary fachoose" data-input-id="c-<?php echo $item['name']; ?>" data-mimetype="image/*" data-multiple="<?php echo $item['type']=='image'?'false':'true'; ?>"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                                            <ul class="row list-inline plupload-preview" id="p-<?php echo $item['name']; ?>"></ul>
                                        </div>
                                        <?php break; case "file": case "files": ?>
                                        <div class="form-inline">
                                            <input id="c-<?php echo $item['name']; ?>" class="form-control" size="50" name="row[<?php echo $item['name']; ?>]" type="text" value="<?php echo $item['value']; ?>" data-tip="<?php echo $item['tip']; ?>">
                                            <span><button type="button" id="plupload-<?php echo $item['name']; ?>" class="btn btn-danger plupload" data-input-id="c-<?php echo $item['name']; ?>" data-multiple="<?php echo $item['type']=='file'?'false':'true'; ?>"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>
                                            <span><button type="button" id="fachoose-<?php echo $item['name']; ?>" class="btn btn-primary fachoose" data-input-id="c-<?php echo $item['name']; ?>" data-multiple="<?php echo $item['type']=='file'?'false':'true'; ?>"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>
                                        </div>
                                        <?php break; case "bool": ?>
                                        <label for="row[<?php echo $item['name']; ?>]-yes"><input id="row[<?php echo $item['name']; ?>]-yes" name="row[<?php echo $item['name']; ?>]" type="radio" value="1" <?php echo !empty($item['value'])?'checked':''; ?> data-tip="<?php echo $item['tip']; ?>" /> <?php echo __('Yes'); ?></label>
                                        <label for="row[<?php echo $item['name']; ?>]-no"><input id="row[<?php echo $item['name']; ?>]-no" name="row[<?php echo $item['name']; ?>]" type="radio" value="0" <?php echo !empty($item['value'])?'':'checked'; ?> data-tip="<?php echo $item['tip']; ?>" /> <?php echo __('No'); ?></label>
                                        <?php break; endswitch; ?>
                                    </div>
                                    <div class="col-sm-4"></div>
                                </div>

                            </td>
                            <td><?php echo "{\$site.". $item['name'] . "}"; ?></td>
                        </tr>
                        <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                        <tr>
                            <td></td>
                            <td>
                                <button type="submit" class="btn btn-success btn-embossed"><?php echo __('确定保存'); ?></button>
                                <button type="reset" class="btn btn-default btn-embossed"><?php echo __('重置'); ?></button>
                            </td>
                            <td></td>
                        </tr>
                        </tfoot>
                    </table>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

        </div>
    </div>
    <script id="test" type="text/html">
    <h1>{{title}}</h1>1wwerewrewr
</script>
    <!-- 加载JS脚本 -->
    <!-- jQuery 3 -->
    <!-- jQuery 3 -->
<script src="/vendor/jquery/jquery.min.js?v=<?php echo $config['site']['version']; ?>"></script>
    <!-- 自定义js -->
    <!-- 自定义js模板 -->
    <!-- require -->
<script src="/dist/js/require.js?v=<?php echo $config['site']['version']; ?>" data-main="/dist/js/require-main.js?v=<?php echo $config['site']['version']; ?>"></script>
</body>
</html>