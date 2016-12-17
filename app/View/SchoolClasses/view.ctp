<div class="row">
    <div class="schoolClasses view col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-th-list"></i> <?php echo __('School Class'); ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <div class="table-responsive">
                    <table class="table-striped table">
                        <tr>		<td><?php echo __('Id'); ?></td>
		<td>
			<?php echo h($schoolClass['SchoolClass']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Code'); ?></td>
		<td>
			<?php echo h($schoolClass['SchoolClass']['code']); ?>
			&nbsp;
		</td>
</tr><tr>		<td width="200"><?php echo __('School Teacher'); ?></td>
		<td>
			<?php echo $this->Html->link($schoolClass['SchoolTeacher']['name'], array('controller' => 'school_teachers', 'action' => 'view', $schoolClass['SchoolTeacher']['id'])); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Name'); ?></td>
		<td>
			<?php echo h($schoolClass['SchoolClass']['name']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Created'); ?></td>
		<td>
			<?php echo h($schoolClass['SchoolClass']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Deleted'); ?></td>
		<td>
			<?php echo h($schoolClass['SchoolClass']['deleted']); ?>
			&nbsp;
		</td>
</tr>                    </table>
                </div>
            </div>
        </div>

        <!-- disini -->

                    <div class="panel">
                <div class="panel-heading">
                    <h3 class="panel-title"><i class="fa fa-star"></i> <?php echo __('Related School Students'); ?></h3>
                </div> <!-- /panel-header -->
                <div class="panel-body">
                    <?php if (!empty($schoolClass['SchoolStudent'])): ?>
                    <table cellpadding = "0" cellspacing = "0">
                        <tr>
                            		<th><?php echo __('Id'); ?></th>
		<th><?php echo __('Name'); ?></th>
		<th><?php echo __('School Class Id'); ?></th>
		<th><?php echo __('Created'); ?></th>
		<th><?php echo __('Deleted'); ?></th>
                            <th class="actions"><?php echo __('Actions'); ?></th>
                        </tr>
                        	<?php foreach ($schoolClass['SchoolStudent'] as $schoolStudent): ?>
		<tr>
			<td><?php echo $schoolStudent['id']; ?></td>
			<td><?php echo $schoolStudent['name']; ?></td>
			<td><?php echo $schoolStudent['school_class_id']; ?></td>
			<td><?php echo $schoolStudent['created']; ?></td>
			<td><?php echo $schoolStudent['deleted']; ?></td>
			<td class="actions">
				<?php echo $this->Html->link(__('View'), array('controller' => 'school_students', 'action' => 'view', $schoolStudent['id'])); ?>
				<?php echo $this->Html->link(__('Edit'), array('controller' => 'school_students', 'action' => 'edit', $schoolStudent['id'])); ?>
				<?php echo $this->Form->postLink(__('Delete'), array('controller' => 'school_students', 'action' => 'delete', $schoolStudent['id']), array(), __('Are you sure you want to delete # %s?', $schoolStudent['id'])); ?>
			</td>
		</tr>
	<?php endforeach; ?>
                    </table>
                    <?php endif; ?>

                    <div class="actions">
                        <ul>
                            <li><?php echo $this->Html->link(__('New School Student'), array('controller' => 'school_students', 'action' => 'add')); ?> </li>
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
                    		<li class="list-group-item"><?php echo $this->Html->link(__('Edit School Class'), array('action' => 'edit', $schoolClass['SchoolClass']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Form->postLink(__('Delete School Class'), array('action' => 'delete', $schoolClass['SchoolClass']['id']), array(), __('Are you sure you want to delete # %s?', $schoolClass['SchoolClass']['id'])); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Classes'), array('action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Class'), array('action' => 'add')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Teachers'), array('controller' => 'school_teachers', 'action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Teacher'), array('controller' => 'school_teachers', 'action' => 'add')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('List School Students'), array('controller' => 'school_students', 'action' => 'index')); ?> </li>
		<li class="list-group-item"><?php echo $this->Html->link(__('New School Student'), array('controller' => 'school_students', 'action' => 'add')); ?> </li>
                </ul>
            </div>
        </div>
    </div>

</div>