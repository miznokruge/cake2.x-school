<?php
class QuotelibComponent extends Component 
{
    //QuoteState Constant
    CONST QNEW = 1;
    CONST QSUCCESS = 2;
    CONST QFAIL = 3;
    CONST QPENDING = 4;

    CONST DAY = 86400;
    protected $QuoteNote;
    protected $Quote;

    public $components = array(
        'Util','Auth','Arr'
    );

    public function pending(array $data,$quoteID)
    {
        $result = FALSE;
        $this->QuoteNote = ClassRegistry::init('QuoteNote');
        
        $this->QuoteNote->set('content',$data['content']);
        $this->QuoteNote->set('quote_id',$quoteID);
        $this->QuoteNote->set('created_date',date('Y-m-d'));
        $this->QuoteNote->set('user_id',$this->UserAuth->user('id'));

        if(!$this->QuoteNote->save())
        {
            return FALSE;
        }

        $this->Quote = ClassRegistry::init('Quote');

        $this->Quote->id = $quoteID;
        $this->Quote->set('quote_state_id',self::QPENDING);//pending quote
        
        //checkdate
        $checkdate = $this->Arr->Get($data,'check_date');
        if( !$checkdate )
        {
            $dayOfWeek = $this->Util->mapWeek[date('w',time())];
            
            //jika hari ini jumat skip sabtu dan minggu (2 hari), jika sabtu skip minggu
            if( $dayOfWeek === 'Jumat')
            {
                $checkdate = date('Y-m-d',time() + self::DAY * 5 ); //tambah 2 hari
            }
            elseif( $dayOfWeek === 'Sabtu' )
            {
                $checkdate = date('Y-m-d',time() + self::DAY * 4 ); //tambah 1 hari
            }
            else
            {
                $checkdate = date('Y-m-d',time() + self::DAY * 3 );
            }          
        }
        else
        {
            $checkdate = date('Y-m-d',strtotime($checkdate));
        }

        $this->Quote->set('check_date',$checkdate );
        $result = $this->Quote->save();
        return $result;
    }
}