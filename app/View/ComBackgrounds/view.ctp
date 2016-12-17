<div class="comBackgrounds view">
<h2><?php  echo __('Com Background');?></h2>
	<dl>
		<dt><?php echo __('Id'); ?></dt>
		<dd>
			<?php echo h($comBackground['ComBackground']['id']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Title'); ?></dt>
		<dd>
			<?php echo h($comBackground['ComBackground']['title']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Description'); ?></dt>
		<dd>
			<?php echo h($comBackground['ComBackground']['description']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Src'); ?></dt>
		<dd>
			<?php echo h($comBackground['ComBackground']['src']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Isactive'); ?></dt>
		<dd>
			<?php echo h($comBackground['ComBackground']['isactive']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Created'); ?></dt>
		<dd>
			<?php echo h($comBackground['ComBackground']['created']); ?>
			&nbsp;
		</dd>
		<dt><?php echo __('Modified'); ?></dt>
		<dd>
			<?php echo h($comBackground['ComBackground']['modified']); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php echo __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Com Background'), array('action' => 'edit', $comBackground['ComBackground']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Com Background'), array('action' => 'delete', $comBackground['ComBackground']['id']), null, __('Are you sure you want to delete # %s?', $comBackground['ComBackground']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Com Backgrounds'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Com Background'), array('action' => 'add')); ?> </li>
	</ul>
</div>
