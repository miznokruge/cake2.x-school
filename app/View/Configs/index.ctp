<div class="configs index row">
    <div class="col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Configs'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $this->Form->create('Config',array('type'=>'get','style'=>'margin:5px auto;','action'=>'index'));?>                <div class="input-group custom-search-form">
                    <input type="text" class="form-control" name="search" placeholder="search" value="<?php echo $search_term;?>">
                    <span class="input-group-btn">
                        <button class="btn btn-default" type="submit">
                            <i class="icon icon-search"></i> Search
                        </button>
                    </span>
                    <span class="input-group-btn" style="margin: auto 5px;">
                        <?php echo $this->Html->link('<i class="icon icon-refresh"></i> View All',array('controller'=>'Configs','action'=>'index'),array('class'=>'btn btn-default','escape'=>false));?>                    </span>
                </div>
                <?php echo $this->Form->end();?>                <table class="table table-striped table-bordered">
                    <tr>
                                                                                        <th><?php echo $this->Paginator->sort('id'); ?></th>
                                                                                                                                <th><?php echo $this->Paginator->sort('nama'); ?></th>
                                                                                                                                <th><?php echo $this->Paginator->sort('keterangan'); ?></th>
                                                                                                                                <th><?php echo $this->Paginator->sort('displayed'); ?></th>
                                                                                                                                                                                        <th><?php echo $this->Paginator->sort('deleted_date'); ?></th>
                                                                                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    <?php foreach ($configs as $config): ?>
	<tr>
		<td><?php echo h($config['Config']['id']); ?>&nbsp;</td>
		<td><?php echo h($config['Config']['nama']); ?>&nbsp;</td>
		<td><?php echo h($config['Config']['keterangan']); ?>&nbsp;</td>
		<td><?php echo h($config['Config']['displayed']); ?>&nbsp;</td>
		<td><?php echo h($config['Config']['deleted_date']); ?>&nbsp;</td>
		<td class="actions">
		<div class="btn-group">
  <button type="button" class="btn btn-default btn-xs dropdown-toggle" data-toggle="dropdown">
    Action <span class="caret"></span>
  </button>
  <ul class="dropdown-menu" role="menu">			<li><?php echo $this->Html->link(__('<i class="fa fa-zoom-in"></i> View'), array('action' => 'view', $config['Config']['id']),array('escape' => false, 'class' => 'ui-popover', 'data-container' => 'body', 'data-toggle' => 'popover', 'data-trigger' => 'hover', 'data-placement' => 'top', 'data-content' => 'Click to view the details of this record.', 'title' => '', 'data-original-title' => 'Information')); ?></li>
			<li><?php echo $this->Html->link(__('<i class="fa fa-edit"></i> Edit'), array('action' => 'edit', $config['Config']['id']),array('escape' => false, 'class' => 'ui-popover', 'data-container' => 'body', 'data-toggle' => 'popover', 'data-trigger' => 'hover', 'data-placement' => 'top', 'data-content' => 'Click to edit this record.', 'title' => '', 'data-original-title' => 'Information')); ?></li>
			<li><?php echo $this->Form->postLink(__('<i class="fa fa-trash"></i> Delete'), array('action' => 'delete', $config['Config']['id']),array('escape' => false, 'class' => 'ui-popover', 'data-container' => 'body', 'data-toggle' => 'popover', 'data-trigger' => 'hover', 'data-placement' => 'top', 'data-content' => 'Click to delete this record.', 'title' => '', 'data-original-title' => 'Information'), __('Are you sure you want to delete # %s?', $config['Config']['id'])); ?></li>
</ul>
</div>		</td>
	</tr>
<?php endforeach; ?>
                </table>
                <div class="row">
                    <div class="col-md-5 col-lg-offset-1">
                        <?php
            echo $this->Paginator->pagination(array(
                "ul" => "pagination"
            ));
            ?>                    </div>
                    <div class="col-md-6" style="margin-top:30px;">
                        <?php
	echo $this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?></div>
                </div>
            </div>

        </div>
    </div>
    <div class="col-md-2">
        <div style="margin-bottom:10px;">
            <?php echo $this->Html->link(__('<i class="icon icon-ok-sign"></i> Add New Record'), array('action' => 'add'),array('class'=>'btn btn-block btn-primary','escape'=>false)); ?> </li>
        </div>
        <div class="widget">
            <div class="widget-header">
                <i class="icon-star"></i>
                <h3><?php echo __('Actions'); ?></h3>
            </div> <!-- /widget-header -->
            <div class="widget-content">
                <ul class="nav nav-list">
                    <li><?php echo $this->Html->link(__('New Config'), array('action' => 'add')); ?></li>
                                    </ul>
            </div>
        </div>
        <div class="panel">
            <div class="panel-heading">
                <i class="icon-th"></i>
                <h3><?php echo __('Informasi'); ?></h3>
            </div> <!-- /widget-header -->
            <div class="panel-body">
                Sed rhoncus metus vel congue volutpat? Vestibulum laoreet orci consectetur lectus congue blandit? Integer condimentum fringilla libero,
            </div>
        </div>
        <div class="panel">
            <div class="ibox-header">
                <i class="icon-th"></i>
                <h3><?php echo __('Informasi'); ?></h3>
            </div> <!-- /widget-header -->
            <div class="panel-body">
                Donec sit amet tellus euismod, ullamcorper libero eu, aliquam ante. Nullam vitae urna tincidunt lacus posuere ultrices ac ac mi.
            </div>
        </div>
    </div>
</div>
