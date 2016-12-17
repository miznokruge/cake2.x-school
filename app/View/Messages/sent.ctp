
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
                Sent (<?php echo count($messages) ?>)
            </h2>
            <div class = "mail-tools tooltip-demo m-t-md">
                <div class = "btn-group pull-right">
                    <button class = "btn btn-white btn-sm"><i class = "fa fa-arrow-left"></i></button>
                    <button class = "btn btn-white btn-sm"><i class = "fa fa-arrow-right"></i></button>
                </div>
                <button data-original-title = "Refresh inbox" class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "left" title = ""><i class = "fa fa-refresh"></i> Refresh</button>
                <button data-original-title = "Mark as read" class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "top" title = ""><i class = "fa fa-eye"></i> </button>
                <button data-original-title = "Mark as important" class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "top" title = ""><i class = "fa fa-exclamation"></i> </button>
                <button class = "btn btn-white btn-sm" data-toggle = "tooltip" data-placement = "top" title = "Move to trash"><i class = "fa fa-trash-o"></i> </button>
            </div>
        </div>
        <div class = "mail-box">
            <table class = "table table-hover table-mail">
                <tbody>
                    <?php foreach ($messages as $message):
                        ?>
                        <tr <?php if ($message['Message']['is_read'] == 0) { ?>class="unread"<?php } else { ?>class="read"<?php } ?>>
                            <td class="check-mail">
                                <div style="position: relative;" class="icheckbox_square-green"><input style="position: absolute; opacity: 0;" class="i-checks" type="checkbox"><ins style="position: absolute; top: 0%; left: 0%; display: block; width: 100%; height: 100%; margin: 0px; padding: 0px; background: none repeat scroll 0% 0% rgb(255, 255, 255); border: 0px none; opacity: 0;" class="iCheck-helper"></ins>
                                </div>
                            </td>
                            <td class="mail-ontact">
                                <?php echo $this->Html->link($message['Sendto']['username'], array('controller' => 'users', 'action' => 'view', $message['User']['id'])); ?>
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
    });
</script>