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
<html xmlns="http://www.w3.org/1999/xhtml" ng-app>
    <head>
        <?php echo $this->Javascript->link('jquery-1.10.2'); ?>
        <?php echo $this->Javascript->link('jquery-ui-1.8.22.custom.min'); ?> 
        <?php echo $this->Javascript->link('autoNumeric-1.7.4.min'); ?>    
        <?php echo $this->Javascript->link('angular.min'); ?>
        <?php echo $this->Javascript->link('bootstrap.min'); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine-en'); ?>
        <?php echo $this->Javascript->link('jquery.validationEngine'); ?>
        <?php //echo $this->Javascript->link('trello_count'); ?> 
        <?php echo $this->Html->charset(); ?>
        <title>            
            <?php echo 'CRM' ?>:
            <?php echo $title_for_layout; ?>
        </title>
        <?php
        echo $this->Html->meta('icon');
        //echo $this->Html->css('cake.generic');
        echo $this->Html->css('bootstrap.min');
        echo $this->Html->css('font-awesome');
        echo $this->Html->css('Aristo.css');
        echo $this->Html->css('style.css');
        echo $this->Html->css('animate.css');
        //echo $this->Html->css('jquery-ui-1.8.22.custom');
        echo $this->Html->css('trello');
        echo $this->Html->css('validationEngine.jquery.css');
        echo $scripts_for_layout;
        if(isset($cssIncludes)){
            foreach($cssIncludes as $css){
                echo $this->Html->css($css);
            }
        }		
        ?>
        <link href="/font-awesome/css/font-awesome.css" rel="stylesheet">
        <?php if ($this->Session->read('Auth.User')) { ?>        
            <!--<script type="text/javascript" src="https://api.trello.com/1/client.js?key=c824dcc2d054e14643d3111a8e2715ad"></script>-->
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/jquery.masonry.min.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/underscore-min.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/mustache.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/blobbuilder.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/filesaver.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/vendor/showdown.js"></script>
            <script type="text/javascript" src="<?php echo $this->webroot; ?>js/jquery.cookie.js"></script>  
            <?php
            $userdata=$this->Session->read('Auth.User');
            //unset($userdata['board_id']);
            ?>
            <?php if ( $this->Array->get($userdata,'board_id') != '') { ?>   
            <script type="text/javascript">
                // Okay I admit the code is ugly...
                if (typeof console === "undefined" || typeof console.log === "undefined") { //Fix IE window.console bug
                    console = {};
                    console.log = function() {
                    };
                }
                $(document).ready(function() {
                    var defaultOptions = {
                        persist: true,
                        expiration: "never",
                        name: "CRM - Tricipta Media Perkasa",
                        scope: {
                            write: true,
                            read: true,
                            account: true
                        },
                        success: initDoc
                    };
                    if (typeof Trello === "undefined") {
                        $("#tnot").html("<h3>Koneksi ke Trello gagal! <a href='#' onclick='window.location.reload(true);'>Reload halaman ini</a></h3>").css(
                            {
                                'background':'#f00 !important'
                            });
                    }
                    if (!Trello.authorized()) {
                        return Trello.authorize(defaultOptions);
                    }
                    $(window).bind("hashchange", router);
                    $('.ui-dialog-titlebar-close').hide();
                });
                var int = setInterval(function() {
                    clear_notif();
                    initDoc2();
                }, 1000);
                var int2 = setInterval(function() {
                    initDoc();
                }, 60000);
                var initDoc2 = function() {
                    Trello.get('/board/<?php echo $this->Session->read('Trello.BID'); ?>/lists', function(cards) {
                        var mycard = cards[0].id;
                        Trello.get('/lists/' + mycard + '/cards?members=true', function(cards) {
                            $("#tnot").html('Harus dikerjakan <span style="color:#f00; font-weight:bold; font-size:15px; width:100px;" id="trello_notif_count">' + cards.length + '</span>');
                        });
                        //router();
                    });
                }
                var clear_notif=function(){
                    $("#tnot").html('Harus dikerjakan <span style="color:#f00; font-weight:bold; font-size:18px; width:100px;" id="trello_notif_count"></span>');
                }
                var initDoc = function() {
                    if (!Trello.authorized())
                        return Trello.authorize(defaultOptions);
                    Trello.get('/members/me', {boards: "open", organizations: "all"}, function(me) {
                        //console.log(me);
                        window.myself = me;
                        $("#__idMembers").val(me.id);
                        router();
                    }, function(xhr) {
                        if (xhr.status == 401) {
                            Trello.deauthorize();
                            $("#tnot").html("<h3>Koneksi ke Trello gagal! <a href='#' onclick='window.location.reload(true);'>Reload halaman ini</a></h3>").css(
                            {
                                'background':'#f00 !important'
                            });
                            Trello.authorize(defaultOptions);
                        } else {
                            $("#tnot").html("<h3>Koneksi ke Trello gagal! <a href='#' onclick='window.location.reload(true);'>Reload halaman ini</a></h3>").css(
                            {
                                'background':'#f00 !important'
                            });
                        }
                    });
                };
                var router = function() {
                    var hash = location.hash.replace("#", "");
                    if (hash !== "")
                    {
                        getBoard(hash);
                        GetNotifications(hash);
                    } else {
                        if (window.myself) {
                            listBoards();
                        } else {
                            initDoc();
                        }
                    }
                };
                var listUsers = function(board) {
                    Trello.get("/boards/" + board, {members: "all"}, function(board) {
                        //$("#select_members,#select_members2").empty();
                        var strx = '<option value="0">tugaskan kepada</option>';
                        $.each(board.members, function(i, item) {
                            strx += '<option value="' + item.id + '">' + item.fullName + '</option>';
                            //console.log( "Fullname : " + item.fullName+'</option>'; +' ID: '+item.id);
                        });
                        strx += "";
                        $("#select_members").html(strx);
                        //alert(strx);
                        //console.log(strx);
                    });
                }
                var GetNotifications = function() {
                }
                var listBoards = function() {
                    if (!myself.orgBoards) { // Not initiated yet
                        var categories = _.groupBy(myself.boards, function(board) { // Categories Boards
                            var id = board.idOrganization ? board.idOrganization : "";
                            return id;
                        });
                        var orgList = _.groupBy(myself.organizations, function(org) { // Map orgId-orgName
                            return org.id;
                        });
                        myself.orgBoards = _.map(categories, function(value, key) { // Create Array of Organizations containing Array of Boards
                            var list = {};
                            list.boards = value;
                            if (key === "" || key === null) {
                                list.name = "Personal";
                            } else if (!orgList.hasOwnProperty(key)) {
                                list.name = "External Organization";
                            } else {
                                list.name = orgList[key][0].displayName
                            }
                            return list;
                        });
                    }
                    $("#view").empty();
                    var intro = "";
                    var __idMember = '';
                    var template = "<h1>{{fullName}} ({{username}})</h1><div id='boardlist'>" + intro + "{{#orgBoards}}<div class='list'><h2>{{name}}</h2><ul>{{#boards}}<a href='#{{id}}' ><li>{{name}}</li></a>{{/boards}}</ul></div>{{/orgBoards}}</div>";
                    var str = Mustache.render(template, myself);
                    $("#view").html(str);
                    $("#boardlist").masonry({
                        itemSelector: '.list'
                    });
                };
                var getBoard = function(board) {
                    $("#view").empty();
                    $("#view").html("<h1 style='margin-left:30px;'>Loading ...</h1>");
                    Trello.get("/boards/" + board, {cards: "open", lists: "open", checklists: "all", members: "all", comments: "all"}, function(board) {
                        $("#view").html("<h1>Loading ...OK!!</h1>");
                        window.doc = board; //debug
                        window.title = board.name;
                        _.each(board.cards, function(card) { //iterate on cards
                            _.each(card.idChecklists, function(listId) { //iterate on checklists
                                var list = _.find(board.checklists, function(check) { //Find list
                                    return check.id == listId;
                                });
                                if (!list) {
                                    console.log("ERROR:" + listId + " not found");
                                    return;
                                }
                                list.doneNumber = 0;
                                list.totalNumber = list.checkItems.length || 0;
                                _.each(list.checkItems, function(item) { //Check complete
                                    item.complete = _.find(card.checkItemStates, function(state) {
                                        if (state.idCheckItem == item.id && state.state == "complete")
                                        {
                                            list.doneNumber++;
                                            return true;
                                        }
                                        return false;
                                    });
                                });
                                list.done = (list.doneNumber == list.totalNumber);
                                var template = "<div><b>{{name}}</b> <span class='show right {{#done}}green{{/done}}'>{{doneNumber}}/{{totalNumber}}</span></div><ul>{{#checkItems}}<li>{{#complete}}<del>{{/complete}}{{name}}{{#complete}}</del>{{/complete}}</li>{{/checkItems}}</ul>";
                                var str = Mustache.render(template, list);
                                card.checklist = card.checklist || []; //Make array
                                card.checklist.push(str);
                            }); //iterate on checklists
                            card.members = _.map(card.idMembers, function(id) { // iterate on members
                                var member = _.find(board.members, function(m) {
                                    return m.id == id;
                                });
                                return member.username;
                            }); // iterate on members
                        }); //iterate on cards
                        // Second Init Cards
                        var listofcards = _.groupBy(board.cards, function(card) {
                            return card.idList;
                        });
                        _.each(board.lists, function(list) {
                            list.cards = listofcards[list.id];
                            list.size = list.cards ? list.cards.length : 0;
                            list.show = (list.size > 0);
                        });
                        //console.log(board);
                        // Date function
                        board.formatDate = function() {
                            return function(text) {
                                var date;
                                switch (text) {
                                    case "":
                                        return "None";
                                    case "now":
                                        date = new Date();
                                        break;
                                    default:
                                        date = new Date(text);
                                }
                                return date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
                            };
                        };
                        board.formatComments = function() {
                            var converter = new Showdown.converter();
                            return converter.makeHtml;
                        };
                        //members
                        //
                        // Start Rendering
                        board.displayColumns = ["Name", "Members"];
                        var htmltemplate = "<h1>\n\
                                    <span id='board-name' alt='{{id}}'>{{name}}</span>\n\
                             </h1>\n\
                                {{#lists}}\n\
                                <div class='span5 papan'>\n\
                        <div>\n\
                            <caption alt='{{size}}'><h2><span class='title'>{{name}}</span><span class='show-count right'>{{size}}</span></h2></caption>\n\
                            <ul class='listx' id='{{id}}' title='doubleklik untuk melihat komentar'>\
                            {{#cards}}\n\
                                    <li class='drag' id='{{id}}' alt='{{name}}'>\n\
                                          <span class='card-name'><b>{{name}}</b></span>\n\
                                          <span class='members'>{{#members}}&nbsp;{{.}}{{/members}}</span>\n\
                                          <span class='members'>{{#comments}}lala{{.}}{{/comments}}</span>\n\
                                    </li>\n\
                            {{/cards}}\n\
                            </ul>\n\
                        </div>\n\
                        <span class='add_card btn btn-secondary' id='{{id}}' style='margin:5px;'>add card</span>\n\
                        </div>{{/lists}}";
                        var csvtemplate = ""; //TODO
                        listUsers(location.hash.replace("#", ""));
                        var str = Mustache.render(htmltemplate, board);
                        $("#view").html(str);
                        $(".drag").draggable({
                            drag: function() {
                                $(this).css({
                                    "z-index"           : "30000",
                                    "transform"         : "rotate(3deg)",
                                    "-moz-transform"    : "rotate(3deg)",
                                    "-webkit-transform" : "rotate(3deg)",
                                    "background-color"  : "#834FFF",
                                    "color"             : "#fff"
                                });
                            }
                        });
                        //cookie for list
                        var list_id = $(".listx:first").attr("id");
                        $.cookie('ctrello', list_id, {expires: 1000});
                        $(".listx").droppable({
                            drop: function(event, ui) {
                                var ___idList = $(this).attr("id");
                                var ___idCard = ui.draggable.attr("id");
                                //alert(draggableId+' mau dipindah ke '+droppableId);
                                Trello.put("cards/" + ___idCard, {
                                    idList: ___idList
                                }).done(function() {
                                    $("#" + ___idList).addClass("ui-state-highlight").delay(2000);
                                    router();
                                });
                                //
                            }
                        });
                        $(".drag").bind("dblclick", function() {
                            var idcard = $(this).attr("id");
                            var idboard = $('#board-name').attr("alt");
                            var nama = $(this).attr("alt");
                            var id = idboard + '_____' + idcard;
                            Trello.get("/card/" + idcard + "/?actions=commentCard", function(cxx) {
                                //console.log(cxx.actions);
                                var str = '<ul>';
                                $.each(cxx.actions, function(ix, cx) {
                                    str += '<li><b>' + cx.memberCreator.fullName + '</b> : ' + cx.data.text + ' ....... on <b>' + cx.date.substr(0, 10).replace('T', ' ') + '</b></li>';
                                });
                                str += '</ul>';
                                //console.log(str);
                                $("#trello_detail_info").html(str);
                                $("#form_komentar").show(100);
                                $("#trello_detail").attr("title", "Comments")
                                        .dialog({
                                    modal: true,
                                    width: 600,
                                    height: 400,
                                    buttons: {
                                        "tutup": function() {
                                            $(this).dialog("close");
                                        },
                                        "Kirim Komentar": function() {
                                            var vcm = $("#text").val();
                                            if (vcm == '') {
                                                alert("isian komentar belum diisi");
                                            } else {
                                                Trello.post("cards/" + idcard + "/actions/comments", {text: vcm});
                                                $("#text").val("");
                                                alert("komentar berhasil diposting!");
                                                $("#trello_detail").dialog("close");
                                            }
                                        }
                                    }
                                });
                            });
                        });
                        $(".add_card").click(function() {
                            var ___idList = $(this).attr("id");
                            $("#form_card").dialog({
                                modal: true,
                                width: 600,
                                height: 400,
                                resizable: false,
                                buttons: {
                                    "Submit": function() {
                                        var ___name = $("#_namecard").val();
                                        var ___desc = $("#_desccard").val();
                                        var ___idMembers = $("#select_members").val();
                                        $("#form_card").html("processing................<br><br><br>Sistem sedang memproses data<br> jangan refresh halaman ini<br><br>tunggu sampai keluar pesan berhasil!");
                                        Trello.post("cards", {
                                            name: ___name,
                                            desc: ___desc,
                                            idList: ___idList,
                                            idMembers: ___idMembers
                                        })
                                                .done(
                                                function(card) {
                                                    var __CID = card.id;
                                                    Trello.post("cards/" + __CID + "/" + ___idMembers);
                                                    alert('card berhasil diposting!');
                                                    $("#form_card").dialog("close");
                                                    $("#_namecard").val('');
                                                    router();
                                                    window.location.reload(true);
                                                });
                                    },
                                    "Batalkan": function() {
                                        $("#form_card").dialog("close");
                                        $("#_namecard").val('');
                                    }
                                }
                            });
                        });
                        $(".select_members2").change(function() {
                            var idMember = $(this).val();
                            var idList = $(this).attr("alt");
                            //alert(idList+'----------'+idMember);
                            Trello.post("cards/" + idList + "/" + idMember);
                            router();
                        });
                        // Download Button
                        var download = "<!DOCTYPE html><html><head><meta charset='utf-8' /><title>" + board.name + "</title><style>" + $("style").text() + "</style></head><body>" + str + "</body></html>";
    //this may work for firefox using application/data
    //location.href="data:text/html;charset=utf-8,"+encodeURIComponent(download);
                        //button.click(function(){location.href="data:text/html;charset=utf-8,"+encodeURIComponent(download);});
                    });
                };
            </script>
            <?php } ?>
        <?php } ?>      
    <?php
    if(isset($jsIncludes))
    {
        foreach($jsIncludes as $js)
        {
            echo $this->Javascript->link($js);
        }
    }
    ?>                        
    </head>
    <?php
    $bodyClass = str_replace($this->webroot, '', $this->here);
    $bodyClass = str_replace('/', '-', $bodyClass);
    ?>
    <body class="<?php echo $bodyClass; ?> gray-bg">
    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">IN+</h1>
            </div>
            <h3>Welcome to IN+</h3>
            <p>Perfectly designed and precisely prepared admin theme with over 50 pages with extra new web app views.
                <!--Continually expanded and constantly improved Inspinia Admin Them (IN+)-->
            </p>
            <p><?php echo $this->Session->flash();?></p>
            <?php echo $content_for_layout; ?>
            <p class="m-t"> <small>Inspinia we app framework base on Bootstrap 3 &copy; 2014</small> </p>
        </div>
         <?php echo $this->element('sql_dump'); ?> 
    </div>
</body>
</html>