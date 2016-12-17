<div class="row">
    <div class="col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Add School Teacher'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="schoolTeachers form">
                    <?php
                    echo $this->Form->create('SchoolTeacher', array(
                        'inputDefaults' => array(
                            'div' => 'form-group',
                            'wrapInput' => false,
                            'class' => 'form-control'
                        ),
                        'class' => ''
                    ));
                    ?>
                    	<?php
		echo $this->Form->input('name');
	?>
<?php echo $this->Form->submit(__('Submit'), array('class' => 'btn btn-primary btn-lg', 'div' => 'col-sm-12', 'style' => 'margin-top:10px;')); ?><?php echo $this->Form->end(); ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Actions'); ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <?php echo $this->Html->link(__('<i class="icon icon-chevron-left"></i> Back to Index'), array('action' => 'index'),array('class'=>'btn btn-block btn-primary','escape'=>false)); ?> </li>
                <ul class="nav nav-list nav-stacked">
                                        <li><?php echo $this->Html->link(__('<i class="icon icon-th-list"></i> List School Teachers'), array('action' => 'index'),array('escape'=>false)); ?></li>
                    		<li><?php echo $this->Html->link(__('<i class="icon icon-th-list"></i> List School Classes'), array('controller' => 'school_classes', 'action' => 'index'),array('escape'=>false)); ?> </li>
		<li><?php echo $this->Html->link(__('<i class="icon icon-th-list"></i> New School Class'), array('controller' => 'school_classes', 'action' => 'add'),array('escape'=>false)); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</div>
