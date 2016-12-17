<?php
    $orderChooser = '<label>Pilih Order (optional):</label><select name="data[Ticket][order_id]" id="TicketOrderId">';
    $orderChooser .= '<option value="0">--Tidak Pilih--</option>';
    foreach(array_reverse($orders, true) as $value => $label){
        $orderChooser .= '<option value="'.$value.'">'.$label.'</option>';
    }
    $orderChooser .= '</select>';
    echo $orderChooser;
?>