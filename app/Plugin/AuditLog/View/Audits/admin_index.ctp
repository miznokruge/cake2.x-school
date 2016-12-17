<?php $this->extend('/Layouts/Partials/admin_index'); ?>

<?php $this->start('title'); ?>
	<h2><i class="icon-align-justify"></i><span class="break"></span>Audits</h2>
<?php $this->end(); ?>

<?php $this->start('main'); ?>
	<table class="table table-striped bootstrap-datatable datatable">
		<thead>
		<tr>
			<th><?= $this->Paginator->sort('event');?></th>
			<th><?= $this->Paginator->sort('source_id', 'By');?></th>
			<th><?= $this->Paginator->sort('model', 'Resource');?></th>
			<th><?= $this->Paginator->sort('entity_id', 'Identifier');?></th>
			<th><?= $this->Paginator->sort('delta_count', 'Changes');?></th>
			<th><?= $this->Paginator->sort('created');?></th>
			<th class="actions"><?= __('Actions');?></th>
		</tr>
		</thead>
		<tbody>
	<?php foreach ($items as $item): ?>
		<tr>
			<td><?= $this->AuditLog->getEvent($item); ?></td>
			<td><?= $this->Html->link($this->AuditLog->getSource($item), ['action' => 'index', '?' => ['source_id' => $item['Audit']['source_id']]]); ?>&nbsp;</td>
			<td><?= $this->Html->link($item['Audit']['model'], ['action' => 'index', '?' => ['model' => $item['Audit']['model']]]); ?></td>
			<td><?= $this->Html->link($this->AuditLog->getIdentifier($item), ['action' => 'index', '?' => ['model' => $item['Audit']['model'], 'entity_id' => $item['Audit']['entity_id']]]); ?></td>
			<td><?= h($item['Audit']['delta_count']); ?>&nbsp;</td>
			<td><span title="<?= h($item['Audit']['created']); ?>"><?= str_replace('on', '', $this->Time->timeAgoInWords($item['Audit']['created'])); ?></span></td>
			<td class="actions">
				<?= $this->Html->link('<i class="halflings-icon edit"></i>', ['plugin' => null, 'controller' => Inflector::underscore(Inflector::pluralize($item['Audit']['model'])), 'action' => 'edit', $item['Audit']['entity_id']], ['class' => 'btn btn-success', 'escape' => false]); ?>
				<?= $this->Html->link('<i class="halflings-icon dashboard"></i>', ['controller' => 'audit_deltas', 'action' => 'index', '?' => ['model' => $item['Audit']['model'], 'entity_id' => $item['Audit']['entity_id']]], ['class' => 'btn btn-info', 'escape' => false]); ?>
				<?= $this->Html->link('<i class="halflings-icon eye-open"></i>', ['action' => 'view', $item['Audit']['id']], ['class' => 'btn btn-default', 'escape' => false]); ?>
			</td>
		</tr>
	<?php endforeach; ?>
		</tbody>
	</table>
	<div class="row-fluid">
		<div class="span12">
			<?= $this->Paginator->counter(array('format' => __('Page {:page} of {:pages}, showing {:start} to {:end} out of {:count}')));?>
		</div>
	</div>
	<?php echo $this->Paginator->pagination(); ?>
<?php $this->end(); ?>
