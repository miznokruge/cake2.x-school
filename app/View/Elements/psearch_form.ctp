<?php
echo $this->Form->create('Payment');
?>
<div style="float:left; width:250px; overflow:hidden; clear: none;">
    <?php echo $this->Form->input("fdate", array("label" => "From Date", "type" => "text", "class" => "datepicker")); ?>
</div>
<div style="float:left; width:250px; overflow:hidden; clear: none;">
    <?php echo $this->Form->input("tdate", array("label" => "To Date", "type" => "text", "class" => "datepicker", "div" => "pull-left lala")); ?>
</div>
<div style="float:left; width:250px; overflow:hidden; clear: none;">
    <?php echo $this->Form->banks($banks); ?>
</div>
<div style="float:left; width:250px; overflow:hidden; clear: none; margin-top: 20px;">
    <?php echo $this->Form->end('Submit', array("class" => "btn btn-primary btn-success")); ?>
</div>
<div class="clear"></div>
<script>
    $(function () {
        $('.datepicker').datepicker({
            dateFormat: "yy-mm-dd"
        });
    });
</script>
<?php
function sumBayar($pembayaran) {
    if (is_array($pembayaran)) {
        $total = 0;
        foreach ($pembayaran as $b) {
            $total+=$b['amount'];
        }
        return $total;
    } else {
        return 0;
    }
}
