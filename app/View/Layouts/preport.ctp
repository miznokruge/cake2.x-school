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
        <?php echo $this->Javascript->link('jquery-1.9.1'); ?>
        <?php echo $this->Javascript->link('jquery-ui-1.8.22.custom.min'); ?>
        <?php echo $this->Javascript->link('autoNumeric-1.7.4.min'); ?>
        <?php echo $this->Javascript->link('bootstrap.min'); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine-en'); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine'); ?>
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo 'CRM' ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('cake.generic');
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css('font-awesome.css');
        echo $this->Html->css('Aristo.css');
        //echo $this->Html->css('jquery-ui-1.8.22.custom');
        echo $this->Html->css('trello');
        echo $this->Html->css('validationEngine.jquery.css');
        echo $scripts_for_layout;
        if (isset($cssIncludes)) {
            foreach ($cssIncludes as $css) {
                echo $this->Html->css($css);
            }
        }
        ?>
        <?php if ($this->Session->read('Auth.User')) { ?>
                                                                            <!--<script type="text/javascript" src="https://api.trello.com/1/client.js?key=c824dcc2d054e14643d3111a8e2715ad"></script>-->
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/jquery.masonry.min.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/underscore-min.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/mustache.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/blobbuilder.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/filesaver.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/showdown.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.cookie.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/highcharts.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/exporting.js"></script>   
            <?php
            $userdata = $this->Session->read('Auth.User');
            //unset($userdata['board_id']);
            ?>
        <?php } ?>
        <?php
        if (isset($jsIncludes)) {
            foreach ($jsIncludes as $js) {
                echo $this->Javascript->link($js);
            }
        }
        ?>
    </head>
    <?php
    $bodyClass = str_replace($this->webroot, '', $this->here);
    $bodyClass = str_replace('/', '-', $bodyClass);
    ?>
    <body class="<?php echo $bodyClass; ?>">
        <div id="container">
            <div id="header">
                <div class="actions">
                    <div>
                        <ul>
                            <li>
                                <?php
                                if ($this->Access) {
                                    $username = $this->Access->getUsername();
                                    echo '<p class="current-username">Hello, ' . $username . '</p>';
                                }
                                ?>
                            </li>
                            <?php if ($this->Array->get($userdata, 'board_id') != ''): ?>
                                <li style="margin-right: 30px;">
                                    <?php
                                    echo $this->Html->link(__('Harus dikerjakan '), array('controller' => 'trello', 'action' => 'display'), array('id' => 'tnot', 'style' => 'width:120px;', 'onClick' => 'return true;'));
                                    ?>
                                </li>
                            <?php endif; ?>
                            <li>
                                <?php echo $this->Html->link(__('Logout'), array('controller' => 'users', 'action' => 'logout')); ?>
                            </li>
                        </ul>
                    </div>
                    <?php echo $this->Html->image('logo-tricipta-small.png', array('alt' => 'Tricipta')) ?>
                </div>
                <?php $image = $this->Html->image('crm-logo-changeable.png', array('alt' => 'Tricipta', 'title' => 'Home')) ?>
                <h2><?php echo $this->Html->link($image, '/', array('escape' => false)); ?></h2>
                <form class="form-search" style="margin:10px;" action="<?php echo $this->webroot; ?>orders/search">
                    <a class="btn btn-success" type="button" onClick="history.go(-1);
                            return true;" style="font-size:100%;"> < Back</a>
                </form>
                <form class="form-search" style="position:absolute;top:91px;right:20px;width:auto;" action="<?php echo $this->webroot; ?>orders/search">
                    <div class="input-append">
                        <input type="text" class="span2 search-query" name="po" placeholder="Cari dengan PO">
                            <button type="submit" class="btn"><i class="icon-search"></i>&nbsp;</button>
                    </div>
                    <div class="input-append">
                        <input type="text" class="span2 search-query" name="order_id" placeholder="Cari dengan ID">
                            <button type="submit" class="btn"><i class="icon-search"></i>&nbsp;</button>
                    </div>
                </form>
            </div>
            <?php echo $this->Session->flash(); ?>
            <div id="content">
                <?php echo $content_for_layout; ?>
            </div>
        </div>
<!-- loader -->
<div style="display:none;" class="preloader" id="preloader">
<img src="<?php echo $this->webroot.'img/select2-spinner.gif';?>">&nbsp;please wait..
</div>        
<!-- loader -->
        <?php echo $this->element('sql_dump'); ?>
</body>
</html>