<!--<div id="div_ganti_bahasa">
    <a href="/lang/setlang/eng" class="btn btn-primary btn-block"><?php echo $this->Html->image('eng.png'); ?> English</a>
    <a href="/lang/setlang/ind" class="btn btn-primary btn-block"><?php echo $this->Html->image('ind.png'); ?> Bahasa Indonesia</a>
    <a href="/lang/setlang/jpn" class="btn btn-primary btn-block"><?php echo $this->Html->image('jpn.png'); ?> Japan</a>
</div>
<script>
    $(function () {
        $("#btn_ganti_bahasa").click(function () {
            $("#div_ganti_bahasa").attr('title', '<?php echo __('Change Language'); ?>').dialog({
                modal: true,
                width: 400,
                height: 200,
                closeOnEscape: false,
                draggable: false,
                resizable: false
            });
        });
    });
</script>-->
<div id="dialog_exp" title="Your session is about to expire!" style="display: none;">
    <p>
        <span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 50px 0;"></span>
        You will be logged off in <span id="dialog-countdown" style="font-weight:bold; font-size:20px; color:#F00;"></span> seconds.
    </p>
    <p>Do you want to continue your session?</p>
</div>
<div id="dialog_logout" title="Confirm Logout" style="display: none;">
    <p>Do you want to continue logging out from this session?</p>
</div>
<div class="users form" id="frm_update_profile" title="Update Profile" style="display: none;">
    <?php echo $this->Form->create('User', array("type" => "file", 'action' => '/update_profile/', 'id' => 'form_update_profile')); ?>
    <fieldset>
        <?php
        echo $this->Form->input('id');
        echo $this->Form->input('username');
        echo $this->Form->input('name');
        echo $this->Form->input('prev_foto', array("type" => "hidden", 'value' => $this->Info->userdata($loggeuser_id, 'foto')));
        echo $this->Form->input('foto', array("type" => "file", "label" => false));
        echo $this->Form->input('description', array("type" => "textarea"));
        ?>
    </fieldset>
    <?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
    $(function () {
        $(".dialog-btn").click(function () {
            var url = $(this).attr("alt");
            $.fancybox.open({
                href: url,
                type: 'iframe',
                padding: 10,
                width: 960,
                height: 650
            });
            return false;
        });
        $(".print-btn").click(function () {
            var url = $(this).attr("alt");
            $.fancybox.open({
                helpers: {
                    overlay: {
                        css: {
                            'background': '#fff'
                        }
                    }
                },
                href: url,
                type: 'iframe',
                padding: 10,
                width: 960,
                height: 650
            });
            return false;
        });

        $("#dialog_exp").dialog({
            autoOpen: false,
            modal: true,
            width: 400,
            height: 200,
            closeOnEscape: false,
            draggable: false,
            resizable: false,
            buttons: {
                'Yes, Keep Working': function () {
                    $(this).dialog('close');
                },
                'No, Logoff': function () {
                    // fire whatever the configured onTimeout callback is.
                    // using .call(this) keeps the default behavior of "this" being the warning
                    // element (the dialog in this case) inside the callback.
                    $.idleTimeout.options.onTimeout.call(this);
                }
            }
        });
        $("#btn_update_profile").click(function () {
            $('form#form_update_profile').validationEngine('attach', {promptPosition: "bottomLeft", scroll: false});
            $("#frm_update_profile").dialog({
                modal: true,
                width: 600,
                height: 530,
                closeOnEscape: false,
                draggable: false,
                resizable: false,
                buttons: {
                    '<?php echo __('Save'); ?>': function () {
                        $('#form_update_profile').submit();
                    },
                    '<?php echo __('Cancel'); ?>': function () {
                        $(this).dialog('close');
                    }
                }
            });
            $(".ui-dialog-buttonset button").addClass('btn btn-success');
            $("input,select,textarea").addClass('form-control');
        });
        $("#btn-logout").click(function () {
            $("#dialog_logout").attr('title', 'Confirm Logout').dialog({
                modal: true,
                width: 400,
                height: 150,
                closeOnEscape: false,
                draggable: false,
                resizable: false,
                buttons: {
                    '<?php echo __('Continue logout'); ?>': function () {
                        window.location.replace('/users/logout/');
                    },
                    '<?php echo __('Cancel'); ?>': function () {
                        $(this).dialog('close');
                    }
                }
            });
        });
        // cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
        var $countdown = $("#dialog-countdown");
        // start the idle timer plugin
        $.idleTimeout('#dialog_exp', 'div.ui-dialog-buttonpane button:first', {
            idleAfter: 3600,
            pollingInterval: 2,
            keepAliveURL: '/configs/keepalive',
            serverResponseEquals: 'OK',
            onTimeout: function () {
                window.location = "/users/lockscreen/";
            },
            onIdle: function () {
                $(this).dialog("open");
            },
            onCountdown: function (counter) {
                $countdown.html(counter); // update the counter
            }
        });
        $('.rupiah,input.auto,input.numeric').autoNumeric({aSep: ',', aDec: '.', aSign: 'Rp '});
        $('[rel="popup"]').click(function () {
            var id = $(this).attr('p_id');
            var title = $(this).attr('p_title');
            var url = $(this).attr('p_url');
            $("#dialog").attr("title", title)
                    .html('<iframe src="/' + url + '" style="width:100%; height:100%; border:0;"></iframe>')
                    .dialog({
                        modal: true,
                        width: 800,
                        height: 500,
                        buttons: {
                            "ok": function () {
                                $(this).dialog("close");
                            }
                        }
                    });
        });
        WinMove();

        function generate(type, text) {

            var n = noty({
                text: text,
                type: type,
                dismissQueue: true,
                layout: 'bottomRight',
                closeWith: ['click'],
                theme: 'relax',
                maxVisible: 2,
                timeout: 8000,
                animation: {
                    open: 'animated bounceInRight',
                    close: 'animated bounceOutRight',
                    easing: 'swing',
                    speed: 1000
                }
            });
            //console.log('html: ' + n.options.id);
        }

<?php if ($this->Session->read('Message.flash.message') != '') { ?>
            setTimeout(function () {
                $.playSound('<?php echo $this->webroot; ?>/img/chimes.wav');
                var msg = '<div class="activity-item"> <i class="fa fa-bell fa-2x"></i> <div class="activity"><?php echo $this->Session->read('Message.flash.message'); ?></div> </div>';
                generate('error', msg);
            }, 30000);
<?php } ?>

<?php
$enable_notification = false;
if ($enable_notification) {
    ?>
            var cek_message = function () {
                $.get("<?php echo $this->webroot . 'messages/check_unread'; ?>", function (resp) {
                    var obj = $.parseJSON(resp);
                    for (var i = 0; i < obj.length; i++) {
                        generate('error', obj[i].user + ':' + obj[i].subject);
                    }
                });
            }
            setInterval(function () {
                cek_message();
            }, 10000);
<?php } ?>


//        function generateAll() {
//            generate('warning', notification_html[0]);
//            generate('error', notification_html[1]);
//            generate('information', notification_html[2]);
//            generate('success', notification_html[3]);
//        }

//        setTimeout(function () {
//            generateAll();
//        }, 500);
    });
</script>