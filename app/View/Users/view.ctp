<div class="row">
    <div class="col-sm-8">
        <div class="panel">
            <div class="panel-bg-cover">
                <img class="img-responsive" src="/img/thumbs/img1.jpg" alt="Image">
            </div>
            <div class="panel-media">
                <img src="/img/foto_profile/<?php echo str_replace('.', '_100.', $this->Info->userdata($user['User']['id'], 'foto')); ?>"
                     class="panel-media-img img-circle img-border-light" alt="<?php echo $this->Info->userdata($user['User']['id'], 'foto'); ?>"
                     title="<?php echo h($user['User']['username']); ?>">
                <div class="row">
                    <div class="col-lg-7">
                        <h3 class="panel-media-heading"><?php echo $user['User']['username']; ?></h3>
                        <a href="mailto:<?php echo $user['User']['email']; ?>" class="btn-link"><?php echo $user['User']['email']; ?></a>
                        <p class="text-muted mar-btm"><?php echo $user['UserGroup']['name']; ?></p>
                    </div>
                    <div class="col-lg-5 text-lg-right">
                        <!--                        <button class="btn btn-sm btn-primary">Add Friend</button>-->
                        <a href="mailto:<?php echo $user['User']['email']; ?>" class="btn btn-sm btn-mint btn-icon fa fa-envelope icon-lg"></a>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
            <hr/>
            <div class="panel-body">
                <div class="related">
                    <h3><?php echo __('Related Notes'); ?></h3>
                    <?php if (!empty($user['NoteUser'])): ?>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th><?php echo __('Id'); ?></th>
                                <th><?php echo __('Order Id'); ?></th>
                                <th><?php echo __('User Id'); ?></th>
                                <th><?php echo __('Content'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th><?php echo __('Modified'); ?></th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($user['NoteUser'] as $noteUser):
                                ?>
                                <tr>
                                    <td><?php echo $noteUser['id']; ?></td>
                                    <td><?php echo $noteUser['order_id']; ?></td>
                                    <td><?php echo $noteUser['user_id']; ?></td>
                                    <td><?php echo $noteUser['content']; ?></td>
                                    <td><?php echo $noteUser['created']; ?></td>
                                    <td><?php echo $noteUser['modified']; ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('View'), array('controller' => 'notes', 'action' => 'view', $noteUser['id'])); ?>
                                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'notes', 'action' => 'edit', $noteUser['id'])); ?>
                                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'notes', 'action' => 'delete', $noteUser['id']), null, __('Are you sure you want to delete # %s?', $noteUser['id'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                    <div class="actions">
                        <ul>
                            <li class="list-group-item"><?php echo $this->Html->link(__('New Note User'), array('controller' => 'notes', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                </div>
                <div class="related">
                    <h3><?php echo __('Related Orders'); ?></h3>
                    <?php if (!empty($user['OrderUser'])): ?>
                        <table class="table table-striped table-bordered">
                            <tr>
                                <th><?php echo __('Id'); ?></th>
                                <th><?php echo __('User Id'); ?></th>
                                <th><?php echo __('Customer Id'); ?></th>
                                <th><?php echo __('Description'); ?></th>
                                <th><?php echo __('Sell Price'); ?></th>
                                <th><?php echo __('Ori Price'); ?></th>
                                <th><?php echo __('Created'); ?></th>
                                <th><?php echo __('Modified'); ?></th>
                                <th><?php echo __('Customer State Id'); ?></th>
                                <th><?php echo __('Supplier State Id'); ?></th>
                                <th class="actions"><?php echo __('Actions'); ?></th>
                            </tr>
                            <?php
                            $i = 0;
                            foreach ($user['OrderUser'] as $userUser):
                                ?>
                                <tr>
                                    <td><?php echo $userUser['id']; ?></td>
                                    <td><?php echo $userUser['user_id']; ?></td>
                                    <td><?php echo $userUser['customer_id']; ?></td>
                                    <td><?php echo $userUser['description']; ?></td>
                                    <td><?php echo $userUser['sell_price']; ?></td>
                                    <td><?php echo $userUser['ori_price']; ?></td>
                                    <td><?php echo $userUser['created']; ?></td>
                                    <td><?php echo $userUser['modified']; ?></td>
                                    <td><?php echo $userUser['customer_state_id']; ?></td>
                                    <td><?php echo $userUser['supplier_state_id']; ?></td>
                                    <td class="actions">
                                        <?php echo $this->Html->link(__('View'), array('controller' => 'orders', 'action' => 'view', $userUser['id'])); ?>
                                        <?php echo $this->Html->link(__('Edit'), array('controller' => 'orders', 'action' => 'edit', $userUser['id'])); ?>
                                        <?php echo $this->Form->postLink(__('Delete'), array('controller' => 'orders', 'action' => 'delete', $userUser['id']), null, __('Are you sure you want to delete # %s?', $userUser['id'])); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                    <div class="actions">
                        <ul>
                            <li class="list-group-item"><?php echo $this->Html->link(__('New Order User'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo __('Actions'); ?></h3>
            </div>
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item"><?php echo $this->Html->link(__('Edit User'), array('action' => 'edit', $user['User']['id'])); ?> </li>
                    <li class="list-group-item"><?php echo $this->Form->postLink(__('Delete User'), array('action' => 'delete', $user['User']['id']), null, __('Are you sure you want to delete # %s?', $user['User']['id'])); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('List Users'), array('action' => 'index')); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('New User'), array('action' => 'add')); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('List Groups'), array('controller' => 'groups', 'action' => 'index')); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('New Group'), array('controller' => 'groups', 'action' => 'add')); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('List Notes'), array('controller' => 'notes', 'action' => 'index')); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('New Note User'), array('controller' => 'notes', 'action' => 'add')); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('List Orders'), array('controller' => 'orders', 'action' => 'index')); ?> </li>
                    <li class="list-group-item"><?php echo $this->Html->link(__('New Order User'), array('controller' => 'orders', 'action' => 'add')); ?> </li>
                </ul>
            </div>
        </div>
    </div>
</div>
