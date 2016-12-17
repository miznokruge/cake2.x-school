<?php
$cakeDescription = __d('cake_dev', 'Home');
header("Cache-Control: no-cache,no-store,must-revalidate");
header("Expires: -1");
$loggeuser_id = $this->Session->read('UserAuth.User.id');
$user_group_id = $this->Session->read("UserAuth.User.user_group_id");
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Mainly scripts -->
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $this->Info->application('app_name'); ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>
        <?php echo $this->Javascript->link(array('jquery-11.min', 'jquery-ui-1.8.22.custom.min')); ?>
        <?php echo $this->Javascript->link('autoNumeric-1.7.4.min'); ?>
        <?php echo $this->Javascript->link(array('bootstrap.min', 'plugins/metisMenu/jquery.metisMenu', 'plugins/slimscroll/jquery.slimscroll.min', 'inspinia', 'plugins/pace/pace.min', 'select2.min')); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine-en'); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine'); ?>
        <?php echo $this->Javascript->link('mustache'); ?>
        <?php echo $this->Javascript->link('app/system'); ?>
        <?php echo $this->Javascript->link("plugins/gritter/jquery.gritter.min.js"); ?>
        <?php echo $this->Html->script(array('noty/packaged/jquery.noty.packaged', 'plugins/easypiechart/jquery.easypiechart')) ?>
        <?php echo $this->Html->script(array('plugins/iCheck/icheck.min', 'jquery.scrollPagination', 'jquery.playsound', 'jquery.idletimer', 'jquery.idletimeout', 'jquery.fancybox')); ?>
        <!-- Gritter -->
        <link href="/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
        <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
        <?php
        if ($this->Session->read("theme")) {
            echo $this->Html->css('bootstrap-' . $this->Session->read('theme.name'));
        } else {
            echo $this->Html->css('bootstrap.min.css');
        }

        echo $this->Html->css(array('font-awesome.css'));
        echo $this->Html->css(array('Aristo.css', 'style', 'animate', 'jquery.fancybox', 'select2'));
        //echo $this->Html->css('jquery-ui-1.8.22.custom');
        echo $this->Html->css(array('pace', 'animate', 'noty'));
        echo $this->Html->css('validationEngine.jquery.css');
        //echo $scripts_for_layout;
        if (isset($cssIncludes)) {
            foreach ($cssIncludes as $css) {
                echo $this->Html->css($css) . "\n";
            }
        }
        if (isset($jsIncludes)) {
            foreach ($jsIncludes as $js) {
                echo $this->Javascript->link($js) . "\n";
            }
        }

        echo $this->Html->script(
                array(
                    'plugins/flot/jquery.flot', 'plugins/flot/jquery.flot.tooltip.min', 'plugins/flot/jquery.flot.spline',
                    'plugins/flot/jquery.flot.resize', 'plugins/flot/jquery.flot.pie', 'plugins/flot/jquery.flot.symbol',
                    'plugins/jvectormap/jquery-jvectormap-1.2.2.min', 'plugins/jvectormap/jquery-jvectormap-world-mill-en',
                    'plugins/sparkline/jquery.sparkline.min', 'demo/sparkline-demo', 'plugins/chartJs/Chart.min',
                    'jquery.cookie'
                )
        );
        echo $this->Html->css(array('yamm'));
        ?>
    </head>
    <body class="<?php echo $this->Session->read('Config.view.mini') ?>" style="background-color: #fff">
        <div id="wrapper">
            <div id="topnav">
                <div id="top-header">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="navbar-header" style="margin-top:-10px;">
                                <button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".js-navbar-collapse">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
                                <a class="navbar-brand" href="<?php echo $this->webroot ?>"><?php echo $this->Html->image('logo/' . str_replace('.', '_30.', $this->Info->application('logo')), array('class' => 'img-circle')) ?> <?php echo $this->Info->application('app_name'); ?></a>
                            </div>
                        </div>
                        <div class="col-sm-9">

