<div class="configs form">
    <?php echo $this->Form->create('Config', array('type' => 'file')); ?>
    <fieldset>
        <legend><?php echo __('Upload Logo'); ?></legend>
        <?php
        $old_logo = $this->request->data['Config']['keterangan'];
        echo $this->Form->input('keterangan', array("type" => "file", "label" => false));
        echo $this->Form->input('old_keterangan', array("type" => "hidden", "label" => false, 'value' => $old_logo));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Configs'), array('action' => 'index')); ?></li>
    </ul>
</div>
