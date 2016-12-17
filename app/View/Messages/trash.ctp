
<div class="row">
    <div class="col-lg-3">
        <?php echo $this->element('message_menu') ?>
    </div>
    <div class="col-lg-9 animated fadeInRight">
        <div class="mail-box-header">
            <form method="get" action="http://webapplayers.com/inspinia_admin-v1.5/index.html" class="pull-right mail-search">
                <div class="input-group">
                    <input class="form-control input-sm" name="search" placeholder="Search email" type="text">
                    <div class="input-group-btn">
                        <button type="submit" class="btn btn-sm btn-primary">
                            Search
                        </button>
                    </div>
                </div>
            </form>
            <h2>
                Trash
            </h2>
            <div class = "mail-tools tooltip-demo m-t-md">
                <div class = "btn-group pull-right">
                    <?php echo $this->Paginator->prev('<i class = "fa fa-arrow-left"></i>', array('class' => 'btn btn-white btn-sm', 'escape' => false), null, array('class' => 'btn btn-white btn-sm prev disabled', 'escape' => false)); ?>
                    <?php
                    echo $this->Paginator->next('<i class = "fa fa-arrow-right"></i>', array('class' => 'btn btn-white btn-sm', 'escape' => false), null, array('class' => 'btn btn-white btn-sm next disabled', 'escape' => false));
                    ?>
                </div>
                <a href="<?php echo $this->here ?>" data-original-title = "Refresh inbox" class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "left" title = ""><i class = "fa fa-refresh"></i> Refresh</a>
                <button id="btn_mark_as_read" data-original-title = "Mark as read" class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "top" title = ""><i class = "fa fa-eye"></i> </button>
                <button data-original-title = "Mark as important" class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "top" title = ""><i class = "fa fa-exclamation"></i> </button>
                <button id="btn_move_to_trash" class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "top" title = "Move to trash"><i class = "fa fa-trash-o"></i> </button>
            </div>
        </div>
        <div class = "mail-box">
            <?php echo $this->Form->create('Message') ?>
            <?php if (count($messages) > 0) { ?>
                <table class = "table table-hover table-mail table-striped">
                    <tbody>
                        <?php foreach ($messages as $message):
                            ?>
                            <tr id="row_<?php echo $message['Message']['id'] ?>" <?php if ($message['Message']['is_read'] == 0) { ?>class="unread"<?php } else { ?>class="read"<?php } ?>>
                                <td class="check-mail">
                                    <input type="checkbox" name="msgs[]" value="<?php echo $message['Message']['id'] ?>" class="i-checks"/>
                                </td>
                                <td class="mail-ontact">
                                    <?php echo $this->Html->link($message['User']['username'], array('controller' => 'users', 'action' => 'view', $message['User']['id'])); ?>
                                    <span class="label label-danger pull-right">Documents</span>
                                </td>
                                <td class="mail-subject">
                                    <?php echo $this->Html->link($message['Message']['subject'], array('controller' => 'messages', 'action' => 'view', $message['Message']['id'])); ?>
                                </td>
                                <td class=""><!-- <i class="fa fa-paperclip"></i>--></td>
                                <td class="text-right mail-date"><?php echo date('G:i A , d F Y', strtotime($message['Message']['created'])); ?></td>
            <!--                            <td class="actions">
                                <?php echo $this->Html->link(__('View'), array('action' => 'view', $message['Message']['id'])); ?>
                                <?php echo $this->Html->link(__('Edit'), array('action' => 'edit', $message['Message']['id'])); ?>
                                <?php echo $this->Form->postLink(__('Delete'), array('action' => 'delete', $message['Message']['id']), null, __('Are you sure you want to delete # %s?', $message['Message']['id'])); ?>
                                </td>-->
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <br>
                <div style="width:90%; text-align: center; margin: 5px auto;">
                    <div class="alert alert-danger">
                        <?php echo __('No messages ') ?>
                    </div>
                </div>
            <?php } ?>
            <?php echo $this->Form->end() ?>
            <p style="text-align: center">
                <?php
                echo $this->Paginator->counter(array(
                    'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
                ));
                ?>
            </p>
        </div>
    </div>
</div>
<script src="/js/plugins/iCheck/icheck.min.js"></script>
<script>
    $(document).ready(function () {
        $('.i-checks').iCheck({
            checkboxClass: 'icheckbox_square-green',
            radioClass: 'iradio_square-green',
        });
        $("#btn_mark_as_read").click(function () {
            var v = $("#MessageIndexForm").serialize();
            $.post('/messages/mark_as_read', v, function (resp) {
                var json = $.parseJSON(resp);
                if (json.length > 0) {
                    for (var i = 0; i < json.length; i++) {
                        $('#row_' + json[i]).removeClass('unread').addClass('read');
                    }
                }
            });
        });
        $("#btn_move_to_trash").click(function () {
            var v = $("#MessageIndexForm").serialize();
            $.post('/messages/move_to_trash', v, function (resp) {
                var json = $.parseJSON(resp);
                if (json.length > 0) {
                    for (var i = 0; i < json.length; i++) {
                        $('#row_' + json[i]).remove();
                    }
                }
            });
        });
    });
</script>