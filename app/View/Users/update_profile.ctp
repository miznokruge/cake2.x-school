<?php echo $this->element('heading',array('title'=>'Update Profile'));?>
<div class="users form">
    <?php echo $this->Form->create('User', array("type" => "file")); ?>
    <fieldset>
        <h3><?php echo __('Edit User'); ?></h3>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('username');
        echo $this->Form->input('name');
        echo $this->Form->input('prev_foto',array("type"=>"hidden",'value'=>$this->request->data['User']['foto']));
        echo $this->Form->input('foto', array("type" => "file","label"=>false));
        echo $this->Form->input('description', array("type" => "textarea"));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>