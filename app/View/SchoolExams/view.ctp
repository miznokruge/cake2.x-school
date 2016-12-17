<div class="row">
    <div class="schoolExams view col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-th-list"></i> <?php echo __('School Exam'); ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table-striped table">
                        <tr>		<td><?php echo __('Id'); ?></td>
		<td>
			<?php echo h($schoolExam['SchoolExam']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td width="200"><?php echo __('School Student'); ?></td>
		<td>
			<?php echo $this->Html->link($schoolExam['SchoolStudent']['name'], array('controller' => 'school_students', 'action' => 'view', $schoolExam['SchoolStudent']['id'])); ?>
			&nbsp;
		</td>
</tr><tr>		<td width="200"><?php echo __('School Subject'); ?></td>
		<td>
			<?php echo $this->Html->link($schoolExam['SchoolSubject']['name'], array('controller' => 'school_subjects', 'action' => 'view', $schoolExam['SchoolSubject']['id'])); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Created'); ?></td>
		<td>
			<?php echo h($schoolExam['SchoolExam']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Score'); ?></td>
		<td>
			<?php echo h($schoolExam['SchoolExam']['score']); ?>
			&nbsp;
		</td>
</tr>                    </table>
                </div>
            </div>
        </div>

        <!-- disini -->

                    </div>
    <div class="col-md-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"> <i class="fa fa-star"></i><?php echo __('Actions'); ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <ul class="list-group bord-no">
                    		<li class="list-group-item"><?php echo $this->Html->link(__('<i class="fa fa-chevron-left"></i> Back to Index'), array('action' => 'index'),array('escape'=>false)); ?> </li>
                    		<li class="list-group-item"><?php echo $this->Html->link(__('Edit School Exam'), array('action' => 'edit', $schoolExam['SchoolExam']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Form->postLink(__('Delete School Exam'), array('action' => 'delete', $schoolExam['SchoolExam']['id']), array(), __('Are you sure you want to delete # %s?', $schoolExam['SchoolExam']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Exams'), array('action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Exam'), array('action' => 'add')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Students'), array('controller' => 'school_students', 'action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Student'), array('controller' => 'school_students', 'action' => 'add')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Subjects'), array('controller' => 'school_subjects', 'action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Subject'), array('controller' => 'school_subjects', 'action' => 'add')); ?> </li>
                </ul>
            </div>
        </div>
    </div>

</div>