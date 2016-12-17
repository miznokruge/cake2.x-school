<div class="panel">
        <div class="panel-heading">
            <h3 class="panel-title"><?php echo __('User Group Permissions'); ?></h3>
        </div>
        <div class="panel-body">
        <?php
echo $this->Html->script('/js/umupdate');
?>
<div class="row">    
        <div class="col-sm-12" id="permissions">
            <?php if (!empty($controllers)) { ?>
                <input type="hidden" id="BASE_URL" value="<?php echo SITE_URL ?>">
                <input type="hidden" id="groups" value="<?php echo $groups ?>">
                <table cellspacing="0" cellpadding="0" width="100%" border="0">
                    <thead>
                        <tr>
                            <th> <?php echo __("Controller"); ?> </th>
                            <th> <?php echo __("Action"); ?> </th>
                            <th> <?php echo __("Permission"); ?> </th>
                            <th> <?php echo __("Operation"); ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $k = 1;
                        foreach ($controllers as $key => $value) {
                            if (!empty($value)) {
                                for ($i = 0; $i < count($value); $i++) {
                                    if (isset($value[$i])) {
                                        $action = $value[$i];
                                        echo $this->Form->create();
                                        echo $this->Form->hidden('controller', array('id' => 'controller' . $k, 'value' => $key));
                                        echo $this->Form->hidden('action', array('id' => 'action' . $k, 'value' => $action));
                                        echo "<tr>";
                                        echo "<td>" . $key . "</td>";
                                        echo "<td>" . $action . "</td>";
                                        echo "<td>";
                                        foreach ($user_groups as $user_group) {
                                            $ugname = $user_group['name'];
                                            $ugname_alias = $user_group['alias_name'];
                                            if (isset($value[$action][$ugname_alias]) && $value[$action][$ugname_alias] == 1) {
                                                $checked = true;
                                            } else {
                                                $checked = false;
                                            }
                                            echo $this->Form->input($ugname, array('id' => $ugname_alias . $k, 'type' => 'checkbox', 'checked' => $checked));
                                        }
                                        echo "</td>";
                                        echo "<td>";
                                        echo $this->Form->button('Update', array('type' => 'button', 'id' => 'mybutton123', 'name' => $k, 'onClick' => 'javascript:update_fields(' . $k . ');', 'class' => 'umbtn'));
                                        echo "<div id='updateDiv" . $k . "' align='right' class='updateDiv'>&nbsp;</div>";
                                        echo "</td>";
                                        echo "</tr>";
                                        echo $this->Form->end();
                                        $k++;
                                    }
                                }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <?php
            } else {
                ?>
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th> <?php echo __("No"); ?> </th>
                            <th> <?php echo __("Controller"); ?> </th>
                            <th> <?php echo __("View"); ?> </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        for ($i = 1; $i <= count($allControllers) - 2; $i++) {
                            ?>
                            <tr>
                                <td><?php echo $i;?></td>
                                <td><a href="<?php echo SITE_URL . "user_group_permissions/?c=" . $i; ?>"><?php echo $allControllers[$i]; ?></a></td>
                                <td><a href="<?php echo SITE_URL . "user_group_permissions/?c=" . $i; ?>" class="btn btn-default btn-xs">
                                        <i class="icon icon-eye-open"></i>
                                        View
                                    </a></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <?php
            }
            ?>
        </div>
    </div>
</div>
</div>
<style>
    .checkbox{
        float: left;
        margin-right: 10px;
        width:80px;
    }
</style>