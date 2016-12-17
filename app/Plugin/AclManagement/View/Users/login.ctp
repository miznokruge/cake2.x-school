<?php
echo $this->Form->create('User', array('action' => 'login'));
?>
<fieldset>
    <legend><?php echo __('Login'); ?></legend>
    <?php
    echo $this->Form->input('email', array('div'=>'clearfix',
        'before'=>'<label>'.__('Email').'</label><div class="input">',
        'after'=>$this->Form->error('email', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
        'error' => array('attributes' => array('style' => 'display:none')),
        'label'=>false, 'class'=>'xlarge'));
    echo $this->Form->input('password', array('div'=>'clearfix',
        'before'=>'<label>'.__('Password').'</label><div class="input">',
        'after'=>$this->Form->error('password', array(), array('wrap' => 'span', 'class' => 'help-inline')).'</div>',
        'error' => array('attributes' => array('style' => 'display:none')),
        'label'=>false, 'class'=>'xlarge'));
    ?>
    <div class="actions">
        <?php echo $this->Form->submit(__('Submit'), array('class'=>'btn primary', 'div'=>false));?>
        <?php echo $this->Form->reset(__('Cancel'), array('class'=>'btn', 'div'=>false));?>
    </div>

</fieldset>
<?php
echo $this->Form->end();
?>
