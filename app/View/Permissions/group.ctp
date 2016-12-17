<?php
set_time_limit(30000000);
?>
<div class='row-fluid'>
    <div class="span12">
        <table class="table" id="permission">
            <thead>
                <tr>
                    <th style="width:10%;">ID</th>
                    <th style="width:10%;">Nama</th>
                    <th style="width:10%;">Allow?</th>
                    <th>Keterangan</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php echo $this->Treegrid->renderPermissions($data, $allowed_acos, $emm); ?>
            </tbody>
        </table>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        $('table#permission').treegrid();
        $(".cb").click(function() {
            var c = $(this).is(":checked");
            if (c == true) {//grant
                var cmd = 'grant';
            } else {//deny
                var cmd = 'deny';
            }
            var group = '<?php echo $group_id; ?>';
            var url = '<?php echo $this->base; ?>/permissions/acl_permission/' + group;
            var path = $(this).attr("id");
            var data = 'cmd=' + cmd + '&path=' + path;
            $("#message__" + path).html('<?php echo $this->Html->image("select2-spinner.gif"); ?> processing... please wait.....');
            $.post(url, data, function(balik) {
                if (balik == 'success') {
                    $("#message__" + path).html(cmd + ': command executed successfully! <i class="icon-thumbs-up"></i>');
                } else {
                    $("#message__" + path).html(cmd + ': command failed! <i class="icon-remove"></i>');
                }
            });
        });
    });
</script>