<div id="page-title">
    <h1 class="page-header text-overflow"><?php echo $title;?></h1>
    <!--Searchbox-->
    <div class="searchbox">
        <div class="input-group custom-search-form">
            <input type="text" class="form-control" placeholder="Search..">
            <span class="input-group-btn">
                <button class="text-muted" type="button"><i class="fa fa-search"></i></button>
            </span>
        </div>
    </div>
</div>
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<!--End page title-->
<!--Breadcrumb-->
<!--~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~-->
<ol class="breadcrumb">
<?php
            $ccontroller = $this->params['controller'];
            $caction = $this->params['action'];
            $this->Html->addCrumb(ucwords(str_replace("_", " ", $ccontroller)), '/' . $ccontroller);
            $this->Html->addCrumb(ucwords(str_replace("_", " ", $caction)), '/' . $ccontroller . '/' . $caction, array('class' => 'breadcrumblast'));
            echo $this->Html->getCrumbs('  / ', 'Home');
            ?>
</ol>
