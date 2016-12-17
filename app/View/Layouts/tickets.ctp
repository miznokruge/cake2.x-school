<?php
$cakeDescription = __d('cake_dev', 'Home');
?>
<!DOCTYPE html>
<html>
<head>
    <?php echo $this->Javascript->link('jquery-1.9.1'); ?>    
    <?php echo $this->Html->charset(); ?>
    <title>            
        <?php echo 'BIS [Belifurniture Information System]' ?>
    </title>
    <?php
        echo $this->Html->meta('icon');
        echo $this->Html->css('big');
        echo $scripts_for_layout;
        echo $this->Html->css('bootstrap3.min.css');
        echo $this->Html->css('display');
        $bodyClass = str_replace($this->webroot, '', $this->here);     
        $bodyClass = str_replace('/', '-', $bodyClass);              
    ?> 
    <script src="<?php echo $this->webroot; ?>js/jquery.cycle.all.js"></script>
</head>
<body id="big" class="big-display">
<div id="errorshow"></div>
<div class="container">     
     <?php echo $content_for_layout; ?>
</div>     
<!--- scripts -->
</body>
</html>