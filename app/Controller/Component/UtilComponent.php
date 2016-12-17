<?php

App::uses('Component', 'Controller');

class UtilComponent extends Component {

    public $user;
    public $controller;
    public $mapMonth = array(
        '01' => 'A',
        '02' => 'B',
        '03' => 'C',
        '04' => 'D',
        '05' => 'E',
        '06' => 'F',
        '07' => 'G',
        '08' => 'H',
        '09' => 'I',
        '10' => 'J',
        '11' => 'K',
        '12' => 'L',
    );
    //Ref : http://php.net/manual/en/function.date.php w format
    public $mapWeek = array(
        'Minggu',
        'Senin',
        'Selasa',
        'Rabu',
        'Kamis',
        'Jumat',
        'Sabtu'
    );

    function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    function startup(Controller $controller) {

    }

    function nolnoldidepan($value, $places = 3) {
        if (is_numeric($value)) {
            for ($x = 1; $x <= $places; $x++) {
                $ceiling = pow(10, $x);
                if ($value < $ceiling) {
                    $zeros = $places - $x;
                    for ($y = 1; $y <= $zeros; $y++) {
                        $leading .= "0";
                    }
                    $x = $places + 1;
                }
            }
            $output = $leading . $value;
        } else {
            $output = $value;
        }
        return $output;
    }

    /**
     * Transform regular request data into an array that is
     * saveable by Cake's Model save functions
     *
     * throw exception if $requestData is invalid prevent bad data supplied to system,
     *  eg :
     *       array(
     *           'qty' => array(2), <-- bad
     *           'sell_price' => array(50,70),
     *           'price_list' => array(40,50)
     *       );
     * @param array $requestData
     * @return array $saveableArray
     */
    function toSaveableArray($requestData) {
        $items = array();
        if ($requestData) {
            $_count = 0;
            // Transform the buy data into saveable arrays
            foreach ($requestData as $atr => $data_arr) {
                /* $tmp_count = count($data_arr);
                  if( $_count === 0 OR $_count === $tmp_count )
                  $_count = $tmp_count;
                  else
                  continue; */

                if ($data_arr) {
                    foreach ($data_arr as $key => $value) {
                        if (!isset($items[$key])) {
                            $items[$key] = array();
                        }
                        $items[$key][$atr] = $value;
                    }
                }
            }
        }

        return $items;
    }

    function getCurrentState($orderId) {
        $this->Order = ClassRegistry::init('Order');
        $result = $this->Order->find('all', array('conditions' => array('Order.id' => $orderId)));
        $state_id = $result[0]['Order']['state_id'];
        return $state_id;
    }

    function getAllTicketStates(array $conditions = NULL) {
        $this->TicketStates = ClassRegistry::init('TicketStates');
        $_params = array(
            'recursive' => 2,
            'fields' => array('id', 'name', 'color')
        );

        /* if( is_array($conditions) )
          {
          $_params['conditions'] = $conditions;
          $_params['joins'] = array(array(
          'table' => 'tickets',
          'alias' => 'Ticket',
          'type' => 'LEFT',
          'foreignKey' => false,
          'conditions'=> array('Ticket.ticket_state_id = TicketStates.id')
          ));
          } */

        $all_states = $this->TicketStates->find('all', $_params);

        // Count tickets in each state
        $this->Ticket = ClassRegistry::init('Ticket');
        $ticketCount = array();
        foreach ($all_states as $state) {
            $tstateId = $state['TicketStates']['id'];
            $conditions['Ticket.ticket_state_id'] = $tstateId;
            $ticketCount[$tstateId] = $this->Ticket->find('count', array(
                'conditions' => $conditions
            ));
        }

        $states = array();
        foreach ($all_states as $state) {
            $tstateId = $state['TicketStates']['id'];
            $state['TicketStates']['count_ticket'] = $ticketCount[$tstateId];
            $states[$tstateId] = $state['TicketStates'];
        }

        return $states;
    }

    function validationErrorsToStr(array $arr) {
        $result = '';
        foreach ($arr as $r) {
            foreach ($r as $msg)
                $result .= $msg . PHP_EOL;
        }

        return $result;
    }

    /**
     *
     *   ex : https://maps.googleapis.com/maps/api/js?key=API_KEY&sensor=SET_TO_TRUE_OR_FALSE
     *   API_KEY retrived from core.config
     *
     *
     *   @param boolean $secure use https?
     *   @param boolean $sensor
     *   @return string google map scripts
     */
    function mapScripts($secure = FALSE, $sensor = TRUE) {
        $config = Configure::read('google_map');
        $API_KEY = isset($config['key']) ? $config['key'] : NULL;
        if (!$API_KEY)
            throw new ErrorException('Oooopps, API KEY not found on config.');
        $protocol = 'http';

        if ($secure)
            $protocol = 'https';
        $censor = ($sensor) ? 'true' : 'false';
        return $protocol . '://maps.googleapis.com/maps/api/js?key=' . $API_KEY . '&sensor=' . $censor;
    }

