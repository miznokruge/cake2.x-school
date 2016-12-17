<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeDescription = __d('cake_dev', 'Home');
header("Cache-Control: no-cache,no-store,must-revalidate");
header("Expires: -1");
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
        <?php echo $this->Javascript->link(array('plugins/iCheck/icheck.min', 'jquery.scrollPagination', 'jquery.playsound', 'jquery.idletimer', 'jquery.idletimeout', 'jquery.fancybox')); ?>
        <!-- Gritter -->
        <link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
        <link href="/css/plugins/morris/morris-0.4.3.min.css" rel="stylesheet">
        <link href="/css/plugins/iCheck/custom.css" rel="stylesheet">
        <?php
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css(array('font-awesome.css'));
        echo $this->Html->css(array('Aristo.css', 'style', 'animate', 'jquery.fancybox', 'select2'));
        //echo $this->Html->css('jquery-ui-1.8.22.custom');
        //echo $this->Html->css('trello');
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
        ?>
        <script src="/js/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
        <script src="/js/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
        <!-- Sparkline -->
        <script src="/js/plugins/sparkline/jquery.sparkline.min.js"></script>
        <!-- Sparkline demo data  -->
        <script src="/js/demo/sparkline-demo.js"></script>
        <!-- ChartJS-->
        <script src="/js/plugins/chartJs/Chart.min.js"></script>
    </head>
    <body class="<?php echo $this->Session->read('Config.view.mini') ?>">
        <div id="wrapper">
            <nav class="navbar-default navbar-static-side" role="navigation">
                <div class="sidebar-collapse">
                    <ul class="nav" id="side-menu">
                        <li class="nav-header">
                            <?php
                            $loggeuser_id = $this->Session->read('Auth.User.id');
                            ?>
                            <div class="dropdown profile-element">
                                <span>
                                    <img alt="image" class="img-circle" src="/img/foto_profile/<?php echo str_replace('.', '_60.', $this->Info->userdata($loggeuser_id, 'foto')); ?>">
                                </span>
                                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                                    <span class="clear"> <span class="block m-t-xs"> <strong class="font-bold"><?php echo $this->Session->read('Auth.User.username'); ?></strong>
                                        </span> <span class="text-muted text-xs block"><?php echo $this->Info->group($this->Session->read('Auth.User.group_id'), 'name'); ?><b class="caret"></b></span> </span>
                                </a>
                                <ul class="dropdown-menu animated fadeInRight m-t-xs">
                                    <li><a href="profile.html">Profile</a></li>
                                    <li><a href="contacts.html">Contacts</a></li>
                                    <li><a href="mailbox.html">Mailbox</a></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="btn_update_profile">Update Profile</a></li>
                                    <li><?php echo $this->Html->link('Change Password', array('controller' => 'users', 'action' => 'change_password')); ?></li>
                                    <li class="divider"></li>
                                    <li><a href="#" id="btn-logout"><i class="fa fa-sign-out"></i> Logout</a></li>
                                </ul>
                            </div>
                            <div class="logo-element">
                                <a href="/">GCRM</a>
                            </div>
                        </li>
                        <?php foreach ($menus as $menu): ?>
                            <li>
                                <a href="#"><i class="fa <?php echo $menu['Menu']['icon']; ?>"></i> <span class="nav-label"><?php echo ucwords($menu['Menu']['name']); ?></span><span class="fa fa-angle-right pull-right"></span></a>
                                <?php if (count($menu['children']) > 0): ?>
                                    <ul class="nav nav-second-level">
                                        <?php foreach ($menu['children'] as $mc): ?>
                                            <li>
                                                <?php
                                                echo $this->Html->linkSkipAcl(ucwords(str_replace("-", " ", $mc['Menu']['name'])), array('controller' => $mc['Menu']['controller'], 'action' => $mc['Menu']['action'])
                                                        , array('escape' => false));
                                                ?>
                                                <?php if (count($mc['children']) > 0) {
                                                    ?>
                                                    <ul>
                                                        <?php foreach ($mc['children'] as $c) { ?>
                                                            <li>
                                                                <!--<a href="#"><?php echo $c['Menu']['name']; ?> <span class="fa fa-angle-right"></span></a>-->
                                                                <?php
                                                                echo $this->Html->linkSkipAcl(ucwords(str_replace("-", " ", $c['Menu']['name'])), array('controller' => $c['Menu']['controller'], 'action' => $mc['Menu']['action'])
                                                                        , array('escape' => false));
                                                                ?>
                                                                <ul class="nav nav-third-level collapse in" style="height: auto;">
                                                                    <?php foreach ($c['children'] as $menu_level_tiga) { ?>
                                                                        <li>
                                                                            <a href="#"><?php echo $menu_level_tiga['Menu']['name']; ?></a>
                                                                        </li>
                                                                    <?php } ?>
                                                                </ul>
                                                            </li>
                                                        <?php } ?>
                                                    </ul>
                                                <?php } ?>
                                            </li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </li>
                        <?php endforeach; ?>
                        <li>
                            <a href="/dashboard/about/"><i class="fa fa-cubes"></i>
                                <span class="nav-label">About</span>
                                <span class="pull-right label label-primary">SPECIAL</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
            <div id="page-wrapper" class="gray-bg">
                <div class="row border-bottom">
                    <nav class="navbar navbar-static-top white-bg" role="navigation" style="margin-bottom: 0">
                        <div class="navbar-header">
                            <a class="navbar-minimalize minimalize-styl-2 btn btn-primary " href="#"><i class="fa fa-bars"></i> </a>
                            <form role="search" class="navbar-form-custom" method="post" action="/orders/search">
                                <div class="form-group">
                                    <input type="text" placeholder="<?php echo __('Search for something'); ?>..." class="form-control" name="top-search" id="top-search">
                                </div>
                            </form>
                        </div>
                        <ul class="nav navbar-top-links navbar-right">
                            <li>
                                <span class="m-r-sm text-muted welcome-message">Welcome to <?php echo $this->Info->application("app_name"); ?></span>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-envelope"></i>
                                    <?php if (count($message_inbox) > 0) { ?>
                                        <span class="label label-danger"><?php echo count($message_inbox) ?></span>
                                    <?php } ?>
                                </a>
                                <?php echo $this->element('header_message_inbox'); ?>
                            </li>
                            <li class="dropdown">
                                <a class="dropdown-toggle count-info" data-toggle="dropdown" href="#">
                                    <i class="fa fa-bell"></i>
                                    <?php if (count($notification_inbox) > 0) { ?>
                                        <span class="label label-primary"><?php echo count($notification_inbox) ?></span>
                                    <?php } ?>
                                </a>
                                <ul class="dropdown-menu dropdown-alerts">
                                    <?php foreach ($notification_inbox as $n) { ?>
                                        <li>
                                            <a href="<?php echo $n['Notification']['url'] ?>">
                                                <div>
                                                    <?php echo $n['Notification']['content'] ?>
                                                    <br>
                                                    <span class="text-muted small"><?php echo $this->Time->timeAgoInWords($n['Notification']['created']) ?></span>
                                                </div>
                                            </a>
                                        </li>
                                        <li class="divider"></li>
                                    <?php } ?>
                                    <li>
                                        <div class="text-center link-block">
                                            <a href="notifications.html">
                                                <strong>See All Alerts</strong>
                                                <i class="fa fa-angle-right"></i>
                                            </a>
                                        </div>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown">
                                <?php
                                if ($current_language == 'eng') {
                                    $bahasa = 'English';
                                } elseif ($current_language == 'jpn') {
                                    $bahasa = 'Japan';
                                } else {
                                    $bahasa = 'Bahasa Indonesia';
                                }
                                ?>
                                <a class="dropdown-toggle" data-toggle="dropdown" href="#" title="<?php echo $bahasa; ?>">
                                    <?php echo $this->Html->image($current_language . '.png'); ?> <?php //echo $bahasa ?>
                                </a>
                                <ul class="dropdown-menu dropdown-alerts">
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
                            <!--
                                                    <li>
                                                        <a href="/users/logout/">
                                                            <i class="fa fa-sign-out"></i> Log out
                                                        </a>
                                                    </li>-->
                        </ul>
                    </nav>
                </div>
                <?php echo $content_for_layout; ?>
                <br>
                <script type="text/javascript">
                    $(function () {
                        $(".dialog-btn").click(function () {
                            var url = $(this).attr("alt");
                            $.fancybox.open({
                                href: url,
                                type: 'iframe',
                                padding: 10,
                                width: 960,
                                height: 650
                            });
                            return false;
                        });
                        $(".print-btn").click(function () {
                            var url = $(this).attr("alt");
                            $.fancybox.open({
                                helpers: {
                                    overlay: {
                                        css: {
                                            'background': '#f2f2f2'
                                        }
                                    }
                                },
                                href: url,
                                type: 'iframe',
                                padding: 10,
                                width: 960,
                                height: 650
                            });
                            return false;
                        });
                    });
                    $("#dialog_exp").dialog({
                        autoOpen: false,
                        modal: true,
                        width: 400,
                        height: 200,
                        closeOnEscape: false,
                        draggable: false,
                        resizable: false,
                        buttons: {
                            'Yes, Keep Working': function () {
                                $(this).dialog('close');
                            },
                            'No, Logoff': function () {
                                // fire whatever the configured onTimeout callback is.
                                // using .call(this) keeps the default behavior of "this" being the warning
                                // element (the dialog in this case) inside the callback.
                                $.idleTimeout.options.onTimeout.call(this);
                            }
                        }
                    });
                    $("#btn_update_profile").click(function () {
                        $('form#form_update_profile').validationEngine('attach', {promptPosition: "bottomLeft", scroll: false});
                        $("#frm_update_profile").dialog({
                            modal: true,
                            width: 600,
                            height: 530,
                            closeOnEscape: false,
                            draggable: false,
                            resizable: false,
                            buttons: {
                                '<?php echo __('Save'); ?>': function () {
                                    $('#form_update_profile').submit();
                                },
                                '<?php echo __('Cancel'); ?>': function () {
                                    $(this).dialog('close');
                                }
                            }
                        });
                        $(".ui-dialog-buttonset button").addClass('btn btn-success');
                        $("input,select,textarea").addClass('form-control');
                    });
                    $("#btn-logout").click(function () {
                        $("#dialog_logout").attr('title', 'Confirm Logout').dialog({
                            modal: true,
                            width: 400,
                            height: 150,
                            closeOnEscape: false,
                            draggable: false,
                            resizable: false,
                            buttons: {
                                '<?php echo __('Continue logout'); ?>': function () {
                                    window.location.replace('/users/logout/');
                                },
                                '<?php echo __('Cancel'); ?>': function () {
                                    $(this).dialog('close');
                                }
                            }
                        });
                    });
                    // cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
                    var $countdown = $("#dialog-countdown");
                    // start the idle timer plugin
                    $.idleTimeout('#dialog_exp', 'div.ui-dialog-buttonpane button:first', {
                        idleAfter: 30,
                        pollingInterval: 2,
                        keepAliveURL: '/utils/keepalive',
                        serverResponseEquals: 'OK',
                        onTimeout: function () {
                            window.location = "/users/logout/";
                        },
                        onIdle: function () {
                            $(this).dialog("open");
                        },
                        onCountdown: function (counter) {
                            $countdown.html(counter); // update the counter
                        }
                    });
                    $('.rupiah').priceFormat({
                        prefix: 'Rp ',
                        centsSeparator: ',',
                        thousandsSeparator: '.',
                        centsLimit: 0
                    });
                    $('[rel="popup"]').click(function () {
                        var id = $(this).attr('p_id');
                        var title = $(this).attr('p_title');
                        var url = $(this).attr('p_url');
                        $("#dialog").attr("title", title)
                                .html('<iframe src="/' + url + '" style="width:100%; height:100%; border:0;"></iframe>')
                                .dialog({
                                    modal: true,
                                    width: 800,
                                    height: 500,
                                    buttons: {
                                        "ok": function () {
                                            $(this).dialog("close");
                                        }
                                    }
                                });
                    });
                    WinMove();
