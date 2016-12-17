<?php

class AclManagementAppController extends AppController {

    public function beforeFilter() {
        $this->Auth->allow('*');
    }

}

?>