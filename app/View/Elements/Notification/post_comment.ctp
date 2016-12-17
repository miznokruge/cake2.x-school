<a href="<?php echo $this->Html->url(array('controller'=>'post','action'=>'view',$data['Post']['id'])) ?>">
    <?php echo __("%s comment your post %s", '<strong>'.$data['User']['username'].'</strong>', '<strong>'.$data['Post']['title'].'</strong>'); ?><br/>
    <small><?php echo $this->Time->niceShort($data['Notification']['created']); ?></small>
</a>