<div class="row wrapper border-bottom white-bg">
    <div class="col-lg-6">
        <h2><?php echo $title; ?></h2>
        <div id="breadcrumb">
            <?php
            $ccontroller = $this->params['controller'];
            $caction = $this->params['action'];
            $this->Html->addCrumb(ucwords(str_replace("_", " ", $ccontroller)), '/' . $ccontroller);
            $this->Html->addCrumb(ucwords(str_replace("_", " ", $caction)), '/' . $ccontroller . '/' . $caction, array('class' => 'breadcrumblast'));
            echo $this->Html->getCrumbs('  / ', 'Home');
            ?>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="title-action">
