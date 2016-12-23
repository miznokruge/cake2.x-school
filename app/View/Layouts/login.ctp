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
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $this->Info->application('app_name'); ?> | Login</title>
        <!--STYLESHEET-->
        <!--=================================================-->
        <!--Open Sans Font [ OPTIONAL ] -->
        <link href="http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700&amp;subset=latin" rel="stylesheet">
        <!--Bootstrap Stylesheet [ REQUIRED ]-->
        <link href="<?php echo $this->webroot; ?>css/bootstrap.min.css" rel="stylesheet">
        <!--Nifty Stylesheet [ REQUIRED ]-->
        <link href="<?php echo $this->webroot; ?>css/nifty.min.css" rel="stylesheet">
        <!--Font Awesome [ OPTIONAL ]-->
        <link href="<?php echo $this->webroot; ?>plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet">
        <!--Demo [ DEMONSTRATION ]-->
        <link href="<?php echo $this->webroot; ?>css/login.css" rel="stylesheet">
        <!--SCRIPT-->
        <!--=================================================-->
        <!--Page Load Progress Bar [ OPTIONAL ]-->
        <link href="plugins/pace/pace.min.css" rel="stylesheet">
        <script src="<?php echo $this->webroot; ?>plugins/pace/pace.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/jquery-2.1.1.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/bootstrap.min.js"></script>
        <?php
        echo $scripts_for_layout;
        if (isset($cssIncludes)) {
            foreach ($cssIncludes as $css) {
                echo $this->Html->css($css);
            }
        }
        if (isset($jsIncludes)) {
            foreach ($jsIncludes as $js) {
                echo $this->Javascript->link($js);
            }
        }
        ?>
    </head>
    <body>
        <div id="container" class="cls-container">
            <div id="bg-overlay" class="bg-img img-login-<?php echo rand(1,7);?>"></div>
            <div class="cls-header cls-header-lg">
                <div class="cls-brand">
                    <a class="box-inline" href="/">
<!--                        <img alt="Nifty Admin" src="<?php echo $this->webroot; ?>img/logo/<?php echo $this->Info->application('logo'); ?>" class="brand-icon">-->
                        <span class="brand-title"><?php echo $this->Info->application('app_name'); ?></span>
                    </a>
                </div>
            </div>
            <?php echo $content_for_layout; ?>
            <?php echo $this->element('sql_dump'); ?>
        </div>
        <script src="<?php echo $this->webroot; ?>plugins/fast-click/fastclick.min.js"></script>
        <script src="<?php echo $this->webroot; ?>js/nifty.min.js"></script>
    </body>
</html>
