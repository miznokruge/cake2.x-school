<?php
App::import('Vendor','parseCSV');
class CsvComponent extends Component {
		
	public $controller;
    
    function initialize(Controller $controller) 
    {
        $this->controller = $controller;		
    }	
	
	public function parseCSV($filename)
	{
		if( !file_exists($filename) && !is_readable($filename) ){
			throw new ErrorException('Please make sure the file '.$filename.' is exists and readable.');	
		}
		
		$_csv = new parseCSV();
		$_csv->parse($filename);
		
		return $_csv->data;
	}
}