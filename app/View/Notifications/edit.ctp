<div class="row">
    <div class="col-md-10">
        <div class="notifications form">
            <?php
echo $this->Form->create('Notification', array(
    'inputDefaults' => array(
        'div' => 'form-group',
        'wrapInput' => false,
        'class' => 'form-control'
    ),
    'class' => ''
));
?>
            <fieldset>
                <legend><?php echo __('Edit Notification'); ?></legend>
                	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('type');
		echo $this->Form->input('content');
		echo $this->Form->input('url');
		echo $this->Form->input('isread');
		echo $this->Form->input('deleted_date');
	?>
            </fieldset>
            <button type="submit" class="btn btn-primary btn-lg">Submit</button>
            <?php echo $this->Form->end(); ?>
        </div>
    </div>
    <div class="col-md-2">
        <div style="margin-bottom:10px;">
            <?php echo $this->Html->link(__('<i class="icon icon-chevron-left"></i> Back to Index'), array('action' => 'index'),array('class'=>'btn btn-block btn-primary','escape'=>false)); ?> </li>
        </div>
        <div class="widget">
            <div class="widget-header">
                <i class="icon-th-list"></i>
                <h3><?php echo __('Actions'); ?></h3>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <ul class="nav nav-list nav-stacked">
                                            <li><?php echo $this->Form->postLink(__('<i class="icon icon-trash"></i> Delete'), array('action' => 'delete', $this->Form->value('Notification.id')),array('escape'=>false), __('Are you sure you want to delete # %s?', $this->Form->value('Notification.id'))); ?></li>
                                        <li><?php echo $this->Html->link(__('<i class="icon icon-th-list"></i> List Notifications'), array('action' => 'index'),array('escape'=>false)); ?></li>
                                    </ul>
            </div>
        </div>
    </div>
</div>