<!--                            <span class="top-info">
                                Page generated in <strong><?php //echo round(microtime(true) - TIME_START, 3);                                   ?></strong> second
                            </span>
                            <span class="top-info">
                                <i class="fa fa-globe"></i> <?php //echo $_SERVER['REMOTE_ADDR'];                                   ?>
                            </span>
                            <span class="top-info">
                                <i class="fa fa-user"></i> <?php //echo $this->UserAuth->getUsername()                                   ?>
                                <a href="#" id="btn-logout"><i class="fa fa-sign-out"></i> logout</a>
                            </span>-->
                            <ul class="nav navbar-nav navbar-right">
                                <li class="dropdown profile hidden-xs">
                                    <?php
                                    if ($current_language == 'eng') {
                                        $bahasa = 'English';
                                    } elseif ($current_language == 'jpn') {
                                        $bahasa = 'Japan';
                                    } else {
                                        $bahasa = 'Bahasa';
                                    }
                                    ?>
                                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" title="<?php echo $bahasa; ?>">
                                        <?php echo $this->Html->image($current_language . '.png'); ?> <?php echo $bahasa ?> <b class="caret"></b>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-large row" style="background:#efefef; color:#000 !important;">
                                        <li>
                                            <a href="/lang/setlang/eng"><?php echo $this->Html->image('eng.png'); ?> English</a>
                                        </li>
                                        <li>
                                            <a href="/lang/setlang/ind"><?php echo $this->Html->image('ind.png'); ?> Bahasa Indonesia</a>
                                        </li>
                                        <li>
                                            <a href="/lang/setlang/jpn"><?php echo $this->Html->image('jpn.png'); ?> Japan</a>
                                        </li>
                                    </ul>
                                </li>
                                <li class="dropdown profile hidden-xs" style="margin-right: 10px;">
                                    <a data-toggle="dropdown" class="dropdown-toggle" href="javascript:void(0);" aria-expanded="false">
                                        <span class="meta">
                                            <span class="avatar">
                                                <img alt="" class="img-circle" src="<?php echo $this->webroot ?>img/foto_profile/<?php echo str_replace('.', '_30.', $this->Info->userdata($this->UserAuth->getUserId(), 'foto')) ?>">
                                            </span>
                                            <span class="text"><?php echo $this->UserAuth->getUsername() ?></span>
                                            <span class="caret"></span>
                                        </span>
                                    </a>
                                    <ul role="menu" class="dropdown-menu animated fadeIn" style="background:#efefef; color:#000 !important;">
                                        <li>
                                            <a href="/messages/"><i class="fa fa-envelope"></i> Mailbox (<?php echo count($message_inbox); ?>)</a>
                                        </li>
                                        <li>
                                            <a href="#" id="btn_update_profile">
                                                <i class="fa fa-user-md"></i> Update Profile</a>
                                        </li>
                                        <li>
                                            <a href="/users/change_password/">
                                                <i class="fa fa-key"></i> Change Password</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="/logout/">
                                                <i class="fa fa-sign-out"></i> Logout</a>
                                        </li>

                                    </ul>
                                </li>

                                <!--                                <li class="toggle-navigation toggle-right">
                                                                    <button id="toggle-right" class="sidebar-toggle">
                                                                        <i class="fa fa-indent"></i>
                                                                    </button>
                                                                </li>-->
                            </ul>
                        </div>
                    </div>
                </div>
                <nav class="navbar navbar-default navbar-static">
                    <div class="collapse navbar-collapse js-navbar-collapse">
                        <ul class="nav navbar-nav">
                            <?php
                            $mcount = 1;
                            foreach ($menus as $menu) {
                                if ((int) $menu['Menu']['enabled'] == 1) {
                                    ?>
                                    <li class="dropdown">
                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="fa <?php echo $menu['Menu']['icon']; ?>"></i> <?php echo ucwords($menu['Menu']['name']); ?> <b class="caret"></b></a>
                                        <?php if (count($menu['children']) > 0) { ?>
                                            <ul class="dropdown-menu dropdown-menu-large row">
                                                <?php foreach ($menu['children'] as $mc) { ?>
                                                    <li class="dropdown-header"><?php echo $mc['Menu']['name'] ?></li>
                                                    <?php foreach ($mc['children'] as $c) { ?>
                                                        <li><a href="/<?php echo $c['Menu']['controller'] . '/' . $c['Menu']['action']; ?>"><?php echo ucwords(str_replace("-", " ", $c['Menu']['name'])) ?></a></li>
                                                    <?php } ?>
                                                <?php } ?>
                                            </ul>
                                        <?php } ?>
                                    </li>
                                <?php } ?>
                            <?php } ?>
                        </ul>
                    </div><!-- /.nav-collapse -->
                </nav>
            </div>
            <div style="width:98%; margin: 5px auto 0 auto;" class="animated bounceIn zoomIn">
                <?php echo $content_for_layout;
                //echo $this->fetch('content');
                ?>
            </div>
            <?php echo $this->element('default', array('loggeuser_id' => $loggeuser_id)) ?>
            <?php echo $this->element('top_right', array('loggeuser_id' => $loggeuser_id)) ?>
<?php echo $this->element('sql_dump'); ?>
        </div>
    </body>
</html>