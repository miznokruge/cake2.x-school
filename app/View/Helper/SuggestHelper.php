<?php
/**
* SuggestOrders Helper
*/
class SuggestHelper extends Helper{

    public $helpers = array('Array');	

	public function markChange($changes,$field)
	{
		if( !is_array($changes) ) return NULL;
        if( $this->Array->Get($changes,$field) !== NULL ){
            return '['.$changes[$field].']';
        }
	}

	public function statusString($_status)
	{
		switch ((int)$_status) {
			case 0:
				return '<span class="label label-default">Suggested</span>';
				break;
			case 1:
				return '<span class="label label-info">Actual/Reviewed</span>';
				break;
			default:
				return 'Ooops, something went wrong.';
				break;
		}
	}
}