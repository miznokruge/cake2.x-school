<?php
App::import('Vendor', 'Twig', array('file' => 'Twig/Autoloader.php'));
class TwigComponent extends Component{
	protected $_twig;
	
	public function __construct(ComponentCollection $collection, $settings = array()) {
		parent::__construct($collection,$settings);

        Twig_Autoloader::register();
        $loader = new Twig_Loader_String();
        $this->_twig = new Twig_Environment($loader,array(
    		'autoescape' => false
		));	
	}		
	
	public function render($tpl,$data)
	{
		return $this->_twig->render($tpl,$data);
	}
}