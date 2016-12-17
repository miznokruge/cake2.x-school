<div class="search_form">
    <fieldset>    
        <legend>Cari Order:</legend>
    </fieldset>
<h5>Masukan Info Customer yang Perlu Saja untuk Cari Order</h5>
<form id="searchForm"method="get" action="<?php echo $this->webroot; ?>orders/search">
<?php
    echo $this->Form->input('name', array('label' => 'Nama', 'name' => 'nama'
                        , 'type' => 'text'));
    echo $this->Form->input('po', array('label' => 'PO', 'name' => 'po'
                        , 'type' => 'text')); 
    echo $this->Form->input('alamat', array('label' => 'Alamat', 'name' => 'alamat'
                        , 'type' => 'text'));
    echo $this->Form->input('company', array('label' => 'PT', 'name' => 'pt'
                        , 'type' => 'text'));
    echo $this->Form->input('phone', array('label' => 'No. Telpon', 'name' => 'telpon'
                        , 'type' => 'text'));    
    echo $this->Form->input('order_id', array('label' => 'Order ID', 'name' => 'order_id'
                        , 'type' => 'number'));
    echo $this->Form->input('order_user', array('label' => 'Sales', 'name' => 'order_user'
                        , 'type' => 'select', 'options' => $users));           
    echo $this->Form->submit('Cari');
?>
</form>
</div>
<script>
    $(function(){
        $('form#searchForm').submit(function(event){
           $(':input[value=""]').attr('disabled', true);
        });
    });
</script>
