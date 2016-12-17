<ul class="dropdown-menu dropdown-messages" style="height:200px; overflow:auto;">
    <?php if (count($message_inbox) > 0) { ?>
        <?php foreach ($message_inbox as $msi) { ?>
            <li>
                <div class="dropdown-messages-box">
                    <a href="profile.html" class="pull-left">
                        <img alt="image" title="<?php echo $this->Info->userdata($msi['User']['id'], 'username') ?>" class="img-circle" src="/img/foto_profile/<?php echo str_replace('.', '_128.', $this->Info->userdata($msi['User']['id'], 'foto')); ?>">
                    </a>
                    <div class="media-body">
                        <a href="/messages/view/<?php echo $msi['Message']['id'] ?>" style="text-align: left;">
                            <?php echo $msi['Message']['subject'] ?>
                        </a>
                        <br>
                        <small><?php echo $this->Time->timeAgoInWords($msi['Message']['created']) ?></small>
                    </div>
                </div>
            </li>
            <li class = "divider"></li>
        <?php }
        ?>
        <li>
            <div class="text-center link-block">
                <a href="/messages/">
                    <i class="fa fa-envelope"></i> <strong><?php echo __('Read All Messages') ?></strong>
                </a>
            </div>
        </li>
    <?php } else {
        ?>
        <li>
            <div class="dropdown-messages-box">
                <div class="media-body">
                    <?php echo __('No new message') ?>
                </div>
            </div>
        </li>
    <?php } ?>
</ul>