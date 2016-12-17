<?php 
    $ticketStateSelect = '<select class="ticket_state_selector">';
    foreach($ticketStates as $key => $tstate){
        $selected = ($key == $cStateId) ? 'selected' : '';
        $ticketStateSelect .= 
                '<option value="'.
                $key.'" '.$selected.'>'.$tstate.'</option>'
                ;
    }
    $ticketStateSelect .= '</select>' ;
    echo $ticketStateSelect;
?>
