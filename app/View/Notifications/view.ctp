<div class="row">
    <div class="notifications view col-md-10">
        <div class="widget">
            <div class="widget-header">
                <i class="icon-star"></i>
                <h3><?php echo __('Notification'); ?></h3>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <table class="table-striped table">
                    <tr>		<td><?php echo __('Id'); ?></td>
		<td>
			<?php echo h($notification['Notification']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('User Id'); ?></td>
		<td>
			<?php echo h($notification['Notification']['user_id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Type'); ?></td>
		<td>
			<?php echo h($notification['Notification']['type']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Content'); ?></td>
		<td>
			<?php echo h($notification['Notification']['content']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Url'); ?></td>
		<td>
			<?php echo h($notification['Notification']['url']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Isread'); ?></td>
		<td>
			<?php echo h($notification['Notification']['isread']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Created'); ?></td>
		<td>
			<?php echo h($notification['Notification']['created']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Modified'); ?></td>
		<td>
			<?php echo h($notification['Notification']['modified']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Deleted'); ?></td>
		<td>
			<?php echo h($notification['Notification']['deleted']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Deleted Date'); ?></td>
		<td>
			<?php echo h($notification['Notification']['deleted_date']); ?>
			&nbsp;
		</td>
</tr>                </table>
            </div>
        </div>
        <!-- disini -->
                    </div>
    <div class="col-md-2">
        <div style="margin-bottom:10px;">
            <?php echo $this->Html->link(__('<i class="icon icon-chevron-left"></i> Back to Index'), array('action' => 'index'),array('class'=>'btn btn-block btn-primary','escape'=>false)); ?> </li>
        </div>
        <div class="widget">
            <div class="widget-header">
                <i class="icon-star"></i>
                <h3><?php echo __('Actions'); ?></h3>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <ul class="nav-list">
                    		<li><?php echo $this->Html->link(__('Edit Notification'), array('action' => 'edit', $notification['Notification']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Notification'), array('action' => 'delete', $notification['Notification']['id']), array(), __('Are you sure you want to delete # %s?', $notification['Notification']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Notifications'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Notification'), array('action' => 'add')); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</div>