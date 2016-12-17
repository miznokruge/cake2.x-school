<?php echo $this->element('heading',array('title'=>'Permission Module','controller'=>'quote','action'=>array('index'))); ?>
<div class="row">
    <div class="col-sm-4">
        <div class="accordion" id="leftMenu">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                        <i class="icon-home"></i> BARUUUUU
                    </a>
                </div>
            </div>
            <?php
            foreach ($tampung as $s => $c) {
                if ($c['controller']['j'] > 0) {
                    ?>
                    <div class="accordion-group">
                        <div class="accordion-heading">
                            <div class="col-sm-5">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#<?php echo $c['controller']['name']; ?>2">
                                    <i class="icon-th-list"></i> <?php echo $c['controller']['name']; ?>
                                </a>
                            </div>
                            <div class="col-sm-7" style="font-size: 9px !important; padding-top: 5px;">
                                <?php
                                $actionn = '';
                                foreach ($c['action'] as $z => $a) {
                                    if ($a['status'] == 'new') {
                                        $actionn.= $a['alias'] . ' ';
                                    }
                                    rtrim($actionn);
                                }
                                if ($c['controller']['status'] == 'new') {
                                    echo '<span class="label label-success pull-right">Baru</span>';
                                    echo $this->Html->link("Buat Aco", array("action" => "run", '?' => 'controller=' . $c['controller']['name'] . '&a=' . $actionn), array("class" => "label label-important pull-right", "style" => "margin:0 3px; padding:3px; font-size:10px;"));
                                }
                                if ($c['controller']['j'] > 0) {
                                    echo '<span class="label label-warning pull-right" style="margin:0 3px;" title="' . $c['controller']['j'] . ' action baru">' . $c['controller']['j'] . '</span>';
                                }
                                ?>
                            </div>
                        </div>
                        <div id="<?php echo $c['controller']['name'];
                                ?>2" class="accordion-body collapse" style="height: 0px; ">
                            <div class="accordion-inner">
                                <ul>
                                    <?php foreach ($c['action'] as $z => $action) { ?>
                                        <li>
                                            <a href="<?php echo $this->webroot; ?><?php echo $c['controller']['name']; ?>/<?php echo $action['alias']; ?>" target="_blank">
                                                <?php echo $action['alias']; ?>
                                            </a>
                                            <?php
                                            if ($action['status'] == 'new') {
                                                echo '<span class="label label-success pull-right">New</span>';
                                                echo $this->Html->link("Buat aco", array("action" => "run", '?' => 'controller=' . $c['controller']['name'] . '&action=' . $action['alias']), array("class" => "btn btn-xs btn-danger", "style" => "margin:0 3px"));
                                            } else {
                                                echo $action['status'];
                                            }
                                            ?>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-4">
        <div class="accordion" id="leftMenu">
            <div class="accordion-group">
                <div class="accordion-heading">
                    <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#">
                        <i class="icon-home"></i> Semua ACO
                    </a>
                </div>
            </div>
            <?php
            foreach ($tampung as $s => $c) {
                ?>
                <div class="accordion-group">
                    <div class="accordion-heading">
                        <a class="accordion-toggle" data-toggle="collapse" data-parent="#leftMenu" href="#<?php echo $c['controller']['name']; ?>">
                            <i class="icon-th-list"></i> <?php echo $c['controller']['name']; ?>
                            <?php
                            if ($c['controller']['status'] == 'new') {
                                echo '<span class="label label-success pull-right" style="margin:0 4px;">controller baru</span>';
                                //echo $this->Html->link("run", array("action" => "run", '?' => 'controller=' . $c['controller']['name']), array("class" => "btn btn-xs pull-right"));
                            }
                            if ($c['controller']['j'] > 0) {
                                echo '<span class="label label-warning pull-right">' . $c['controller']['j'] . ' action baru</span>';
                            }
                            ?>
                        </a>
                    </div>
                    <div id="<?php echo $c['controller']['name']; ?>" class="accordion-body collapse" style="height: 0px; ">
                        <div class="accordion-inner">
                            <ul>
                                <?php foreach ($c['action'] as $z => $action) { ?>
                                    <li>
                                        <a href="<?php echo $this->webroot; ?><?php echo $c['controller']['name']; ?>/<?php echo $action['alias']; ?>" target="_blank">
                                            <?php echo $action['alias']; ?>
                                        </a>
                                        <?php
                                        if ($action['status'] == 'new') {
                                            echo '<span class="label label-success pull-right">New</span>';
                                            //echo $this->Html->link("run", array("action" => "run", '?' => 'controller=' . $c['controller']['name'] . '&action=' . $action['alias']), array("class" => "btn btn-xs btn-danger"));
                                        } else {
                                            echo $action['status'];
                                        }
                                        ?>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
    <div class="col-sm-4">
        RAW
        <pre>
            <?php
            print_r($tampung);
            ?>
        </pre>
    </div>
</div>
<style>
    #leftMenu .accordion-group {
        margin-bottom: 0px;
        border:0px;
        -webkit-border-radius: 0px;
        -moz-border-radius: 0px;
        border-radius: 0px;
    }
    #leftMenu .accordion-heading {
        height: 34px;
        border-top: 1px solid #717171; /* inner stroke */
        border-bottom: 1px solid #5A5A5A; /* inner stroke */
        background-image: -moz-linear-gradient(90deg, #595b59 0%, #616161 100%); /* gradient overlay */
        background-image: -o-linear-gradient(90deg, #595b59 0%, #616161 100%); /* gradient overlay */
        background-image: -webkit-linear-gradient(90deg, #595b59 0%, #616161 100%); /* gradient overlay */
        background-image: linear-gradient(90deg, #595b59 0%, #616161 100%); /* gradient overlay */
        list-style-type:none;
    }
    #leftMenu .accordion-heading  a{
        color: #cbcbcb; /* text color */
        text-shadow: 0 1px 0 #3b3b3b; /* drop shadow */
        text-decoration:none;
        font-weight:bold;
        display: inline;
        margin-top:3px;
    }
    #leftMenu .accordion-heading  a:hover{
        color:#ccc
    }
    #leftMenu .accordion-heading .active {
        width: 182px;
        height: 34px;
        border: 1px solid #5b5b5b; /* inner stroke */
        background-color: #353535; /* layer fill content */
        background-image: -moz-linear-gradient(90deg, #4b4b4b 0%, #555 100%); /* gradient overlay */
        background-image: -o-linear-gradient(90deg, #4b4b4b 0%, #555 100%); /* gradient overlay */
        background-image: -webkit-linear-gradient(90deg, #4b4b4b 0%, #555 100%); /* gradient overlay */
        background-image: linear-gradient(90deg, #4b4b4b 0%, #555 100%); /* gradient overlay */
    }
</style>
