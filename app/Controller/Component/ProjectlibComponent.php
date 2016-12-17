<?php
class ProjectlibComponent extends Component {
	
    function initialize(Controller $controller) {
        $this->controller = $controller;
    }
	
	//grouping projects by month
	public function groupProjectByMonth($projects)
	{
		$results = array();
		foreach( $projects as $project )
		{
			$results[ date('F - Y',strtotime($project['Project']['created'])) ][] = $project;
		}
		return $results;
	}
	
	public function calculateTotalIncentive(array $source){
		if( !isset($source['Incentive']) ){
			throw new ErrorException('Invalid argument, must be valid Project/Incentive Results');
		}
		
		$tmp = 0;
		foreach( $source['Incentive'] as $inc )
		{
			$tmp += floatval($inc['amount']);
		}
		
		return $tmp;
	}
	
	/*
	 * return array(
	 * 	'percent'  => 50%,,
	 *  'total'    => 2434344
	 * )
	 */
	public function calculateAcievement(array $source)
	{
		if( !isset($source['ProjectParameter']) ){
			throw new ErrorException('Invalid argument, must be valid Project/ProjectParameter Results');
		}
		
		$result = array(
			'percent'	=> 0,
			'total'		=> 0
		);
		
		foreach( $source['ProjectParameter'] as $prj )
		{
			$result['percent'] += $prj['percent'] * $prj['value'];
		}
		
		$result['total'] = ( floatval($source['Project']['budget']) * $result['percent'] ) / 100;
		
		return $result;
	}
}