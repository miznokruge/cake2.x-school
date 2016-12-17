<div class="row">
    <div class="col-sm-9">
        <div class="panel">
            <div class="panel-heading">
            </div>
            <div class="panel-body">
                <table class="table table-striped table-bordered">
                    <tr>
                        <th><?php echo $this->Paginator->sort('id'); ?></th>
                        <th><?php echo $this->Paginator->sort('title'); ?></th>
                        <th><?php echo $this->Paginator->sort('description'); ?></th>
                        <th><?php echo $this->Paginator->sort('src'); ?></th>
                        <th><?php echo $this->Paginator->sort('isactive'); ?></th>
                        <th><?php echo $this->Paginator->sort('created'); ?></th>
                        <th><?php echo $this->Paginator->sort('modified'); ?></th>
                        <th class="actions"><?php echo __('Actions'); ?></th>
                    </tr>
                    <?php foreach ($comBackgrounds as $comBackground): ?>
                        <tr>
                            <td><?php echo h($comBackground['ComBackground']['id']); ?>&nbsp;</td>
                            <td><?php echo h($comBackground['ComBackground']['title']); ?>&nbsp;</td>
                            <td><?php echo h($comBackground['ComBackground']['description']); ?>&nbsp;</td>
                            <td><?php echo h($comBackground['ComBackground']['src']); ?>&nbsp;</td>
                            <td><?php echo h($comBackground['ComBackground']['isactive']); ?>&nbsp;</td>
                            <td><?php echo h($comBackground['ComBackground']['created']); ?>&nbsp;</td>
                            <td><?php echo h($comBackground['ComBackground']['modified']); ?>&nbsp;</td>
                            <td class="actions">
                                <?php echo $this->Html->link(__('View'), array('action' => 'view', $comBackground['ComBackground']['id'])); ?>
                                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $comBackground['ComBackground']['id'])); ?>
                                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $comBackground['ComBackground']['id']), null, __('Are you sure you want to delete # %s?', $comBackground['ComBackground']['id'])); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </table>
                <p>
                    <?php
                    echo $this->Paginator->counter(array(
                        'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                    ));
                    ?>	</p>
                <div class="paging">
                    <?php
                    echo $this->Paginator->prev('< ' . __('previous'), array(), null, array('class' => 'prev disabled'));
                    echo $this->Paginator->numbers(array('separator' => ''));
                    echo $this->Paginator->next(__('next') . ' >', array(), null, array('class' => 'next disabled'));
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="sidebar-nav">
            <div style="width:300px; padding: 8px 0;">
                <ul class="nav nav-list">
                    <li class="nav-header">Admin Menu</li>
                    <li><a href="index"><i class="icon-home"></i> Dashboard</a></li>
                    <li><a href="#"><i class="icon-envelope"></i> Messages <span class="badge badge-info">4</span></a></li>
                    <li><a href="#"><i class="icon-comment"></i> Comments <span class="badge badge-info">10</span></a></li>
                    <li class="active"><a href="#"><i class="icon-user"></i> Members</a></li>
                    <li class="divider"></li>
                    <li><a href="#"><i class="icon-comment"></i> Settings</a></li>
                    <li><a href="#"><i class="icon-share"></i> Logout</a></li>
                </ul>
            </div>
        </div>
        <?php echo $this->Html->link(__('New Background'), array('action' => 'add'), array('class' => 'btn btn-primary btn-block')); ?>
    </div>
</div>
