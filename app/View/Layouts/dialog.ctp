<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
$cakeDescription = __d('cake_dev', 'Home');
header("Cache-Control: no-cache,no-store,must-revalidate");
header("Expires: -1");
?>
<!DOCTYPE html>
<html>
    <head>
        <!-- Mainly scripts -->
        <?php echo $this->Html->charset(); ?>
        <title>
            <?php echo 'CRM' ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php echo $this->Html->meta('icon'); ?>
        <?php echo $this->Javascript->link(array('jquery-11.min', 'jquery-ui-1.8.22.custom.min')); ?>
        <?php echo $this->Javascript->link('autoNumeric-1.7.4.min'); ?>
        <?php echo $this->Javascript->link(array('bootstrap.min', 'plugins/metisMenu/jquery.metisMenu', 'plugins/slimscroll/jquery.slimscroll.min', 'inspinia', 'plugins/pace/pace.min')); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine-en'); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine'); ?>
        <?php echo $this->Javascript->link('app/system'); ?>
        <?php echo $this->Javascript->link("plugins/gritter/jquery.gritter.min.js"); ?>
        <?php echo $this->Javascript->link(array('jquery.scrollPagination', 'jquery.playsound', 'jquery.idletimer', 'jquery.idletimeout', 'jquery.fancybox')); ?>
        <!-- Gritter -->
        <link href="/js/plugins/gritter/jquery.gritter.css" rel="stylesheet">
        <?php
        echo $this->Html->css('bootstrap.min.css');
        echo $this->Html->css(array('font-awesome.css'));
        echo $this->Html->css(array('Aristo.css', 'style', 'animate', 'jquery.fancybox'));
        //echo $this->Html->css('jquery-ui-1.8.22.custom');
        //echo $this->Html->css('trello');
        echo $this->Html->css('validationEngine.jquery.css');
        //echo $scripts_for_layout;
        if (isset($cssIncludes)) {
            foreach ($cssIncludes as $css) {
                echo $this->Html->css($css) . "\n";
            }
        }
        if (isset($jsIncludes)) {
            foreach ($jsIncludes as $js) {
                echo $this->Javascript->link($js) . "\n";
            }
        }
        ?>
    </head>
    <body>
        <?php echo $content_for_layout; ?>
        <script type="text/javascript">
            $(function () {
                $("input,select,textarea").addClass('form-control');
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
                                    'background': '#f2f2f2'
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
            // cache a reference to the countdown element so we don't have to query the DOM for it on each ping.
            var $countdown = $("#dialog-countdown");
            // start the idle timer plugin
            $.idleTimeout('#dialog_exp', 'div.ui-dialog-buttonpane button:first', {
                idleAfter: 30,
                pollingInterval: 2,
                keepAliveURL: '/utils/keepalive',
                serverResponseEquals: 'OK',
                onTimeout: function () {
                    window.location = "/users/logout/";
                },
                onIdle: function () {
                    $(this).dialog("open");
                },
                onCountdown: function (counter) {
                    $countdown.html(counter); // update the counter
                }
            });
            $('.rupiah').priceFormat({
                prefix: 'Rp ',
                centsSeparator: ',',
                thousandsSeparator: '.',
                centsLimit: 0
            });
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
<?php if ($this->Session->check('Message.flash')) { ?>
                setTimeout(function () {
                    $.playSound('/gfx/chimes.wav');
                    $.gritter.add({
                        title: 'Information',
                        text: '<?php echo $this->Session->flash('flash'); ?>',
                        time: 3000
                    });
                }, 1000);
<?php } ?>
        </script>
        <?php if ($userdata['group_id'] == 3) { ?>
            <script>
                $(function () {
                    var cek_tagihan_count = function () {
                        $.get("<?php echo $this->webroot . 'deadline/getTagihanCount'; ?>", function (resp) {
                            //alert(resp);
                            $("#tagihan_count").html('<strong>' + resp + '</strong> order hampir deadline').fadeTo(50, 0.1).fadeTo(200, 1.0);
                        });
                    }
                    cek_tagihan_count();
                });
            </script>
        <?php } ?>
    </body>
</html>