<?php if ($this->Session->check('Message.flash')) { ?>
                        setTimeout(function () {
                            $.playSound('/img/chimes.wav');
                            $.gritter.add({
                                title: 'Information',
                                text: '<?php echo $this->Session->flash('flash'); ?>',
                                time: 3000
                            });
                        }, 1000);
<?php } ?>
                </script>
                <?php if ($userdata['group_id'] == 3) { ?>
                    <script>
                        $(function () {
                            var cek_tagihan_count = function () {
                                $.get("<?php echo $this->webroot . 'deadline/getTagihanCount'; ?>", function (resp) {
                                    //alert(resp);
                                    $("#tagihan_count").html('<strong>' + resp + '</strong> order hampir deadline').fadeTo(50, 0.1).fadeTo(200, 1.0);
                                });
                            }
                            cek_tagihan_count();
                        });
                    </script>
                <?php } ?>
                <div class="footer">
                    <div class="pull-left">
                        <i class="fa fa-signal"></i> <strong><?php echo $this->Info->application('company_name'); ?></strong>.
                    </div>
                    <div class="pull-left vertical-divider">
                        <i class="fa fa-globe"></i> Connect from <strong><?php echo $_SERVER['REMOTE_ADDR']; ?></strong>.
                    </div>
                    <div class="pull-left vertical-divider">
                        <i class="fa fa-user"></i>  <strong><?php echo $this->Session->read('Auth.User.username'); ?></strong>.
                    </div>
                    <div class="pull-left vertical-divider">
                        <i class="fa fa-signal"></i> Page generated in <strong><?php echo round(microtime(true) - TIME_START, 3); ?></strong> seconds.
                    </div>
                    <div class="pull-right">
                        <strong>Copyright</strong> Gaivo Corporation &copy; 2010-<?php echo date("Y"); ?>
                    </div>
                </div>
                <?php echo $this->element('sql_dump'); ?>
                <div id="dialog_exp" title="Your session is about to expire!" style="display: none;">
                    <p>
                        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
                        You will be logged off in <span id="dialog-countdown" style="font-weight:bold; font-size:20px; color:#F00;"></span> seconds.
                    </p>
                    <p>Do you want to continue your session?</p>
                </div>
                <div id="dialog_logout" title="Confirm Logout" style="display: none;">
                    <p>Do you want to continue logging out from this session?</p>
                </div>
                <div class="users form" id="frm_update_profile" title="Update Profile" style="display: none;">
                    <?php echo $this->Form->create('User', array("type" => "file", 'action' => '/update_profile/', 'id' => 'form_update_profile')); ?>
                    <fieldset>
                        <?php
                        echo $this->Form->input('id');
                        echo $this->Form->input('username');
                        echo $this->Form->input('name');
                        echo $this->Form->input('prev_foto', array("type" => "hidden", 'value' => $this->request->data['User']['foto']));
                        echo $this->Form->input('foto', array("type" => "file", "label" => false));
                        echo $this->Form->input('description', array("type" => "textarea"));
                        ?>
                    </fieldset>
                    <?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </body>
</html>