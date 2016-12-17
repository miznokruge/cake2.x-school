<div class="row">
    <div class="schoolTeachers view col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-th-list"></i> <?php echo __('School Teacher'); ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table-striped table">
                        <tr>		<td><?php echo __('Id'); ?></td>
		<td>
			<?php echo h($schoolTeacher['SchoolTeacher']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Name'); ?></td>
		<td>
			<?php echo h($schoolTeacher['SchoolTeacher']['name']); ?>
			&nbsp;
		</td>
</tr>                    </table>
                </div>
            </div>
        </div>

        <!-- disini -->

                    <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-star"></i> <?php echo __('Related School Classes'); ?></h3>
                </div> <!-- /panel-header -->
                <div class="panel-body">
                    <?php if (!empty($schoolTeacher['SchoolClass'])): ?>
                    <table cellpadding = "0" cellspacing = "0">
                        <tr>
                            		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Code'); ?></th>
		<th><?php echo __('School Teacher Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Deleted'); ?></th>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        </tr>
                        	<?php foreach ($schoolTeacher['SchoolClass'] as $schoolClass): ?>
		<tr>
			<td><?php echo $schoolClass['id']; ?></td>
			<td><?php echo $schoolClass['code']; ?></td>
			<td><?php echo $schoolClass['school_teacher_id']; ?></td>
			<td><?php echo $schoolClass['name']; ?></td>
			<td><?php echo $schoolClass['created']; ?></td>
			<td><?php echo $schoolClass['deleted']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'school_classes', 'action' => 'view', $schoolClass['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'school_classes', 'action' => 'edit', $schoolClass['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'school_classes', 'action' => 'delete', $schoolClass['id']), array(), __('Are you sure you want to delete # %s?', $schoolClass['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
                    </table>
                    <?php endif; ?>

                    <div class="actions">
                        <ul>
                            <li><?php echo $this->Html->link(__('New School Class'), array('controller' => 'school_classes', 'action' => 'add')); ?> </li>
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
                    		<li class="list-group-item"><?php echo $this->Html->link(__('Edit School Teacher'), array('action' => 'edit', $schoolTeacher['SchoolTeacher']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Form->postLink(__('Delete School Teacher'), array('action' => 'delete', $schoolTeacher['SchoolTeacher']['id']), array(), __('Are you sure you want to delete # %s?', $schoolTeacher['SchoolTeacher']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Teachers'), array('action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Teacher'), array('action' => 'add')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Classes'), array('controller' => 'school_classes', 'action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Class'), array('controller' => 'school_classes', 'action' => 'add')); ?> </li>
                </ul>
            </div>
        </div>
    </div>

</div>