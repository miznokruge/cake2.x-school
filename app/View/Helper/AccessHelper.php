<?php

class AccessHelper extends Helper {

    var $helpers = array("Session");
    var $Access;
    var $Auth;
    var $user;
    public $SATISFACTION_GROUP_ID = 9;

    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        // Do other initialization here
        App::import('Component', 'Access');
        $this->Access = new AccessComponent(new ComponentCollection());

        App::import('Component', 'Auth');
        $this->Auth = new UserAuthComponent(new ComponentCollection());
        $this->Auth->Session = $this->Session;

        $this->user = $this->Auth->user();
    }

    function check($aco, $action = 'index') {
        if (empty($this->user))
            return false;
        return $this->Access->checkHelper(array('User' => $this->user), $aco, $action);
    }

    function getUsername() {
        if ($this->isLoggedin()) {
            $username = $this->user['username'];
        } else {
            $username = '';
        }
        return $username;
    }

    function isLoggedin() {
        return !empty($this->user);
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

    function isAdmin() {
        $ADMIN_GROUP_ID = 1;
        return $this->user['group_id'] == $ADMIN_GROUP_ID;
    }

    function isAnalyst() {
        $ANALYST_GROUP_ID = 4;
        return $this->user['group_id'] == $ANALYST_GROUP_ID;
    }

    function hasOrderEditPermission($state_id) {
        $group_id = $this->user['user_group_id'];
        // Read from DB groups_states
        $tmp = ClassRegistry::init('State');
        $state = &$tmp;
        $db = $state->getDataSource();
        $result = $db->fetchAll(
                'SELECT id from groups_states where state_id = ? AND group_id = ?', array($state_id, $group_id)
        );
        $found = count($result);
        // If we found a match, return true
        if ($found)
            return true;
        // Else, return false
        return false;
    }

}

?>
