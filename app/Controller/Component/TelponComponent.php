<?php
/**
 * Common functions use at TelponControllers
 *
 * @author Mizno Kruge
 */

App::uses('Component', 'Controller');

set_exception_handler(null);

function apiExceptionHandler(Exception $exception)
{       
   $response = array(    
        'header' => array(              
            'method'   => 'crm_api',
            'code'     => 500,
            'agent'    => 'CRM' 
        ),
        'body' => array(
            'data' =>  $exception->getMessage(),
            'message' => $exception->getMessage()
        )
    );
    header('HTTP/1.0 500 Internal Error');
    echo json_encode($response);
    exit();             
}

set_exception_handler('apiExceptionHandler');

class TelponComponent extends Component 
{
    public $default_config = array(
        'persistent'    => false,
        'host'          => '127.0.0.1',
        'protocol'      => 'tcp',
        'port'          => 9090,
        'timeout'       => 30
    );

    CONST CS_ANSWERED = 1;
    CONST CS_TRANSFER_ACCEPTED = 2;
    CONST CS_MISSED_CALL = 3;
    CONST CS_BUSSY = 4;
    CONST CS_REJECT_INCOMING = 5;
    CONST CS_CLOSE_PHONE = 6;
    CONST CS_OUTGOING_CALL = 7;

    protected $_statusMap = array();
    public $components = array('Arr'); 	

    public function __construct(ComponentCollection $collection, $settings = array()) {
        parent::__construct($collection,$settings);
        $this->_statusMap = array(
            self::CS_ANSWERED => 'Accept Call',
            self::CS_TRANSFER_ACCEPTED => 'Accept Call Transfer',
            self::CS_MISSED_CALL => 'Missed Call',
            self::CS_BUSSY  => 'Busy',
            self::CS_REJECT_INCOMING => 'Reject',
            self::CS_CLOSE_PHONE => 'Call Terminated',
            self::CS_OUTGOING_CALL => 'Outgoing Call'
        );
    }

    public function isExternalCall(array $query)
    { 
        //if( (int)Configure::read('debug') !== 0 ) return True;

        $external = $this->Arr->get($query,'remote');      
        return strpos( strtoupper($external), 'UNKNOWN' ) !== False;

        //external simulated
        //$external = $this->Arr->get($query,'remote');
        //return strpos( strtoupper($external), '556' ) !== False;
    }

    public function getUserByPhone($phone_address)
    {      
        $User = ClassRegistry::init('User');       
        $User->unbindAll();

        $user = $User->find('first',array(
            'conditions' => array('User.phone_address' => $phone_address)
        ));
       
        return ($user) ? $user : NULL;
    }

    public function getUserByIp($ip_address)
    {      
        $User = ClassRegistry::init('User');       
        $User->unbindAll();

        $user = $User->find('first',array(
            'conditions' => array('User.ip_address' => $ip_address)
        ));
       
        return ($user) ? $user : NULL;
    }

    public function getComputerAddress($phone_address)
    {
    	$user = $this->getUserByPhone($phone_address);

        if( $user ){
            return $user['User']['ip_address'];
        }else{
            return NULL;
        }
    }

    public function writePopupMessage($data)
    {      
        $msg = array(
            'header' => array(      
                'agent'    => 'CRM',        
                'method'   => 'tutup'
            ),
            'body' => array('data'  => $data,'message' => 'pop up message')
        );
        return json_encode($msg);
    }

    public function pushTransfer($ipAddress)
    {
    	$user = $this->getUserByIp($ipAddress);

    	$TransQueue = ClassRegistry::init('TransferQueue');
    	$TransQueue->set('from_user_id',$user['User']['id']);
    	$TransQueue->set('incoming_date', date('Y-m-d H:i:s',time()) );
        $TransQueue->set('status', 0 );

    	if( !$TransQueue->save() )
    	{
    		throw new ErrorException('Something went wrong, cannot save transfer call information.');
    	}
    }

    public function popTransfer($user)
    {        
        $result  = $this->getLatestTransfer($user['User']['id']);

        if( (boolean)$result )
        {   
            $TransQueue = ClassRegistry::init('TransferQueue');  
            $ds = $TransQueue->getDataSource();              
            $_sql = 'UPDATE transfer_queues SET to_user_id = '.$user['User']['id'].', status = 1 WHERE id = '.$result[0]['TransferQueue']['id'];
            $ds->query($_sql);
		}
        return (boolean)$result;
    }

    public function CheckFinishedTransfer($user)
    {
        $TransQueue = ClassRegistry::init('TransferQueue');      
        $ds = $TransQueue->getDataSource();  
        $_sql = 'SELECT * FROM transfer_queues WHERE `to_user_id` = '.$user['User']['id'].' AND `status` = 1 ORDER BY id DESC LIMIT 1';

        $row = $ds->query($_sql);  
        
        if( count($row) > 0 )
        {
            $ds->query('UPDATE transfer_queues SET `status` = 2 WHERE `id` = '.$row[0]['transfer_queues']['id']);
            return True;
        }

        return False;
    }

