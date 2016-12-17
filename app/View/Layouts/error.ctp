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
            <?php echo 'CRM' ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>
        <?php echo $this->Javascript->link(array('jquery-11.min', 'jquery-ui-1.8.22.custom.min')); ?>
        <?php echo $this->Javascript->link('autoNumeric-1.7.4.min'); ?>
        <?php echo $this->Javascript->link(array('bootstrap.min', 'plugins/metisMenu/jquery.metisMenu', 'plugins/slimscroll/jquery.slimscroll.min', 'inspinia', 'plugins/pace/pace.min')); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine-en'); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine'); ?>
        <?php echo $this->Javascript->link('app/system'); ?>
        <?php echo $this->Javascript->link("plugins/gritter/jquery.gritter.min.js"); ?>
        <?php echo $this->Javascript->link(array('jquery.scrollPagination', 'jquery.playsound', 'jquery.idletimer', 'jquery.idletimeout', 'jquery.fancybox')); ?>
        <!-- Gritter -->
        <link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
        <?php
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css(array('font-awesome.css'));
        echo $this->Html->css(array('Aristo.css', 'style', 'animate', 'jquery.fancybox'));
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
    </head>
    <body>
        <?php echo $content_for_layout; ?>
    </body>
</html>
