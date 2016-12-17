<div class="row">
    <div class="col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Copy School Subject'); ?></h3>
            </div>
            <div class="panel-body">
                <div class="schoolSubjects form">
                    <?php
                    echo $this->Form->create('SchoolSubject', array(
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
                                            <li><?php echo $this->Form->postLink(__('<i class="icon icon-trash"></i> Delete'), array('action' => 'delete', $this->Form->value('SchoolSubject.id')),array('escape'=>false), __('Are you sure you want to delete # %s?', $this->Form->value('SchoolSubject.id'))); ?></li>
                                        <li><?php echo $this->Html->link(__('<i class="icon icon-th-list"></i> List School Subjects'), array('action' => 'index'),array('escape'=>false)); ?></li>
                    		<li><?php echo $this->Html->link(__('<i class="icon icon-th-list"></i> List School Exams'), array('controller' => 'school_exams', 'action' => 'index'),array('escape'=>false)); ?> </li>
		<li><?php echo $this->Html->link(__('<i class="icon icon-th-list"></i> New School Exam'), array('controller' => 'school_exams', 'action' => 'add'),array('escape'=>false)); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</div>
