<div class="row">
    <div class="configs view col-md-10">
        <div class="widget">
            <div class="widget-header">
                <i class="icon-star"></i>
                <h3><?php echo __('Config'); ?></h3>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <table class="table-striped table">
                    <tr>		<td><?php echo __('Id'); ?></td>
		<td>
			<?php echo h($config['Config']['id']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Nama'); ?></td>
		<td>
			<?php echo h($config['Config']['nama']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Keterangan'); ?></td>
		<td>
			<?php echo h($config['Config']['keterangan']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Displayed'); ?></td>
		<td>
			<?php echo h($config['Config']['displayed']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Deleted'); ?></td>
		<td>
			<?php echo h($config['Config']['deleted']); ?>
			&nbsp;
		</td>
</tr><tr>		<td><?php echo __('Deleted Date'); ?></td>
		<td>
			<?php echo h($config['Config']['deleted_date']); ?>
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
                    		<li><?php echo $this->Html->link(__('Edit Config'), array('action' => 'edit', $config['Config']['id'])); ?> </li>
		<li><?php echo $this->Form->postLink(__('Delete Config'), array('action' => 'delete', $config['Config']['id']), array(), __('Are you sure you want to delete # %s?', $config['Config']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Configs'), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Config'), array('action' => 'add')); ?> </li>
                </ul>
            </div>
        </div>
    </div>

</div>