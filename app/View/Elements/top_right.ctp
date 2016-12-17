<script>
    $(function () {
<?php if ($user_group_id == 3) { ?>
            var cek_tagihan_count = function () {
                $.get("<?php echo $this->webroot . 'deadline/getTagihanCount'; ?>", function (resp) {
                    //alert(resp);
                    $("#tagihan_count").html('<strong>' + resp + '</strong> order hampir deadline').fadeTo(50, 0.1).fadeTo(200, 1.0);
                });
            }
            cek_tagihan_count();
<?php } ?>
        $("a.fancybox").fancybox();

    });
</script>