<?php
App::uses('OAuthConsumerComponent', 'OAuth.Controller/Component');

class ServiceComponent extends OAuthConsumerComponent {
    /**
     * Initialize callback
     * 
     * @param Controller $controller
     * @return void
     */
    public function initialize(Controller $controller) {
        $this->setParams(array(
            'key' => 'KLUC', 
            'secret' => 'SECRET', 
            'requestTokenUri' => 'URL', 
            'authorizeUri' => 'URL', 
            'accessTokenUri' => 'URL'
        ));
    }

    
}