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
        <!--STYLESHEET-->
        <!--=================================================-->
        <!--Open Sans Font [ OPTIONAL ] -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="/css/bootstrap.min.css" rel="stylesheet">
        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="/css/nifty.min.css" rel="stylesheet">
        <!--Font Awesome [ OPTIONAL ]-->
        <link href="/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!--Animate.css [ OPTIONAL ]-->
        <link href="/plugins/animate-css/animate.min.css" rel="stylesheet">
        <!--Morris.js [ OPTIONAL ]-->
        <link href="/plugins/morris-js/morris.min.css" rel="stylesheet">
        <!--Switchery [ OPTIONAL ]-->
        <link href="/plugins/switchery/switchery.min.css" rel="stylesheet">
        <!--Bootstrap Select [ OPTIONAL ]-->
        <link href="/plugins/bootstrap-select/bootstrap-select.min.css" rel="stylesheet">
        <!--Demo script [ DEMONSTRATION ]-->
        <link href="/css/demo/nifty-demo.min.css" rel="stylesheet">
        <!--SCRIPT-->
        <!--=================================================-->
        <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="/plugins/pace/pace.min.css" rel="stylesheet"/>
        <script src="/plugins/pace/pace.min.js"></script>
        <!--jQuery [ REQUIRED ]-->
        <script src="/js/jquery-2.1.1.min.js"></script>
        <script src="/js/jquery-ui-1.8.22.custom.min.js"></script>
        <!--BootstrapJS [ RECOMMENDED ]-->
        <script src="/js/bootstrap.min.js" ></script>
        <script src="/plugins/bootstrap-validator/bootstrapValidator.min.js"></script>
        <script src="/js/demo/form-validation.js"></script>
        <?php echo $this->Html->script('jquery.validationEngine-en'); 
        echo $this->Html->script('jquery.validationEngine'); 
        echo $this->Html->css(array('animate', 'jquery.fancybox', 'select2'));
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
        ?>
    </head>
    <!--TIPS-->
    <!--You may remove all ID or Class names which contain "demo-", they are only used for demonstration. -->
    <body>
        <div id="container" class="effect mainnav-lg">
            <!--NAVBAR-->
            <!--===================================================-->
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
                                <a class="mainnav-toggle" href="#">
                                    <i class="fa fa-navicon fa-lg"></i>
                                </a>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End Navigation toogle button-->
                            <!--Messages Dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <i class="fa fa-envelope fa-lg"></i>
                                    <span class="badge badge-header badge-warning">9</span>
                                </a>
                                <!--Message dropdown menu-->
                                <div class="dropdown-menu dropdown-menu-md with-arrow">
                                    <div class="pad-all bord-btm">
                                        <p class="text-lg text-muted text-thin mar-no">You have 3 messages.</p>
                                    </div>
                                    <div class="nano scrollable">
                                        <div class="nano-content">
                                            <ul class="head-list">
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <img src="img/av2.png" alt="Profile Picture" class="img-circle img-sm">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Andy sent you a message</div>
                                                            <small class="text-muted">15 minutes ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <img src="img/av4.png" alt="Profile Picture" class="img-circle img-sm">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Lucy sent you a message</div>
                                                            <small class="text-muted">30 minutes ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <img src="img/av3.png" alt="Profile Picture" class="img-circle img-sm">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Jackson sent you a message</div>
                                                            <small class="text-muted">40 minutes ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <img src="img/av6.png" alt="Profile Picture" class="img-circle img-sm">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Donna sent you a message</div>
                                                            <small class="text-muted">5 hours ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <img src="img/av4.png" alt="Profile Picture" class="img-circle img-sm">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Lucy sent you a message</div>
                                                            <small class="text-muted">Yesterday</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <img src="img/av3.png" alt="Profile Picture" class="img-circle img-sm">
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Jackson sent you a message</div>
                                                            <small class="text-muted">Yesterday</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--Dropdown footer-->
                                    <div class="pad-all bord-top">
                                        <a href="#" class="btn-link text-dark box-block">
                                            <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Messages
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End message dropdown-->
                            <!--Notification dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="dropdown">
                                <a href="#" data-toggle="dropdown" class="dropdown-toggle">
                                    <i class="fa fa-bell fa-lg"></i>
                                    <span class="badge badge-header badge-danger">5</span>
                                </a>
                                <!--Notification dropdown menu-->
                                <div class="dropdown-menu dropdown-menu-md with-arrow">
                                    <div class="pad-all bord-btm">
                                        <p class="text-lg text-muted text-thin mar-no">You have 3 messages.</p>
                                    </div>
                                    <div class="nano scrollable">
                                        <div class="nano-content">
                                            <ul class="head-list">
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#">
                                                        <div class="clearfix">
                                                            <p class="pull-left">Database Repair</p>
                                                            <p class="pull-right">70%</p>
                                                        </div>
                                                        <div class="progress progress-sm">
                                                            <div style="width: 70%;" class="progress-bar">
                                                                <span class="sr-only">70% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#">
                                                        <div class="clearfix">
                                                            <p class="pull-left">Upgrade Progress</p>
                                                            <p class="pull-right">10%</p>
                                                        </div>
                                                        <div class="progress progress-sm">
                                                            <div style="width: 10%;" class="progress-bar progress-bar-warning">
                                                                <span class="sr-only">10% Complete</span>
                                                            </div>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <span class="icon-wrap icon-circle bg-primary">
                                                                <i class="fa fa-comment fa-lg"></i>
                                                            </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">New comments waiting approval</div>
                                                            <small class="text-muted">15 minutes ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <span class="badge badge-success pull-right">90%</span>
                                                        <div class="media-left">
                                                            <span class="icon-wrap icon-circle bg-danger">
                                                                <i class="fa fa-hdd-o fa-lg"></i>
                                                            </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">HDD is full</div>
                                                            <small class="text-muted">50 minutes ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <span class="icon-wrap bg-info">
                                                                <i class="fa fa-file-word-o fa-lg"></i>
                                                            </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Write a news article</div>
                                                            <small class="text-muted">Last Update 8 hours ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <span class="label label-danger pull-right">New</span>
                                                        <div class="media-left">
                                                            <span class="icon-wrap bg-purple">
                                                                <i class="fa fa-comment fa-lg"></i>
                                                            </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">Comment Sorting</div>
                                                            <small class="text-muted">Last Update 8 hours ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                                <!-- Dropdown list-->
                                                <li>
                                                    <a href="#" class="media">
                                                        <div class="media-left">
                                                            <span class="icon-wrap bg-success">
                                                                <i class="fa fa-user fa-lg"></i>
                                                            </span>
                                                        </div>
                                                        <div class="media-body">
                                                            <div class="text-nowrap">New User Registered</div>
                                                            <small class="text-muted">4 minutes ago</small>
                                                        </div>
                                                    </a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <!--Dropdown footer-->
                                    <div class="pad-all bord-top">
                                        <a href="#" class="btn-link text-dark box-block">
                                            <i class="fa fa-angle-right fa-lg pull-right"></i>Show All Notifications
                                        </a>
                                    </div>
                                </div>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End notifications dropdown-->
                            <!--Mega dropdown-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="mega-dropdown">
                                <a href="#" class="mega-dropdown-toggle">
                                    <i class="fa fa-th-large fa-lg"></i>
                                </a>
                                <div class="dropdown-menu mega-dropdown-menu">
                                    <div class="clearfix">
                                        <div class="col-sm-12 col-md-3">
                                            <!--Mega menu widget-->
                                            <div class="text-center bg-purple pad-all">
                                                <h3 class="text-thin mar-no">Weekend shopping</h3>
                                                <div class="pad-ver box-inline">
                                                    <span class="icon-wrap icon-wrap-lg icon-circle bg-trans-light">
                                                        <i class="fa fa-shopping-cart fa-4x"></i>
                                                    </span>
                                                </div>
                                                <p class="pad-btm">
                                                    Members get <span class="text-lg text-bold">50%</span> more points. Lorem ipsum dolor sit amet!
                                                </p>
                                                <a href="#" class="btn btn-purple">Learn More...</a>
                                            </div>
                                        </div>
                                        <div class="col-sm-4 col-md-3">
                                            <!--Mega menu list-->
                                            <ul class="list-unstyled">
                                                <li class="dropdown-header">Pages</li>
                                                <li><a href="#">Profile</a></li>
                                                <li><a href="#">Search Result</a></li>
                                                <li><a href="#">FAQ</a></li>
                                                <li><a href="#">Sreen Lock</a></li>
                                                <li><a href="#" class="disabled">Disabled</a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Icons</li>
                                                <li><a href="#"><span class="pull-right badge badge-purple">479</span> Font Awesome</a></li>
                                                <li><a href="#">Skycons</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-4 col-md-3">
                                            <!--Mega menu list-->
                                            <ul class="list-unstyled">
                                                <li class="dropdown-header">Mailbox</li>
                                                <li><a href="#"><span class="pull-right label label-danger">Hot</span>Indox</a></li>
                                                <li><a href="#">Read Message</a></li>
                                                <li><a href="#">Compose</a></li>
                                                <li class="divider"></li>
                                                <li class="dropdown-header">Featured</li>
                                                <li><a href="#">Smart navigation</a></li>
                                                <li><a href="#"><span class="pull-right badge badge-success">6</span>Exclusive plugins</a></li>
                                                <li><a href="#">Lot of themes</a></li>
                                                <li><a href="#">Transition effects</a></li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-4 col-md-3">
                                            <!--Mega menu list-->
                                            <ul class="list-unstyled">
                                                <li class="dropdown-header">Components</li>
                                                <li><a href="#">Tables</a></li>
                                                <li><a href="#">Charts</a></li>
                                                <li><a href="#">Forms</a></li>
                                                <li class="divider"></li>
                                                <li>
                                                    <form role="form" class="form">
                                                        <div class="form-group">
                                                            <label class="dropdown-header" for="demo-megamenu-input">Newsletter</label>
                                                            <input id="demo-megamenu-input" type="email" placeholder="Enter email" class="form-control">
                                                        </div>
                                                        <button class="btn btn-primary btn-block" type="submit">Submit</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End mega dropdown-->
                        </ul>
                        <ul class="nav navbar-top-links pull-right">
                            <!--Language selector-->
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <li class="dropdown">
                                <a id="demo-lang-switch" class="lang-selector dropdown-toggle" href="#" data-toggle="dropdown">
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
                            <!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
                            <!--End user dropdown-->
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
                    <!--===================================================-->
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
                        <!--Shortcut buttons-->
						<!--                       
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
						-->
                        <!--================================-->
                        <!--End shortcut buttons-->
                        <!--Menu-->
                        <!--================================-->
                        <div id="mainnav-menu-wrap">
                            <div class="nano">
                                <div class="nano-content">
                                    <ul id="mainnav-menu" class="list-group">
                                        <!--Category name-->
                                       <!-- 
									   <li class="list-header">Navigation</li>                                        
                                        <li class="active-link">
                                            <a href="<?php echo $this->webroot; ?>">
                                                <i class="fa fa-dashboard"></i>
                                                <span class="menu-title">
                                                    <strong>Dashboard</strong>
                                                    <span class="label label-success pull-right">Top</span>
                                                </span>
                                            </a>
                                        </li>-->
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
                                                        <ul class="collapse">
                                                            <?php foreach ($menu['children'] as $mc) { ?>
                                                                <li>
                                                                    <a href="#"><?php echo $mc['Menu']['name'] ?></a>
                                                                    <?php if (count($mc['children']) > 0) { ?>
                                                                        <ul class="collapse">
                                                                            <?php foreach ($mc['children'] as $c) { ?>
                                                                                <li><a href="/<?php echo $c['Menu']['controller'] . '/' . $c['Menu']['action']; ?>"><?php echo ucwords(str_replace("-", " ", $c['Menu']['name'])) ?></a></li>
                                                                            <?php } ?>
                                                                        </ul>
                                                                    <?php } ?>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
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
                                    <!--================================-->
                                    <!--End widget-->
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
            
            <!--===================================================-->
            <!-- END FOOTER -->
            <!-- SCROLL TOP BUTTON -->
            <!--===================================================-->
            <button id="scroll-top" class="btn"><i class="fa fa-chevron-up"></i></button>
            <!--===================================================-->
        </div>
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
                <div class="hide-fixed pull-right pad-rgt"><?php echo $_SERVER['REMOTE_ADDR']; ?> | page generated in <?php echo round(microtime(true) - TIME_START, 3); ?> seconds</div>
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <!-- Remove the class name "show-fixed" and "hide-fixed" to make the content always appears. -->
                <!-- ~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~ -->
                <p class="pad-lft">&#0169; <?php echo date("Y"); ?> <?php echo $this->Info->application('company_name'); ?></p>
            </footer>
        <!--Fast Click [ OPTIONAL ]-->
        <script src="/plugins/fast-click/fastclick.min.js"></script>
        <script src="/js/nifty.min.js"></script>
        <script src="/plugins/morris-js/morris.min.js"></script>
        <script src="/plugins/morris-js/raphael-js/raphael.min.js"></script>
        <script src="/plugins/sparkline/jquery.sparkline.min.js"></script>
        <script src="/plugins/skycons/skycons.min.js"></script>
        <script src="/plugins/switchery/switchery.min.js"></script>
        <script src="/plugins/bootstrap-select/bootstrap-select.min.js"></script>
        <script src="/js/demo/nifty-demo.min.js"></script>
        <script src="/js/demo/dashboard.js"></script>
        <script>
            $(function () {

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
<?php if ($this->Session->read('Message.flash.message') != '') { ?>
                    $.niftyNoty({
                        type: 'success',
                        icon: 'fa fa-info fa-lg',
                        title: 'Information',
                        message: "<?php echo $this->Session->read('Message.flash.message'); ?>.",
                        timer: 10000
                    });
<?php } ?>

                $("#demo-lang-switch").niftyLanguage({
                    onChange: function (e) {
                        $.niftyNoty({
                            type: "info",
                            icon: "fa fa-info fa-lg",
                            title: "Language changed",
                            message: "The language apparently changed, the selected language is : <strong> " + e.id + " " + e.name + "</strong> "
                        });
                        $.get('/lang/setlang/' + e.id, function () {
                            window.location.reload(true);
                        });
                    }
                });
            });
        </script>
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
                echo $this->Form->input('prev_foto', array("type" => "hidden", 'value' => $this->Info->userdata($loggeuser_id, 'foto')));
                echo $this->Form->input('foto', array("type" => "file", "label" => false));
                echo $this->Form->input('description', array("type" => "textarea"));
                ?>
            </fieldset>
            <?php echo $this->Form->end(); ?>
        </div>
        <?php echo $this->element('sql_dump'); ?>
    </body>
</html>
