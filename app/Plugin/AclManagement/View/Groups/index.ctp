<div class="groups index">	
	<table cellpadding="0" cellspacing="0" class="zebra-striped">
	<tr>
                <th class="header"><?php echo $this->Paginator->sort('id');?></th>
                <th class="header"><?php echo $this->Paginator->sort('name');?></th>
                <th class="header"><?php echo $this->Paginator->sort('created');?></th>
                <th class="header"><?php echo $this->Paginator->sort('modified');?></th>
                <th class="header"><?php echo __('Actions');?></th>
	</tr>
	<?php
	foreach ($groups as $group):
        ?>
	<tr>
		<td><?php echo h($group['Group']['id']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['name']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['created']); ?>&nbsp;</td>
		<td><?php echo h($group['Group']['modified']); ?>&nbsp;</td>
		<td class="">
                    <span class="label white warning"><?php echo $this->Html->linkSkipAcl(__('Edit'), array('action' => 'edit', $group['Group']['id'])); ?></span>
                    <span class="label white important"><?php echo $this->Form->postLinkSkipACL(__('Delete'), array('action' => 'delete', $group['Group']['id']), null, __('Are you sure you want to delete # %s?', $group['Group']['id'])); ?></span>
		</td>
	</tr>
        <?php endforeach; ?>
	</table>
	<?php echo $this->element('pagination');?>
</div>