    //make sure pricelist or list_price is greater than zero
    function isValidPrice(array $prices) {
        foreach ($prices as $price) {

            $price = $this->filterPrice($price['sell_price']);

            if (!$this->isDecimal($price) AND $price <= 0)
                return FALSE;
            else
                return TRUE;
        }
        return TRUE;
    }

    function isValidDate($str) {
        return (strtotime($str) !== FALSE);
    }

    function generateAkunCode($code, $childCount) {
        return ($code . (int) $childCount + 1);
    }

    function generateTransID(array $data) {
        if (!isset($data['Bank'])) {
            return 'NULL';
        } // or throw exception?

        $this->Bank = ClassRegistry::init('Bank');
        $bank = $this->Bank->read(NULL, $data['Bank']['id']);
        $new_counter = (int) $bank['Bank']['counter'] + 1;
        $this->Bank->id = $bank['Bank']['id'];
        $this->Bank->set('counter', $new_counter);
        $this->Bank->save();

        $m = $this->mapMonth[date('m')];
        return sprintf('%s %s-%d/%d', $bank['Bank']['code_bank'], $m, $new_counter, date('y'));
    }

    function getPOPath($path, $first = FALSE) {
        $v_number = explode('-', $path);
        if ($first === TRUE)
            return $v_number[0];
        if (count($v_number) === 3) {
            return $v_number[0] . '/' . substr($v_number[1], 0, 3) . '/' . substr($v_number[2], 2, 2);
        }
    }

    function getActiveSuppliers() {
        $Supplier = ClassRegistry::init('Supplier');
        $Supplier->unbindAll();
        return $Supplier->find('all', array('fields' => array('id', 'name', 'status')));
    }

    //remove duplicate params on querystring
    public function removeDuplicateParams($params) {
        $vars = explode('&', $_SERVER['QUERY_STRING']);

        $final = array();

        if (!empty($vars)) {
            foreach ($vars as $var) {
                $parts = explode('=', $var);

                $key = isset($parts[0]) ? $parts[0] : null;
                $val = isset($parts[1]) ? $parts[1] : null;

                if (!empty($val))
                    $final[$key] = $val;
            }
        }

        return http_build_query($final);
    }