    //return null if not exists
    protected function getLatestTransfer($user_id,$use_null = True)
    {
        $TransQueue = ClassRegistry::init('TransferQueue');  
        $result = null;
        $ds = $TransQueue->getDataSource();

        if( $use_null === TRUE )
            $check_null = ' WHERE `TransferQueue`.`to_user_id` IS NULL AND ';
        else
            $check_null = ' WHERE `TransferQueue`.`status` = 0 AND ';

        $_sql = 'SELECT *
            FROM `transfer_queues` AS `TransferQueue`'.$check_null.'  
            `TransferQueue`.`from_user_id` <> '.$user_id.'
            ORDER BY `TransferQueue`.`id` DESC  LIMIT 1';

        return $ds->query($_sql);
    }

    public function checkOutgoing($user)
    {
        $TransQueue = ClassRegistry::init('TransferQueue');  
        $ds = $TransQueue->getDataSource();      
        $row = $ds->query('SELECT * FROM `out_calls` WHERE from_id = '.$user['User']['id']); 

       if( count($row) > 0 )
       {
          $ds->query('DELETE FROM `out_calls` WHERE id = '.$row[0]['out_calls']['id']); 
          return True;           
       } 
       else
       {
        return False;
       }
    }

    //return boolean
    public function shouldNotPopup($user,$asboolean = False)
    {
        $TransQueue = ClassRegistry::init('TransferQueue');  
        $ds = $TransQueue->getDataSource();
        
        $result = null;

        $ds = $TransQueue->getDataSource();

        $_sql = 'SELECT `TransferQueue`.`id`, 
        `TransferQueue`.`from_user_id`, 
        `TransferQueue`.`to_user_id`, 
        `TransferQueue`.`incoming_date`, 
        `TransferQueue`.`status` 
        FROM `transfer_queues` AS `TransferQueue`   
        WHERE 
        `TransferQueue`.`from_user_id` = '.$user['User']['id'].'   
        ORDER BY `TransferQueue`.`id` DESC  LIMIT 1';

        $result = $ds->query($_sql);

        if( count($result) > 0 )
        { 
            $status = $result[0]['TransferQueue']['status'];

            $incoming_time = strtotime( $result[0]['TransferQueue']['incoming_date'] );
            $diff = date('s', time() - $incoming_time );

            if ( ( (int)$diff >= 10 ) AND (int)$status !== 2 ){               
                $ds->query('UPDATE `transfer_queues` SET `status` = 2 WHERE `id` = '.$result[0]['TransferQueue']['id']);
                return False;
            }

            return (int)$status !== 2;
        }
        else
        {
            return False;
        }       
    }

    /**
     * for status please refer to CONSTANT definition of this class
     */
    public function log_call($status,$ipAddress)
    {
        if ( !array_key_exists($status, $this->_statusMap) )
        {
            return False;
        }
        $user = $this->getUserByIp($ipAddress);

        $Log = ClassRegistry::init('CallLog');
        $Log->set('incoming_date',date('Y-m-d H:i:s',time()) );
        $Log->set('user_id',$user['User']['id']);
        $Log->set('status',$status);

        return $Log->save();
    }

    public function outGoingTrigger($user)
    {
        $TransQueue = ClassRegistry::init('TransferQueue');
        $ds = $TransQueue->getDataSource();
        $ds->query('INSERT INTO `out_calls`(`from_id`) VALUES('.$user['User']['id'].')');
    }

    //helper function
    public function getStatusString($statusCode)
    {
        return $this->Arr->get($this->_statusMap,$statusCode,'Unknown');
    }

    //return html markup of bootstrap label
    public function getStatusAsLabel($statusCode)
    {
        switch ((int)$statusCode) 
        {
            case self::CS_ANSWERED :
                return '<div class="label label-success">'.$this->getStatusString($statusCode).'</div>';
                break;
            case self::CS_TRANSFER_ACCEPTED :
                return '<div class="label label-info">'.$this->getStatusString($statusCode).'</div>';
                break;
            case self::CS_MISSED_CALL :
                return '<div class="label label-default">'.$this->getStatusString($statusCode).'</div>';
                break;
            case self::CS_BUSSY :
                return '<div class="label label-warning">'.$this->getStatusString($statusCode).'</div>';
                break;
            case self::CS_REJECT_INCOMING :
                return '<div class="label label-important">'.$this->getStatusString($statusCode).'</div>';
                break;               
            case self::CS_CLOSE_PHONE :
                return '<div class="label label-default">'.$this->getStatusString($statusCode).'</div>';
                break;     
            case self::CS_OUTGOING_CALL :
                return '<div class="label label-info">'.$this->getStatusString($statusCode).'</div>';
                break;                                            
            default:
                return '<div class="label label-default">'.$this->getStatusString($statusCode).'</div>';
                break;
        }
    }
}