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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php echo $this->Javascript->link('jquery-1.9.1'); ?>
    <script type="text/javascript" src="http://code.jquery.com/ui/1.10.3/jquery-ui.js"></script>      
	<?php echo $this->Html->charset(); ?>
	<title>            
		<?php echo 'BIS [Belifurniture Information System]' ?>
	</title>
	<?php
		echo $this->Html->meta('icon');
		echo $this->Html->css('cake.generic');
        echo $this->Html->css('big');
        echo $this->Html->css('jquery-ui-1.8.22.custom');
		echo $scripts_for_layout;
	?>
</head>
<?php 
    $bodyClass = str_replace($this->webroot, '', $this->here);     
    $bodyClass = str_replace('/', '-', $bodyClass); 
?>
<body class="<?php echo $bodyClass; ?>" id="big">
	<div id="container">
		<?php if($this->view === 'display'):?>
		<div id="header">                 
            <?php $image = $this->Html->image('belifurniturelogo-big.png', array('alt' => 'Tricipta', 'title' => 'Home', 'id' => 'big-logo')) ?>         
            <h2><?php echo $this->Html->link($image, '/', array('escape' => false)); ?></h2>
            <div id="feature-title">
                <span class="text">Belifurniture Information System</span>
            </div>
		</div>
		<?php endif;?>
		<div id="content">
			<?php echo $this->Session->flash(); ?>
			<?php echo $content_for_layout; ?>
		</div>
	</div>
	<?php echo $this->element('sql_dump'); ?>
</body>
</html>