    public function bilang($x) {
        $x = abs($x);
        $angka = array("", "satu", "dua", "tiga", "empat", "lima",
            "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
        $result = "";
        if ($x < 12) {
            $result = " " . $angka[$x];
        } else if ($x < 20) {
            $result = bilang($x - 10) . " belas";
        } else if ($x < 100) {
            $result = bilang($x / 10) . " puluh" . bilang($x % 10);
        } else if ($x < 200) {
            $result = " seratus" . bilang($x - 100);
        } else if ($x < 1000) {
            $result = bilang($x / 100) . " ratus" . bilang($x % 100);
        } else if ($x < 2000) {
            $result = " seribu" . bilang($x - 1000);
        } else if ($x < 1000000) {
            $result = bilang($x / 1000) . " ribu" . bilang($x % 1000);
        } else if ($x < 1000000000) {
            $result = bilang($x / 1000000) . " juta" . bilang($x % 1000000);
        } else if ($x < 1000000000000) {
            $result = bilang($x / 1000000000) . " milyar" . bilang(fmod($x, 1000000000));
        } else if ($x < 1000000000000000) {
            $result = bilang($x / 1000000000000) . " trilyun" . bilang(fmod($x, 1000000000000));
        }
        return $result;
    }

    public function Resize($source, $dest, $extension, $size, $scale = 2) {
        $thumb_size = $size;

        $sizes = getimagesize($source);
        $width = $sizes[0];
        $height = $sizes[1];
        $x = 0;
        $y = 0;
        if ($extension == '.jpg')
            $im = imagecreatefromjpeg($source);
        elseif ($extension == '.gif')
            $im = imagecreatefromgif($source);
        elseif ($extension == '.png')
            $im = imagecreatefrompng($source);
        if ($scale == 1) {
            if ($width > $height) {

                $coeff = $width / $size;
                $width = $size;
                $height = round($height / $coeff);
            } elseif ($height > $width) {
                $coeff = $height / $size;
                $height = $size;
                $width = round($width / $coeff);
            } else {
                $width = $size;
                $height = $size;
            }
            $new_im = imagecreatetruecolor($width, $height);

            imagecopyresampled($new_im, $im, 0, 0, 0, 0, $width, $height, $sizes[0], $sizes[1]);
        } else {
            if ($width > $height) {
                $x = ceil(($width - $height) / 2);
                $width = $height;
            } elseif ($height > $width) {
                $y = ceil(($height - $width) / 2);
                $height = $width;
            }
            $new_im = imagecreatetruecolor($thumb_size, $thumb_size);

            imagecopyresampled($new_im, $im, 0, 0, $x, $y, $thumb_size, $thumb_size, $width, $height);
        }

        if ($extension == '.jpg')
            imagejpeg($new_im, $dest, 80);
        elseif ($extension == '.gif')
            imagegif($new_im, $dest);
        elseif ($extension == '.png')
            imagepng($new_im, $dest);
        imagedestroy($new_im);
        imagedestroy($im);
    }

    public function array_splite($array, $pieces = 2) {
        if ($pieces < 2)
            return array($array);
        $newCount = ceil(count($array) / $pieces);
        $a = array_slice($array, 0, $newCount);
        $b = $this->array_splite(array_slice($array, $newCount), $pieces - 1);
        return array_merge(array($a), $b);
    }

    function filterPrice($price) {
        list($price, $sampah) = explode(".", $price);
        $price = str_replace('Rp ', '', $price);
        $price = str_replace(',', '', $price);
        $num_price = doubleval($price);
        return $num_price;
    }

    function getLastQuery($model) {
        $dbo = $model->getDatasource();
        $logs = $dbo->getLog();
        return $logs;
    }

    /**
     * Transform regular request data into an array that is
     * saveable by Cake's Model save functions
     *
     * @param array $requestData
     * @return array $saveableArray
     */
    function getAllStates() {
        $this->States = ClassRegistry::init('States');
        $all_states = $this->States->find('all');
        $states = array();
        foreach ($all_states as $state) {
            $states[$state['States']['id']] = $state['States'];
        }
        return $states;
    }

    function calculateTotalDiscount($discount) {
        $p = explode('+', $discount);
//        var_dump($p);
        $nominalDiscount = 0;
        if (count($p) == 1) {
            $textDiscount = str_replace(',', '.', $p[0]);
            $textDiscount = str_replace(' ', '', $textDiscount);
            $nominalDiscount = (double) $textDiscount;
        } else {
            foreach ($p as $d) {
                $nominalDiscount += ($d) * (1 - $nominalDiscount / 100);
            }
        }
        return $nominalDiscount;
    }

    function calculateBuyPriceTotal($item) {
        if (isset($item['supplier_discount'])) {
            $afterDiscount = 100 - $this->calculateTotalDiscount($item['supplier_discount']);
            return $item['qty'] * $item['list_price'] * $afterDiscount / 100;
        } else {
            // If supplier discount not set, make buy price 0, we're not ready to count
            return 0;
        }
    }

    public function generateSupplierBuyPrice($items) {
        $supp_total = array();
        foreach ($items as $index => $item) {
            $supp_id = $item['supplier_id'];
            $totalBuyPrice = $this->calculateBuyPriceTotal($item);
            if (isset($supp_total[$supp_id])) {
                $supp_total[$supp_id] += $totalBuyPrice;
            } else {
                $supp_total[$supp_id] = $totalBuyPrice;
            }
        }
        return $supp_total;
    }

    public function combineSupplierOrders($supp_total, $osupps) {
        for ($i = 0; $i < count($osupps); $i++) {
            $osupps[$i]['buy_price'] = $supp_total[$osupps[$i]['supplier_id']];
        }
        return $osupps;
    }

    function filterSupplier($supplier) {
        $sArray = explode("@", $supplier);
        if (count($sArray) >= 2) {
            return $sArray[0];
        } else {
            return $supplier;
        }
    }

    public function totalSellWithShipping($total, $shippings) {
        foreach ($shippings as $shipping) {
            $total += $shipping['sell_price'];
        }
        return $total;
    }

    public function totalBuyWithShipping($total, $shippings) {
        foreach ($shippings as $shipping) {
            $total += $shipping['buy_price'];
        }
        return $total;
    }

    public function currentPeriod() {
        $period = date("Ym");
        return $period;
    }

    function space2underscore($string) {
        //Lower case everything
        $string = strtolower($string);
        //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string);
        //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s-]+/", " ", $string);
        //Convert whitespaces and underscore to dash
        $string = preg_replace("/[\s_]/", "-", $string);

        return $string;
    }

    function isDecimal($val) {
        return is_numeric($val) && floor($val) != $val;
    }

    public function AccountingSystemRef() {
        $s = strtoupper(md5(uniqid(rand(), true)));
        $guidText = 'SYS-' .
                substr($s, 0, 8) . '' .
                substr($s, 8, 4) . '' .
                substr($s, 12, 4);
        #substr($s, 16, 4) . '-' .
        #substr($s, 20);
        return strtoupper($guidText);
    }

    public function ciDate($date, $specs = "") {
        $r_date = date("Y-m-d", strtotime($date));
        if (substr($date, 0, 10) == '0000-00-00')
            $r_date = "-";
        if (strlen($date) == 19 && substr($date, 11, 8) != '00:00:00' || isset($specs['full']))
            $r_date.= " " . ltrim(substr($date, 11, 5), '0');
        return $r_date;
    }

    public function debug($var) {
        echo '<pre>';
        print_r($var);
        echo '</pre>';
        die;
    }

}
