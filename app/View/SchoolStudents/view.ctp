<div class="row">
    <div class="schoolStudents view col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-th-list"></i> <?php echo __('School Student'); ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table-striped table">
                        <tr>		<td><?php echo __('Id'); ?></td>
		<td>
			<?php echo h($schoolStudent['SchoolStudent']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Name'); ?></td>
		<td>
			<?php echo h($schoolStudent['SchoolStudent']['name']); ?>
			&nbsp;
		</td>
</tr><tr>		<td width="200"><?php echo __('School Class'); ?></td>
		<td>
			<?php echo $this->Html->link($schoolStudent['SchoolClass']['name'], array('controller' => 'school_classes', 'action' => 'view', $schoolStudent['SchoolClass']['id'])); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Created'); ?></td>
		<td>
			<?php echo h($schoolStudent['SchoolStudent']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Deleted'); ?></td>
		<td>
			<?php echo h($schoolStudent['SchoolStudent']['deleted']); ?>
			&nbsp;
		</td>
</tr>                    </table>
                </div>
            </div>
        </div>

        <!-- disini -->

                    <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-star"></i> <?php echo __('Related School Exams'); ?></h3>
                </div> <!-- /panel-header -->
                <div class="panel-body">
                    <?php if (!empty($schoolStudent['SchoolExam'])): ?>
                    <table cellpadding = "0" cellspacing = "0">
                        <tr>
                            		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('School Student Id'); ?></th>
		<th><?php echo __('School Subject Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Score'); ?></th>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        </tr>
                        	<?php foreach ($schoolStudent['SchoolExam'] as $schoolExam): ?>
		<tr>
			<td><?php echo $schoolExam['id']; ?></td>
			<td><?php echo $schoolExam['school_student_id']; ?></td>
			<td><?php echo $schoolExam['school_subject_id']; ?></td>
			<td><?php echo $schoolExam['created']; ?></td>
			<td><?php echo $schoolExam['score']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'school_exams', 'action' => 'view', $schoolExam['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'school_exams', 'action' => 'edit', $schoolExam['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'school_exams', 'action' => 'delete', $schoolExam['id']), array(), __('Are you sure you want to delete # %s?', $schoolExam['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
                    </table>
                    <?php endif; ?>

                    <div class="actions">
                        <ul>
                            <li><?php echo $this->Html->link(__('New School Exam'), array('controller' => 'school_exams', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>
                    </div>
    <div class="col-md-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"> <i class="fa fa-star"></i><?php echo __('Actions'); ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <ul class="list-group bord-no">
                    		<li class="list-group-item"><?php echo $this->Html->link(__('<i class="fa fa-chevron-left"></i> Back to Index'), array('action' => 'index'),array('escape'=>false)); ?> </li>
                    		<li class="list-group-item"><?php echo $this->Html->link(__('Edit School Student'), array('action' => 'edit', $schoolStudent['SchoolStudent']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Form->postLink(__('Delete School Student'), array('action' => 'delete', $schoolStudent['SchoolStudent']['id']), array(), __('Are you sure you want to delete # %s?', $schoolStudent['SchoolStudent']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Students'), array('action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Student'), array('action' => 'add')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Classes'), array('controller' => 'school_classes', 'action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Class'), array('controller' => 'school_classes', 'action' => 'add')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Exams'), array('controller' => 'school_exams', 'action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Exam'), array('controller' => 'school_exams', 'action' => 'add')); ?> </li>
                </ul>
            </div>
        </div>
    </div>

</div>