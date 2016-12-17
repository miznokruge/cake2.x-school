<?php
$cakeDescription = __d('cake_dev', 'Home');
header("Cache-Control: no-cache,no-store,must-revalidate");
header("Expires: -1");
$loggeuser_id = $this->Session->read('UserAuth.User.id');
$user_group_id = $this->Session->read("UserAuth.User.user_group_id");
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <?php echo $this->Html->charset(); ?>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>
            <?php echo $this->Info->application('app_name'); ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <link href="/css/fonts.css" rel="stylesheet">
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <link href="/css/nifty.min.css" rel="stylesheet">
        <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <link href="/plugins/animate-css/animate.min.css" rel="stylesheet">
        <link href="/plugins/morris-js/morris.min.css" rel="stylesheet">
        <link href="/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <link href="/css/demo/nifty-demo.min.css" rel="stylesheet">
        <link href="/css/select2.css" rel="stylesheet">
        <link href="/css/noty.css" rel="stylesheet">
        <link href="/css/jquery-ui-1.8.22.custom.css" rel="stylesheet">
        <link href="/plugins/pace/pace.min.css" rel="stylesheet"/>
        <script src="/js/jquery-2.1.1.min.js"></script>
        <script src="/js/jquery-ui-1.8.22.custom.min.js"></script>
        <script src="/js/bootstrap.min.js" ></script>
        <script src="/js/select2.min.js" ></script>
        <script src="/js/noty/jquery.noty.js" ></script>
        <script src="/plugins/pace/pace.min.js"></script>
        <link rel="stylesheet" href="custom.css"/>
        <script src="/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
        <?php
        echo $this->Html->script(array('jquery.validationEngine-en', 'jquery.validationEngine'));
        echo $this->Html->css(array('animate', 'jquery.fancybox', 'select2', 'jquery.treegrid'));
        echo $this->Html->css(array('Aristo.css', 'validationEngine.jquery.css'));
        echo $scripts_for_layout;
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
        if ($this->UserAuth->isLogged()) {
            ?>
            <script type="text/javascript">
                var loggedin = 1;
    <?php if ($this->Session->read("Message.flash.message") != '') { ?>
                    var global_flash_message = "<?php echo $this->Session->read("Message.flash.message") ?>";
                    var global_flash_message_out = 1;
    <?php } else { ?>
                    var global_flash_message_out = 0;
    <?php } ?>
            </script>
        <?php } else { ?>
            <script type="text/javascript">
                var loggedin = 0;
            </script>
        <?php } ?>

    </head>
    <body>
        <div id="container" class="effect mainnav-out">
            <header id="navbar">
                <div id="navbar-container" class="boxed">
                    <!--Brand logo & name-->
                    <!--================================-->
                    <div class="navbar-header">
                        <a href="<?php echo $this->webroot ?>" class="navbar-brand">
                            <?php
                            echo $this->Html->image('logo/' . $this->Info->application('logo'));
                            //echo $this->Html->image('logo/' . $this->Info->application('logo'), array('class' => 'img-circle brand-icon'))
                            ?>
                            <div class="brand-title">
                                <span class="brand-text"><?php echo $this->Info->application('app_name'); ?></span>
                            </div>
                        </a>
                    </div>
                    <!--================================-->
                    <!--End brand logo & name-->
                    <!--Navbar Dropdown-->
                    <!--================================-->
                    <div class="navbar-content clearfix">
                        <ul class="nav navbar-top-links pull-left">
                            <!--Navigation toogle button-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="tgl-menu-btn">
                                <a class="mainnav-toggle push" href="#">
                                    <i class="fa fa-navicon fa-lg"></i>
                                </a>
                            </li>
                            <?php echo $this->element('message2'); ?>
                            <?php echo $this->element('message'); ?>
                            <?php //echo $this->element('mega_dropdown'); ?>
                        </ul>
                        <ul class="nav navbar-top-links pull-right">
                            <!--Language selector-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="dropdown">
                                <a id="lang-switch" class="lang-selector dropdown-toggle" href="#" data-toggle="dropdown">
                                    <span class="lang-selected">
                                        <?php
                                        if ($current_language == 'eng') {
                                            $bahasa = 'English';
                                        } elseif ($current_language == 'jpn') {
                                            $bahasa = 'Japan';
                                        } else {
                                            $bahasa = 'Bahasa';
                                        }
                                        ?>
                                        <?php echo $this->Html->image($current_language . '.png', array('class' => 'lang-flag')); ?>
                                        <span class="lang-id"><?php echo $current_language ?></span>
                                        <span class="lang-name"><?php echo $bahasa; ?></span>
                                    </span>
                                </a>

                                <!--Language selector menu-->
                                <ul class="head-list dropdown-menu with-arrow">
                                    <li>
                                        <a href="/lang/setlang/eng">
                                            <?php echo $this->Html->image('eng.png', array('class' => 'lang-flag')); ?>
                                            <span class="lang-id">ENG</span>
                                            <span class="lang-name">English</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/lang/setlang/ind">
                                            <?php echo $this->Html->image('ind.png', array('class' => 'lang-flag')); ?>
                                            <span class="lang-id">IND</span>
                                            <span class="lang-name">Bahasa Indonesia</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="/lang/setlang/jpn">
                                            <?php echo $this->Html->image('jpn.png', array('class' => 'lang-flag')); ?>
                                            <span class="lang-id">JPN</span>
                                            <span class="lang-name">Japan</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End language selector-->
                            <!--User dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li id="dropdown-user" class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle text-right">
                                    <span class="pull-right">
                                        <img class="img-circle img-user media-object" src="<?php echo $this->webroot ?>img/foto_profile/<?php echo str_replace('.', '_30.', $this->Info->userdata($this->UserAuth->getUserId(), 'foto')) ?>" alt="Profile Picture">
                                    </span>
                                    <div class="username hidden-xs"><?php echo ucwords($this->UserAuth->getUsername()) ?></div>
                                </a>
                                <div class="dropdown-menu dropdown-menu-md dropdown-menu-right with-arrow panel-default">
                                    <!-- Dropdown heading  -->
                                    <div class="pad-all bord-btm">
                                        <p class="text-lg text-muted text-thin mar-btm">750Gb of 1,000Gb Used</p>
                                        <div class="progress progress-sm">
                                            <div class="progress-bar" style="width: 70%;">
                                                <span class="sr-only">70%</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- User dropdown menu -->
                                    <ul class="head-list">
                                        <li>
                                            <a href="/messages/">
                                                <i class="fa fa-envelope fa-fw fa-lg"></i>
                                                Mailbox (<?php echo count($message_inbox); ?>)</a>
                                        </li>
                                        <li>
                                            <a href="#" id="btn_update_profile">
                                                <i class="fa fa-user-md fa-fw fa-lg"></i> Update Profile</a>
                                        </li>
                                        <li>
                                            <a href="/users/change_password/">
                                                <i class="fa fa-key fa-fw fa-lg"></i> Change Password</a>
                                        </li>
                                        <li class="divider"></li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-user fa-fw fa-lg"></i> Profile
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="badge badge-danger pull-right">9</span>
                                                <i class="fa fa-envelope fa-fw fa-lg"></i> Messages
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <span class="label label-success pull-right">New</span>
                                                <i class="fa fa-gear fa-fw fa-lg"></i> Settings
                                            </a>
                                        </li>
                                        <li>
                                            <a href="#">
                                                <i class="fa fa-question-circle fa-fw fa-lg"></i> Help
                                            </a>
                                        </li>
                                        <li>
                                            <a href="/users/lockscreen">
                                                <i class="fa fa-lock fa-fw fa-lg"></i> Lock screen
                                            </a>
                                        </li>
                                    </ul>
                                    <!-- Dropdown footer -->
                                    <div class="pad-all text-right">
                                        <a href="/logout" class="btn btn-primary">
                                            <i class="fa fa-sign-out fa-fw"></i> Logout
                                        </a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <!--================================-->
                    <!--End Navbar Dropdown-->
                </div>
            </header>
            <!--===================================================-->
            <!--END NAVBAR-->
            <div class="boxed">
                <!--CONTENT CONTAINER-->
                <!--===================================================-->
                <div id="content-container">
                    <?php if ($this->Session->read("Message.flash.message")) { ?>
                        <script type="text/javascript">
                            e.preventDefault();
                            var t = nifty.randomInt(0, 8),
                                    n = function () {
                                        return nifty.randomInt(0, 5) < 4 ? 3e3 : 0
                                    }();
                            $.niftyNoty({
                                type: 'danger',
                                icon: 'fa fa-times fa-lg',
                                title: function () {
                                    return n > 0 ? "Autoclose Alert" : "Sticky Alert Box"
                                }(),
                                message: "<?php echo $this->Session->read("Message.flash.message"); ?>.",
                                timer: 3000});
                        </script>
                    <?php } ?>
                    <div id="page-content">
                        <?php echo $content_for_layout; ?>
                    </div>
                    <!--===================================================-->
                    <!--End page content-->
                </div>
                <!--===================================================-->
                <!--END CONTENT CONTAINER-->
                <!--MAIN NAVIGATION-->
                <!--===================================================-->
                <nav id="mainnav-container">
                    <div id="mainnav">

                        <!--================================-->
                        <!--End shortcut buttons-->
                        <!--Menu-->
                        <!--================================-->
                        <div id="mainnav-menu-wrap">
                            <div class="nano">
                                <div class="nano-content">


                                    <ul id="mainnav-menu" class="list-group">
                                        <div id="mainnav-shortcut">
                                            <ul class="list-unstyled">
                                                <li class="col-xs-4" data-content="Additional Sidebar">
                                                    <a id="demo-toggle-aside" class="shortcut-grid" href="#">
                                                        <i class="fa fa-magic"></i>
                                                    </a>
                                                </li>
                                                <li class="col-xs-4" data-content="Notification">
                                                    <a id="demo-alert" class="shortcut-grid" href="#">
                                                        <i class="fa fa-bullhorn"></i>
                                                    </a>
                                                </li>
                                                <li class="col-xs-4" data-content="Page Alerts">
                                                    <a id="demo-page-alert" class="shortcut-grid" href="#">
                                                        <i class="fa fa-bell"></i>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>

                                        <!--Category name-->

                                        <li class="list-header">Navigation</li>
                                        <li class="active-link">
                                            <a href="<?php echo $this->webroot; ?>">
                                                <i class="fa fa-dashboard"></i>
                                                <span class="menu-title">
                                                    <strong>Dashboard</strong>
                                                    <span class="label label-success pull-right">Top</span>
                                                </span>
                                            </a>
                                        </li>
                                        <!--Menu list item-->
                                        <?php
                                        $mcount = 1;
                                        foreach ($menus as $menu) {
                                            if ((int) $menu['Menu']['enabled'] == 1) {
                                                ?>
                                                <li>
                                                    <a href="#">
                                                        <i class="fa <?php echo $menu['Menu']['icon']; ?>"></i>
                                                        <span class="menu-title"><?php echo ucwords($menu['Menu']['name']); ?></span>
                                                        <i class="arrow"></i>
                                                    </a>
                                                    <?php if (count($menu['children']) > 0) { ?>
                                                        <ul class="collapse" aria-expanded="false" style="height: 0px;">
                                                            <?php foreach ($menu['children'] as $mc) { ?>
                                                                <li>
                                                                    <?php if (count($mc['children']) > 0) { ?>
                                                                    <a href="#"><?php echo $mc['Menu']['name'] ?></a>                                                                    
                                                                        <ul class="collapse">
                                                                            <?php foreach ($mc['children'] as $c) { ?>
                                                                                <li><a href="/<?php echo $c['Menu']['controller'] . '/' . $c['Menu']['action']; ?>"><?php echo ucwords(str_replace("-", " ", $c['Menu']['name'])) ?></a></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php }else{?>
                                                                    <a href="/<?php echo $mc['Menu']['controller'] ?>/<?php echo $mc['Menu']['action'] ?>"><?php echo $mc['Menu']['name'] ?></a>         
                                                                    <?php }?>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    <?php } else { ?>
                                                        <a href="/<?php echo ucwords($menu['Menu']['controller']); ?>/<?php echo ucwords($menu['Menu']['action']); ?>">
                                                            <i class="fa <?php echo $menu['Menu']['icon']; ?>"></i>
                                                            <span class="menu-title"><?php echo ucwords($menu['Menu']['name']); ?></span>
                                                            <i class="arrow"></i>
                                                        </a>
                                                    <?php } ?>
                                                </li>
                                            <?php } ?>
                                        <?php } ?>
                                    </ul>
                                    <!--Widget-->
                                    <!--================================-->
                                    <div class="mainnav-widget">
                                        <!-- Show the button on collapsed navigation -->
                                        <div class="show-small">
                                            <a href="#" data-toggle="menu-widget" data-target="#demo-wg-server">
                                                <i class="fa fa-desktop"></i>
                                            </a>
                                        </div>
                                        <!-- Hide the content on collapsed navigation -->
                                        <div id="demo-wg-server" class="hide-small mainnav-widget-content">
                                            <ul class="list-group bg-trans">
                                                <li class="list-header pad-no pad-ver">Online Users</li>
                                                <li class="mar-btm">
                                                    <a href="#" class="list-group-item list-item-sm">
                                                        <span class="badge badge-success badge-icon badge-fw pull-left"></span>
                                                        Johny Juan
                                                    </a>
                                                </li>
                                                <li class="mar-btm">
                                                    <a href="#" class="list-group-item list-item-sm">
                                                        <span class="badge badge-danger badge-icon badge-fw pull-left"></span>
                                                        Susan Sun
                                                    </a>
                                                </li>

                                                <uls>
                                                    <ul class="list-group">
                                                        <li class="list-header pad-no pad-ver">Server Status</li>
                                                        <li class="mar-btm">
                                                            <span class="label label-primary pull-right">15%</span>
                                                            <p>CPU Usage</p>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar progress-bar-primary" style="width: 15%;">
                                                                    <span class="sr-only">15%</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="mar-btm">
                                                            <span class="label label-purple pull-right">75%</span>
                                                            <p>Bandwidth</p>
                                                            <div class="progress progress-sm">
                                                                <div class="progress-bar progress-bar-purple" style="width: 75%;">
                                                                    <span class="sr-only">75%</span>
                                                                </div>
                                                            </div>
                                                        </li>
                                                        <li class="pad-ver"><a href="#" class="btn btn-success btn-bock">View Details</a></li>
                                                    </ul>
                                                    </div>
                                                    </div>

                                                    </div>
                                                    </div>
                                                    </div>
                                                    <!--================================-->
                                                    <!--End menu-->
                                                    </div>
                                                    </nav>
                                                    <!--===================================================-->
                                                    <!--END MAIN NAVIGATION-->
                                                    <!--ASIDE-->
                                                    <!--===================================================-->
                                                    <aside id="aside-container">
                                                        <div id="aside">
                                                            <div class="nano">
                                                                <div class="nano-content">
                                                                    <!--Nav tabs-->
                                                                    <!--================================-->
                                                                    <ul class="nav nav-tabs nav-justified">
                                                                        <li class="active">
                                                                            <a href="#demo-asd-tab-1" data-toggle="tab">
                                                                                <i class="fa fa-comments"></i>
                                                                                <span class="badge badge-purple">7</span>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#demo-asd-tab-2" data-toggle="tab">
                                                                                <i class="fa fa-info-circle"></i>
                                                                            </a>
                                                                        </li>
                                                                        <li>
                                                                            <a href="#demo-asd-tab-3" data-toggle="tab">
                                                                                <i class="fa fa-wrench"></i>
                                                                            </a>
                                                                        </li>
                                                                    </ul>
                                                                    <!--================================-->
                                                                    <!--End nav tabs-->
                                                                    <!-- Tabs Content -->
                                                                    <!--================================-->
                                                                    <div class="tab-content">
                                                                        <!--First tab (Contact list)-->
                                                                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                                                        <div class="tab-pane fade in active" id="demo-asd-tab-1">
                                                                            <h4 class="pad-hor text-thin">
                                                                                <span class="pull-right badge badge-warning">3</span> Family
                                                                            </h4>
                                                                            <!--Family-->
                                                                            <div class="list-group bg-trans">
                                                                                <a href="#" class="list-group-item">
                                                                                    <div class="media-left">
                                                                                        <img class="img-circle img-xs" src="img/av2.png" alt="Profile Picture">
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="text-lg">Stephen Tran</div>
                                                                                        <span class="text-muted">Availabe</span>
                                                                                    </div>
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <div class="media-left">
                                                                                        <img class="img-circle img-xs" src="img/av4.png" alt="Profile Picture">
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="text-lg">Brittany Meyer</div>
                                                                                        <span class="text-muted">I think so</span>
                                                                                    </div>
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <div class="media-left">
                                                                                        <img class="img-circle img-xs" src="img/av3.png" alt="Profile Picture">
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="text-lg">Donald Brown</div>
                                                                                        <span class="text-muted">Lorem ipsum dolor sit amet.</span>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                            <hr>
                                                                            <h4 class="pad-hor text-thin">
                                                                                <span class="pull-right badge badge-info">4</span> Friends
                                                                            </h4>
                                                                            <!--Friends-->
                                                                            <div class="list-group bg-trans">
                                                                                <a href="#" class="list-group-item">
                                                                                    <div class="media-left">
                                                                                        <img class="img-circle img-xs" src="img/av5.png" alt="Profile Picture">
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="text-lg">Betty Murphy</div>
                                                                                        <span class="text-muted">Bye</span>
                                                                                    </div>
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <div class="media-left">
                                                                                        <img class="img-circle img-xs" src="img/av6.png" alt="Profile Picture">
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="text-lg">Olivia Spencer</div>
                                                                                        <span class="text-muted">Thank you!</span>
                                                                                    </div>
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <div class="media-left">
                                                                                        <img class="img-circle img-xs" src="img/av4.png" alt="Profile Picture">
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="text-lg">Sarah Ruiz</div>
                                                                                        <span class="text-muted">2 hours ago</span>
                                                                                    </div>
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <div class="media-left">
                                                                                        <img class="img-circle img-xs" src="img/av3.png" alt="Profile Picture">
                                                                                    </div>
                                                                                    <div class="media-body">
                                                                                        <div class="text-lg">Paul Aguilar</div>
                                                                                        <span class="text-muted">2 hours ago</span>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                            <hr>
                                                                            <h4 class="pad-hor text-thin">
                                                                                <span class="pull-right badge badge-success">Offline</span> Works
                                                                            </h4>
                                                                            <!--Works-->
                                                                            <div class="list-group bg-trans">
                                                                                <a href="#" class="list-group-item">
                                                                                    <span class="badge badge-purple badge-icon badge-fw pull-left"></span> Joey K. Greyson
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <span class="badge badge-info badge-icon badge-fw pull-left"></span> Andrea Branden
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <span class="badge badge-pink badge-icon badge-fw pull-left"></span> Lucy Moon
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <span class="badge badge-success badge-icon badge-fw pull-left"></span> Johny Juan
                                                                                </a>
                                                                                <a href="#" class="list-group-item">
                                                                                    <span class="badge badge-danger badge-icon badge-fw pull-left"></span> Susan Sun
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                                                        <!--End first tab (Contact list)-->
                                                                        <!--Second tab (Custom layout)-->
                                                                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                                                        <div class="tab-pane fade" id="demo-asd-tab-2">
                                                                            <!--Monthly billing-->
                                                                            <div class="pad-all">
                                                                                <h4 class="text-lg mar-no">Monthly Billing</h4>
                                                                                <p class="text-sm">January 2015</p>
                                                                                <button class="btn btn-block btn-success mar-top">Pay Now</button>
                                                                            </div>
                                                                            <hr>
                                                                            <!--Information-->
                                                                            <div class="text-center clearfix pad-top">
                                                                                <div class="col-xs-6">
                                                                                    <span class="h4">4,327</span>
                                                                                    <p class="text-muted text-uppercase"><small>Sales</small></p>
                                                                                </div>
                                                                                <div class="col-xs-6">
                                                                                    <span class="h4">$ 1,252</span>
                                                                                    <p class="text-muted text-uppercase"><small>Earning</small></p>
                                                                                </div>
                                                                            </div>
                                                                            <hr>
                                                                            <!--Simple Menu-->
                                                                            <div class="list-group bg-trans">
                                                                                <a href="#" class="list-group-item"><span class="label label-danger pull-right">Featured</span>Edit Password</a>
                                                                                <a href="#" class="list-group-item">Email</a>
                                                                                <a href="#" class="list-group-item"><span class="label label-success pull-right">New</span>Chat</a>
                                                                                <a href="#" class="list-group-item">Reports</a>
                                                                                <a href="#" class="list-group-item">Transfer Funds</a>
                                                                            </div>
                                                                            <hr>
                                                                            <div class="text-center">Questions?
                                                                                <p class="text-lg text-semibold"> (415) 234-53454 </p>
                                                                                <small><em>We are here 24/7</em></small>
                                                                            </div>
                                                                        </div>
                                                                        <!--End second tab (Custom layout)-->
                                                                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                                                        <!--Third tab (Settings)-->
                                                                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                                                        <div class="tab-pane fade" id="demo-asd-tab-3">
                                                                            <ul class="list-group bg-trans">
                                                                                <li class="list-header">
                                                                                    <h4 class="text-thin">Account Settings</h4>
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <div class="pull-right">
                                                                                        <input class="demo-switch" type="checkbox" checked>
                                                                                    </div>
                                                                                    <p>Show my personal status</p>
                                                                                    <small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <div class="pull-right">
                                                                                        <input class="demo-switch" type="checkbox" checked>
                                                                                    </div>
                                                                                    <p>Show offline contact</p>
                                                                                    <small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <div class="pull-right">
                                                                                        <input class="demo-switch" type="checkbox">
                                                                                    </div>
                                                                                    <p>Invisible mode </p>
                                                                                    <small class="text-muted">Lorem ipsum dolor sit amet, consectetuer adipiscing elit.</small>
                                                                                </li>
                                                                            </ul>
                                                                            <hr>
                                                                            <ul class="list-group bg-trans">
                                                                                <li class="list-header"><h4 class="text-thin">Public Settings</h4></li>
                                                                                <li class="list-group-item">
                                                                                    <div class="pull-right">
                                                                                        <input class="demo-switch" type="checkbox" checked>
                                                                                    </div>
                                                                                    Online status
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <div class="pull-right">
                                                                                        <input class="demo-switch" type="checkbox" checked>
                                                                                    </div>
                                                                                    Show offline contact
                                                                                </li>
                                                                                <li class="list-group-item">
                                                                                    <div class="pull-right">
                                                                                        <input class="demo-switch" type="checkbox">
                                                                                    </div>
                                                                                    Show my device icon
                                                                                </li>
                                                                            </ul>
                                                                            <hr>
                                                                            <h4 class="pad-hor text-thin">Task Progress</h4>
                                                                            <div class="pad-all">
                                                                                <p>Upgrade Progress</p>
                                                                                <div class="progress progress-sm">
                                                                                    <div class="progress-bar progress-bar-success" style="width: 15%;"><span class="sr-only">15%</span></div>
                                                                                </div>
                                                                                <small class="text-muted">15% Completed</small>
                                                                            </div>
                                                                            <div class="pad-hor">
                                                                                <p>Database</p>
                                                                                <div class="progress progress-sm">
                                                                                    <div class="progress-bar progress-bar-danger" style="width: 75%;"><span class="sr-only">75%</span></div>
                                                                                </div>
                                                                                <small class="text-muted">17/23 Database</small>
                                                                            </div>
                                                                        </div>
                                                                        <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                                                                        <!--Third tab (Settings)-->
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </aside>
                                                    <!--===================================================-->
                                                    <!--END ASIDE-->
                                                    </div>
                                                    <!-- FOOTER -->
                                                    <!-- FOOTER -->
                                                    <!--===================================================-->
                                                    <footer id="footer">
                                                        <!-- Visible when footer positions are fixed -->
                                                        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                                                        <div class="show-fixed pull-right">
                                                            <ul class="footer-list list-inline">
                                                                <li>
                                                                    <p class="text-sm">SEO Proggres</p>
                                                                    <div class="progress progress-sm progress-light-base">
                                                                        <div style="width: 80%" class="progress-bar progress-bar-danger"></div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <p class="text-sm">Online Tutorial</p>
                                                                    <div class="progress progress-sm progress-light-base">
                                                                        <div style="width: 80%" class="progress-bar progress-bar-primary"></div>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <button class="btn btn-sm btn-dark btn-active-success">Checkout</button>
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <!-- Visible when footer positions are static -->
                                                        <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                                                        <div class="hide-fixed pull-right pad-rgt">
                                                            <i class="fa fa-globe"></i> <?php echo $_SERVER['REMOTE_ADDR']; ?>
                                                            <i class="fa fa-signal"></i> page generated in <?php echo round(microtime(true) - TIME_START, 3); ?> seconds
                                                        </div>
                                                        <p class="pad-lft">&#0169; <?php echo date("Y"); ?> <?php echo $this->Info->application('company_name'); ?></p>
                                                    </footer>
                                                    <?php echo $this->element('sql_dump'); ?>
                                                    </div>

                                                    <!-- END FOOTER -->
                                                    <!-- SCROLL TOP BUTTON -->
                                                    <!--===================================================-->
                                                    <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
                                                    <!--===================================================-->
                                                    <?php //echo $this->element('chat');   ?>
                                                    </div>
                                                    <script src="/plugins/fast-click/fastclick.min.js"></script>
                                                    <script src="/js/nifty.min.js"></script>
                                                    <script src="/plugins/switchery/switchery.min.js"></script>
                                                    <script src="/plugins/bootstrap-select/bootstrap-select.min.js"></script>
                                                    <script src="/js/demo/nifty-demo.min.js"></script>
                                                    <script src="/js/demo/layouts.js"></script>
                                                    <script src="/js/application.js"></script>
                                                    </body>
                                                    </html>
