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
<html xmlns="http://www.w3.org/1999/xhtml" ng-app>
    <head>
        <?php echo $this->Html->script('jquery-1.10.2'); ?>
        <?php echo $this->Html->script('jquery-ui-1.8.22.custom.min'); ?>
        <?php echo $this->Html->script('autoNumeric-1.7.4.min'); ?>
        <?php echo $this->Html->script('angular.min'); ?>
        <?php echo $this->Html->script('bootstrap.min'); ?>
        <?php echo $this->Html->script('jquery.validationEngine-en'); ?>
        <?php echo $this->Html->script('jquery.validationEngine'); ?>
        <?php //echo $this->Html->script('trello_count'); ?>
        <?php echo $this->Html->script('supersized.3.2.7.min'); ?>
        <?php echo $this->Html->script('supersized.shutter.min'); ?>
        <?php echo $this->Html->script('jquery.backgroundPosition'); ?>
        <?php echo $this->Html->script('jquery.playsound'); ?>
        <?php echo $this->Html->script('jquery.easing.min'); ?>
        <script src="/js/plugins/iCheck/icheck.min.js"></script>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo $this->Info->application('app_name') ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        //echo $this->Html->css('cake.generic');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('style');
        echo $this->Html->css('animate');
        echo $this->Html->css('validationEngine.jquery');
        echo $this->Html->css('supersized');
        echo $this->Html->css('supersized.shutter');
        echo $scripts_for_layout;
        if (isset($cssIncludes)) {
            foreach ($cssIncludes as $css) {
                echo $this->Html->css($css);
            }
        }
        ?>
        <link href="/font-awesome/css/font-awesome.css" rel="stylesheet"/>
        <?php
        if (isset($jsIncludes)) {
            foreach ($jsIncludes as $js) {
                echo $this->Html->script($js);
            }
        }
        ?>
    </head>
    <body class="gray-bg">
        <p><?php echo $this->Session->flash(); ?></p>

        <div class="middle-box text-center loginscreen  animated fadeInDown">
            <div style="padding: 10px;">
                <!--                <div>
                                    <h1 class="logo-name">G+</h1>
                                </div>-->
                <h3>Welcome to <?php echo $this->Info->application('app_name'); ?></h3>
                <p>
                    Please Sign in using your account
                </p>
                <?php echo $this->Session->read('Message.flash.message'); ?>
                <?php echo $this->Form->create('User', array("class" => "m-t", 'url' => '/login')); ?>
                <fieldset>
                    <?php
                    echo $this->Form->input('username', array("class" => "form-control", "label" => false, "placeholder" => "Username"));
                    echo $this->Form->input('password', array("class" => "form-control", "label" => false, "placeholder" => "Password"));
                    ?>
                </fieldset>
                <?php echo $this->Form->submit('Login', array("class" => "btn btn-primary block full-width m-b")); ?>
                <a href="#"><small>Forgot password?</small></a>
                <p class="text-muted text-center"><small>Do not have an account?</small></p>
                <a class="btn btn-sm btn-success btn-block" href="register.html">Create an account</a>
                <?php echo $this->Form->end(); ?>
            </div>
        </div>

        <?php echo $this->element('sql_dump'); ?>
        <script type="text/javascript">
            $(function () {
                $.supersized({
                    // Functionality
                    start_slide: 0,
                    image_protect: 1, // Disables image dragging and right click with Javascript
                    // Size & Position
                    min_width: 0, // Min width allowed (in pixels)
                    min_height: 0, // Min height allowed (in pixels)
                    vertical_center: 1, // Vertically center background
                    horizontal_center: 1, // Horizontally center background
                    fit_always: 0, // Image will never exceed browser width or height (Ignores min. dimensions)
                    fit_portrait: 1, // Portrait images will not exceed browser height
                    fit_landscape: 0, // Landscape images will not exceed browser width
                    slide_interval: 3000, // Length between transitions
                    transition: 6, // 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
                    transition_speed: 700, // Speed of transition
                    // Components
                    slide_links: 'blank', // Individual links for each slide (Options: false, 'number', 'name', 'blank')
                    slides: [// Slideshow Images
<?php foreach ($backgrounds as $bg): ?>
                            {image: '/img/bg/<?php echo $bg['ComBackground']['src']; ?>', title: 'Image Credit: Maria Kazvan', thumb: '/img/bg/<?php echo $bg['ComBackground']['src']; ?>'},
<?php endforeach; ?>
                    ]
                });
            });
        </script>
        <div id="progress-back" class="load-item">
            <div id="progress-bar"></div>
        </div>
    </body>
</html>