<?php echo $this->element('ho', array('title' => 'Change Password')); ?>
<?php echo $this->element('hm') ?>
<?php echo $this->element('hc') ?>
<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="users form">
            <?php echo $this->Form->create('User'); ?>
            <fieldset>
                <?php
                if ($id != '') {
                    echo $this->Form->input('id', array('type' => 'hidden', 'value' => $id));
                }
                ?>
                <?php echo $this->Form->input('password', array('type' => 'text', 'label' => array('text' => 'Enter your new password'))); ?>
                <?php echo $this->Form->input('password2', array('type' => 'text', 'label' => array('text' => 'Confirm your new password'))); ?>
            </fieldset>
            <?php echo $this->Form->end(__('Submit')); ?>
        </div>
    </div>
</div>