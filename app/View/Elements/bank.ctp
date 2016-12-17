<?php
	(isset($bank_type)) ? $bank_type = $bank_type : $bank_type = NULL; 
	echo $this->Form->banks($banks,NULL,$bank_type);
?>
