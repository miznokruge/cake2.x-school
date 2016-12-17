<?php

class AccessComponent extends Component {

    public $components = array('Acl', 'UserAuth');
    public $user;
    public $controller;
    public $SATISFACTION_GROUP_ID = 9;

    function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    function startup(Controller $controller) {
        $this->user = $this->UserAuth->getUser();
    }

    function isJustSales() {
        $SALES_GROUP_ID = 3;
        $CS_GROUP_ID = 7;

        return ($this->user['group_id'] == $SALES_GROUP_ID) || ($this->user['group_id'] == $CS_GROUP_ID) || ($this->user['group_id'] == $this->SATISFACTION_GROUP_ID
                ); //3 adalah group ID dari sales
    }

    function isSatisfaction() {
        return $this->user['group_id'] == $this->SATISFACTION_GROUP_ID;
    }

    function isCustomerService() {
        $CS_GROUP_ID = 7;
        return $this->user['group_id'] == $CS_GROUP_ID;
    }

    function isAccounting() {
        $group_id_accounting = 6;
        $group_id_manager = 2;
        $group_id_admin = 1;
        if (($this->user['group_id'] == $group_id_accounting) || ($this->user['group_id'] == $group_id_manager) || ($this->user['group_id'] == $group_id_admin)):
            return true;
        //3 adalah group ID dari sales
        //2 adalah group ID dari manager
        else:
            return false;
        endif;
    }

    function isAnalyst() {
        $ANALYST_GROUP_ID = 4;
        return $this->user['group_id'] == $ANALYST_GROUP_ID;
    }

    function check($aco, $action = 'index') {
        // Set to current controller if aco is empty
        if (empty($aco) || empty($action)) {
            return false;
        } else if ($aco == '/') { // Everyone can see the home page
            return true;
        }

        $acoUrl = 'controllers/' . $aco . '/' . $action;
        if (!empty($this->user) && $this->Acl->check(array('User' => $this->user), $acoUrl)) {
            return true;
        } else {
            return false;
        }
    }

    function checkHelper($aro, $aco, $action = 'index') {
        if (empty($aco) || empty($action)) {
            return false;
        } else if ($aco == '/') { // Everyone can see the home page
            return true;
        }
        App::import('Component', 'Acl');
        $acoUrl = 'controllers/' . $aco . '/' . $action;
        $acl = new AclComponent(new ComponentCollection());
        return $acl->check($aro, $acoUrl);
    }

    /**
     *  get configured Users which should be displayed on big/tickets
     */
    public function getDisplayTicketUsers($display) {
        $db = ClassRegistry::init('User')->getDataSource();
        $display = ((int) $display === 2) ? 'display_ticket2' : 'display_ticket';
        $_sql = 'SELECT id FROM users WHERE users.' . $display . ' = 1 AND (users.group_id = 7 OR users.group_id = 3)';

        $_tmp = $db->query($_sql);
        $_result = array();
        foreach ($_tmp as $mp) {
            $_result[] = $mp['users']['id'];
        }
        unset($_tmp);

        return $_result;
    }

}
