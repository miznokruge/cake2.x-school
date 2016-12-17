<?php echo $this->element('ho', array('title' => 'Users')); ?>
<?php echo $this->Html->link(__('New User'), array('action' => 'add'), array('class' => 'btn btn-xs btn-primary')); ?>
<?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index'), array('class' => 'btn btn-xs btn-primary')); ?>
<?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add'), array('class' => 'btn btn-xs btn-primary')); ?>
<?php echo $this->Html->link(__('List Notes'), array('controller' => 'notes', 'action' => 'index'), array('class' => 'btn btn-xs btn-primary')); ?>
<?php echo $this->Html->link(__('New Note User'), array('controller' => 'notes', 'action' => 'add'), array('class' => 'btn btn-xs btn-primary')); ?>
<?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index'), array('class' => 'btn btn-xs btn-primary')); ?>
<?php echo $this->Html->link(__('New Order User'), array('controller' => 'orders', 'action' => 'add'), array('class' => 'btn btn-xs btn-primary')); ?>
<?php echo $this->element('hc'); ?>
<div class="panel">
    <div class="panel-heading">
        <h2>Edit user data</h2>
    </div>
    <div class="panel-body">
        <div class="users form">
            <?php echo $this->Form->create('User'); ?>
            <fieldset>
                <legend><?php echo __('Edit User'); ?></legend>
                <?php
                echo $this->Form->input('id');
                echo $this->Form->input('username');
                echo $this->Form->input('email');
                echo $this->Form->input('board_id', array('type' => 'text'));
                echo $this->Form->input('ip_address');
                echo $this->Form->input('ipv6_address');
                echo $this->Form->input('phone_address');
                echo $this->Form->input('group_id');
                ?>
            </fieldset>
            <?php echo $this->Form->end(__('Submit')); ?>
        </div>
    </div>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $this->Form->value('User.id')), null, __('Are you sure you want to delete # %s?', $this->Form->value('User.id'))); ?></li>
        <li><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?></li>
        <li><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Notes'), array('controller' => 'notes', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Note User'), array('controller' => 'notes', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
        <li><?php echo $this->Html->link(__('New Order User'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
        <li><?php echo $this->Html->link(__('Change Password'), array('action' => 'editpassword', $this->Form->value('User.id'))); ?></li>
    </ul>
</div>
