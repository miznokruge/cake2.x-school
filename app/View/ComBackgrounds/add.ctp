<div class="comBackgrounds form">
    <?php echo $this->Form->create('ComBackground'); ?>
    <fieldset>
        <legend><?php echo __('Add Com Background'); ?></legend>
        <?php
        echo $this->Form->input('title');
        echo $this->Form->input('description');
        echo $this->Form->input('src');
        echo $this->Form->input('isactive', array("type" => "checkbox", "class" => "i-checks"));
        ?>
    </fieldset>
    <?php echo $this->Form->end(__('Submit')); ?>
</div>
<div class="actions">
    <h3><?php echo __('Actions'); ?></h3>
    <ul>
        <li><?php echo $this->Html->link(__('List Com Backgrounds'), array('action' => 'index')); ?></li>
    </ul>
</div>
