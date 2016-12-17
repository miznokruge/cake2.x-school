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
        <h3>User List</h3>
    </div>
    <div class="panel-body">
        <table class="table table-striped table-bordered">
            <tr>
                <th><?php echo $this->Paginator->sort('id'); ?></th>
                <th><?php echo $this->Paginator->sort('username'); ?></th>
                <th><?php echo $this->Paginator->sort('email'); ?></th>
                <th><?php echo $this->Paginator->sort('group_id'); ?></th>
                <th><?php echo $this->Paginator->sort('created'); ?></th>
                <th>Display-1</th>
                <th>Display-2</th>
                <th>ip address</th>
                <th class="actions text-right"><?php echo __('Actions'); ?></th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td>
                        <?php
                        if ($this->Info->userdata($user['User']['id'], 'foto') == '') {
                            echo $this->Html->image('no-image.jpg', array('class' => 'img-circle'));
                        } else {
                            ?>
                            <img src="/img/foto_profile/<?php echo str_replace('.', '_60.', $this->Info->userdata($user['User']['id'], 'foto')); ?>" class="img-circle" alt="<?php echo $this->Info->userdata($user['User']['id'], 'foto'); ?>"></td>
                    <?php } ?>
                    <td>
                        <?php echo h($user['User']['username']); ?>&nbsp;</td>
                    <td><?php echo h($user['User']['email']); ?>&nbsp;</td>
                    <td>
                        <?php echo $this->Html->link($user['UserGroup']['name'], array('controller' => 'groups', 'action' => 'view', $user['UserGroup']['id'])); ?>
                    </td>
                    <td><?php echo h($user['User']['created']); ?>&nbsp;</td>
                    <td style="text-align:center;">
                        <?php if ($user['User']['group_id'] == 3): ?>
                            <?php $is_displayed = ((int) $user['User']['display_ticket'] === 1) ? 'checked="checked"' : ''; ?>
                            <input <?php echo $is_displayed; ?> data-key="<?php echo $user['User']['id']; ?>" type="radio" class="display-ticket" style="line-height:10;" name="display-<?php echo $user['User']['id']; ?>">
                        <?php endif; ?>
                    </td>
                    <td style="text-align:center;">
                        <?php if ($user['User']['group_id'] == 3): ?>
                            <?php $is_displayed2 = ((int) $user['User']['display_ticket2'] === 1) ? 'checked="checked"' : ''; ?>
                            <input <?php echo $is_displayed2; ?> data-key="<?php echo $user['User']['id']; ?>" type="radio" class="display-ticket2" style="line-height:10;" name="display-<?php echo $user['User']['id']; ?>">
                        <?php endif; ?>
                    </td>
                    <td><?php echo $user['User']['ip_address']; ?>&nbsp;</td>
                    <td class="text-right">
                        <?php echo $this->Html->link(__('<i class="fa fa-key"></i>'), array('action' => 'change_password', $user['User']['id']), array('class' => 'btn btn-default btn-xs', 'escape' => false, 'title' => 'Reset Password')); ?>
                        <?php echo $this->Html->link(__('View'), array('action' => 'view', $user['User']['id']), array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $user['User']['id']), array('class' => 'btn btn-default btn-xs')); ?>
                        <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $user['User']['id']), array('class' => 'btn btn-default btn-xs'), __('Are you sure you want to delete # %s?', $user['User']['id'])); ?>
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
<script type="text/javascript">
    $('.display-ticket').click(function () {
        var self = $(this);
        var url = "<?php echo $this->webroot . 'users/display_ticket/'; ?>" + self.attr('data-key');
        $('#preloader').show();
        console.log(self.is(':checked'));
        $.post(url, {checked: (self.is(':checked')) ? 1 : 0, display: 1}, function (response) {
            if (response.Result !== "OK")
            {
                alert(response.Message);
            }
        }, 'json')
                .always(function () {
                    $('#preloader').hide();
                });
    });
    $('.display-ticket2').click(function () {
        var self = $(this);
        var url = "<?php echo $this->webroot . 'users/display_ticket/'; ?>" + self.attr('data-key');
        $('#preloader').show();
        console.log(self.is(':checked'));
        $.post(url, {checked: (self.is(':checked')) ? 1 : 0, display: 2}, function (response) {
            if (response.Result !== "OK")
            {
                alert(response.Message);
            }
        }, 'json')
                .always(function () {
                    $('#preloader').hide();
                });
    });
</script>