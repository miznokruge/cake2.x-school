<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
App::uses('AppHelper', 'View/Helper');

class UtilHelper extends AppHelper {

    public $helpers = array('Session', 'Html');

    function nolnoldidepan($value, $places = 5) {
        $leading = '';
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

    public function say($currency) {
        $angka = array(false, 'satu ', 'dua ', 'tiga ', 'empat ', 'lima ', 'enam ', 'tujuh ', 'delapan ', 'sembilan ');
        $group = array(2 => 'ribu ', 3 => 'juta ', 4 => 'miliar ', 5 => 'triliyun ', 6 => 'kuadriliun ');
        $satuan = array(2 => 'puluh ', 3 => 'ratus ');
        $n = strlen($currency);
        $g = ceil($n / 3);
        $currency = str_pad($currency, $g * 3, '0', STR_PAD_LEFT);
        $str = '';
        for ($x = 0; $x < $g; $x++) {
            $t = $g - $x;
            $c = ltrim(substr($currency, $x * 3, 3), '0');
            $sub = false;
            $n = strlen($c);

            for ($i = 0; $i < $n; $i++) {
                $rpos = $n - $i;
                $gpos = (!$gpos = ($rpos % 3)) ? 3 : $gpos;
                $a = $c[$i];
                $s = false;
                if ($gpos == 1) {
                    $a = ($c[$i - 1] == 1 || !$a) ? false : $a;
                    $a = ($a == 1 && ($t == 2 && $c == 1)) ? 'se' : $angka[$a];
                } elseif ($gpos == 2 && $a == 1) {
                    $a = ($c[$i + 1] > 1) ? $angka[$c[$i + 1]] : 'se';
                    $s = ($c[$i + 1] > 0) ? 'belas ' : $satuan[$gpos];
                } elseif ($gpos == 2 && $a != 1) {
                    $s = ($a) ? $satuan[$gpos] : false;
                    $a = $angka[$a];
                } else {
                    $s = ($a) ? $satuan[$gpos] : false;
                    $a = ($a == 1) ? 'se' : $angka[$a];
                }
                $sub.= $a . $s;
            }
            $str.= $sub . (($c) ? $group[$t] : false);
        }
        return $str;
    }

    function answerMap($char) {
        switch ($char):
            case '1':
                $h = 'A';
                break;
            case '2':
                $h = 'B';
                break;
            case '3':
                $h = 'C';
                break;
            case '4':
                $h = 'D';
                break;
            case '5':
                $h = 'E';
                break;
        endswitch;
        return $h;
    }

    function secToMinute($sec) {
        return ($sec / 60);
    }

    public function flash(array $types = array()) {
        // Get the messages from the session
        $messages = (array) $this->Session->read('messages');
        $cMessages = (array) Configure::read('messages');
        if (!empty($cMessages)) {
            $messages = (array) Hash::merge($messages, $cMessages);
        }
        $html = '';
        if (!empty($messages)) {
            //$html = '<div id="flash_message">';

            if ($types) {
                foreach ($types as $type) {
                    // Add a div for each message using the type as the class.
                    foreach ($messages as $messageType => $msgs) {
                        if ($messageType !== $type) {
                            continue;
                        }
                        foreach ((array) $msgs as $msg) {
                            $html .= $this->_message($msg, $messageType);
                        }
                    }
                }
            } else {
                foreach ($messages as $messageType => $msgs) {
                    foreach ((array) $msgs as $msg) {
                        $html .= $this->_message($msg, $messageType);
                    }
                }
            }
            //$html .= '</div>';
            if ($types) {
                foreach ($types as $type) {
                    CakeSession::delete('messages.' . $type);
                    Configure::delete('messages.' . $type);
                }
            } else {
                CakeSession::delete('messages');
                Configure::delete('messages');
            }
        }

        return $html;
    }

    /**
     * Outputs a single flashMessage directly.
     * Note that this does not use the Session.
     *
     * @param string $message String to output.
     * @param string $type Type (success, warning, error, info)
     * @param bool $escape Set to false to disable escaping.
     * @return string HTML
     */
    public function flashMessage($msg, $type = 'info', $escape = true) {
        $html = '<div class="flash-messages flashMessages">';
        if ($escape) {
            $msg = h($msg);
        }
        $html .= $this->_message($msg, $type);
        $html .= '</div>';
        return $html;
    }

    /**
     * Formats a message
     *
     * @param string $msg Message to output.
     * @param string $type Type that will be formatted to a class tag.
     * @return string
     */
    protected function _message($msg, $type) {
        if (!empty($msg)) {
//            return '<div class="alert alert-' . (!empty($type) ? '' . $type : '') . ' alert-dismissable" role="alert"><button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button><strong>' . ucfirst($type) . '!</strong><p>' . $msg . '</p></div>';
            return '<script>
    $(function() {
        $.msgGrowl({
            title: "' . $type . '"
            , text: "' . $msg . '",
                position:"bottom-right"
        });
    });

</script>';
        }
        return '';
    }

    /**
     * Add a message on the fly
     *
     * @param string $msg
     * @param string $class
     * @return void
     */
    public function addFlashMessage($msg, $class = null) {
        CommonComponent::transientFlashMessage($msg, $class);
    }

    function seo_url($txt) {
        /*
          URL-FRIENDLY STRING RENAMER
          => Needed Params
          # txt
          eg : $friendly_url = Url('Bonjour Monsieur 1993 !') => will return bonjour-monsieur-1993
         */
        $txt = strtolower(trim($txt));
        $string = strtr(trim($txt), '�����������������������������������������������������', 'aaaaaaaaaaaaooooooooooooeeeeeeeecciiiiiiiiuuuuuuuuynn');
        $txt = preg_replace('[^a-z0-9]', '-', $txt);
        $txt = preg_replace('#([^a-z0-9_-]|(-){2,})#', '-', $txt);
        $txt = str_replace('_', '-', $txt);
        $txt = str_replace('---', '-', $txt);
        $txt = str_replace('--', '-', $txt);
        return $txt;
    }

    function timeAgo($ptime) {
        $etime = time() - $ptime;

        if ($etime < 1) {
            return '0 seconds';
        }

        $a = array(365 * 24 * 60 * 60 => 'year',
            30 * 24 * 60 * 60 => 'month',
            24 * 60 * 60 => 'day',
            60 * 60 => 'hour',
            60 => 'minute',
            1 => 'second'
        );
        $a_plural = array('year' => 'years',
            'month' => 'months',
            'day' => 'days',
            'hour' => 'hours',
            'minute' => 'minutes',
            'second' => 'seconds'
        );

        foreach ($a as $secs => $str) {
            $d = $etime / $secs;
            if ($d >= 1) {
                $r = round($d);
                return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
            }
        }
    }

}
