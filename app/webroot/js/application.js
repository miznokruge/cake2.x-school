/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 * 
 * @created by mizno kruge
 * @copyright mizno kruge
 * @created date march 2015
 * @email: mizno.kruge@gmail.com
 *  
 */
$(function () {
    if (global_flash_message_out == 1) {
        function call_janda() {
            $.niftyNoty({
                type: "danger",
                icon: "fa fa-info fa-lg",
                title: "Information",
                message: global_flash_message,
                timer: 15000
            });
        }
        call_janda();
    }
    $("#notification-counter").parent().click(function () {
        $("#notification-counter").html('');
    });
    $("#message-counter").parent().click(function () {
        $("#message-counter").html('');
    });
    $("#notification-counter").click(function () {
        $(this).html('');
    });
    $("td.actions a").addClass('btn btn-default btn-xs');
    $(".datepicker").datepicker({
        dateFormat: 'yy-mm-dd'
    });
    $(".select2").select2();
    $("#flash_message").delay(5000).fadeOut(1000);
    var samakan_heights = $(".samakan-tinggi").map(function ()
    {
        return $(this).height();
    }).get(),
            maxHeight = Math.max.apply(null, samakan_heights) + 40;
    $(".samakan-tinggi").css(
            {
                'height': maxHeight + 'px'
            });
    $(".print-btn").click(function () {
        var url = $(this).attr("alt");
        $.fancybox.open({
            helpers: {
                overlay: {
                    css: {
                        'background': '#000',
                        opacity: 0.8,
                    }
                }
            },
            href: url,
            type: 'iframe',
            padding: 10,
            maxWidth: 800,
            maxHeight: 650,
            fitToView: false,
            width: '70%',
            height: '70%',
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none'
        });
        return false;
    });
    function notify(type, text, url) {
        var n = noty({
            text: text,
            type: type,
            dismissQueue: true,
            layout: 'bottomRight',
            closeWith: ['click', 'button'],
            template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
            theme: 'relax',
            maxVisible: 10,
            animation: {
                open: 'animated bounceInRight',
                close: {height: 'toggle'},
                easing: 'swing',
                speed: 1000
            },
            callback: {
                onShow: function () {
                },
                afterShow: function () {
                },
                onClose: function () {
                    window.location.href = url;
                },
                afterClose: function () {
                },
                onCloseClick: function () {
                },
            },
        });
        //console.log('html: ' + n.options.id);
    }
    var pull_notification = function () {
        var dataAlert = [{
                type: "info"
            }, {
                type: "primary"
            }, {
                type: "success"
            }, {
                type: "warning"
            }, {
                type: "danger"
            }, {
                type: "mint"
            }, {
                type: "purple"
            }, {
                type: "pink"
            }, {
                type: "dark"
            }
        ];
        $.ajax({
            type: "get",
            url: "/Notifications/get_all",
            error: function (msg) {
                //notify('error', 'error loading notifications');
                console.log('error loading notification!');
            },
            success: function (msg) {
                var json = $.parseJSON(msg);
                if (json.length > 0) {
                    for (var i = 0; i < json.length; i++) {
                        //notify(json[i].type, json[i].content, json[i].url);
                        var alertContent = '<div><strong>Alert</strong><p>' + json[i].content + '</p></div>';
                        var autoClose = true;
                        notifcount = 0;
                        var notifcount_txt = $("#notification-counter").html();
                        if (notifcount_txt != '') {
                            notifcount = parseInt(notifcount_txt);
                        }
                        dataNum = nifty.randomInt(0, 8);
                        contentHTML = alertContent.replace("btn-danger", "btn-warning");
                        $.niftyNoty({
                            type: dataAlert[dataNum].type,
                            container: 'floating',
                            html: contentHTML,
                            callback: {
                                onShow: function () {
                                },
                                afterShow: function () {
                                },
                                onClose: function () {
                                    window.location.href = url;
                                },
                                afterClose: function () {
                                },
                                onCloseClick: function () {
                                    alert("lala");
                                },
                            },
                            timer: autoClose ? 5000 : 0
                        });
                        notifcount = notifcount + 1;
                        $("#notification-counter").html(notifcount);
                    }
                }
            }
        });
    }
    if (loggedin == 1) {
        pull_notification;
        setInterval(pull_notification, 10000); // refresh every 10000 milliseconds
    }
    $(".btn-notif").click(function () {
        notify('error', 'error brooohhh');
    });
});