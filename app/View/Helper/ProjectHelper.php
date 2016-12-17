<?php
class ProjectHelper extends Helper {
	
	CONST NEXT_PERIODE = 5;
	CONST FILTER_PERIODE = 12;
	
	var $helpers = array(
		'Array'
	);
    var $_project;
	
    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        // Do other initialization here
        App::import('Component', 'Project');
        $this->_project = new ProjectlibComponent(new ComponentCollection());	
	} 
	
	public function calculateTotalIncentive(array $source){
		return $this->_project->calculateTotalIncentive($source);
	}
	
	public function calculateAcievement(array $source)
	{
		return $this->_project->calculateAcievement($source);
	}
	
	//generate select element of periode, for input
	public function SelectPeriode($attributes = array() , $filter = FALSE )
	{		
		$tmp = '<select name="'.$this->Array->get($attributes,'name','Incentive.periode').'">';
		$INC = ( $filter === FALSE ) ? self::NEXT_PERIODE : self::FILTER_PERIODE;
		
		for( $iloop = 0;$iloop < (int)$INC; $iloop++ )
		{
			$selected = '';
			
			$current = ( $filter === FALSE ) ? date('F - Y',strtotime("+{$iloop} month")) : date('F - Y',strtotime("-{$iloop} month"));		
			
			if( $this->Array->get($attributes,'value') === $current )
				$selected = 'selected="selected"';
			
			$tmp .= '<option '.$selected.' value="'.$current.'">'.$current.'</option>';
		}
				
		$tmp .= '</select>';
		
		return $tmp;
	}	 
}