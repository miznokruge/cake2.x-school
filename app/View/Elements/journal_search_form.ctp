<?php

echo $this->Form->create("Journal");
echo '<div class="form-row">';
echo '<div class="col-xs-4 form-group">';
echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'placeholder' => 'enter text to search'));
echo '</div>';
echo '<div class="col-xs-4 form-group">';
echo $this->Form->input('search', array('class' => 'form-control', 'label' => false, 'placeholder' => 'enter text to search'));
echo '</div>';
echo '<div class="col-xs-2 form-group">';
echo $this->Form->submit('Search', array('class' => 'form-control btn btn-primary', 'label' => false, 'placeholder' => 'enter text to search'));
echo '</div>';
echo '<div class="col-xs-2 form-group">';
echo $this->Form->button(__('Print'), array('id' => 'button_cetak', 'class' => 'form-control btn btn-primary', 'type' => 'button'));
echo '</div>';
echo '</div>';
echo $this->Form->end();
?>