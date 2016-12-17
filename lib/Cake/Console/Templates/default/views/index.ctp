<?php
/**
 *
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.Console.Templates.default.views
 * @since         CakePHP(tm) v 1.2.0.5234
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel">
            <div class="panel-heading">
                <div class="panel-control">
<!--                    <button data-toggle="collapse" data-target="#demo-panel-collapse" class="btn btn-default"><i class="fa fa-chevron-down"></i></button>
                    <button data-dismiss="panel" class="btn btn-default"><i class="fa fa-times"></i></button>-->
                    <a title="" data-html="true" data-original-title="&lt;h4 class='text-thin'&gt;Information&lt;/h4&gt;&lt;p style='width:150px'&gt;This is an information bubble to help the user.&lt;/p&gt;" href="#" class="fa fa-question-circle fa-lg fa-fw unselectable add-tooltip"></a>
                </div>
                <h3 class="panel-title"><?php echo "<?php echo __('{$pluralHumanName}'); ?>"; ?></h3>
            </div>
            <div class="panel-body">
                <div class="pad-btm form-inline">
                    <div class="row">
                        <div class="col-sm-6 table-toolbar-left">
                            <?php echo "<?php echo \$this->Html->link('<i class=\"fa fa-plus\"></i>',array('action'=>'add'),array('class'=>'btn btn-success','escape'=>false));?>"; ?>
                            <a href="#" class="btn btn-primary print-btn" alt=""><i class="fa fa-print"></i></a>
                            <div class="btn-group">
                                <button class="btn btn-default"><i class="fa fa-exclamation-circle"></i></button>
                                <button class="btn btn-default"><i class="fa fa-trash"></i></button>
                            </div>
                        </div>
                        <div class="col-sm-6 table-toolbar-right">
                            <div class="form-group">
                                <?php
                                echo "<?php echo \$this->Form->create('{$modelClass}',array('type'=>'get','style'=>'margin:5px auto;','action'=>'index'));?>";
                                ?>
                                <div class="input-group custom-search-form" style="margin-top: -5px;">
                                    <input type="text" class="form-control" name="search" placeholder="search" value="<?php echo '<?php echo $search_term;?>'; ?>">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default" type="submit">
                                            <i class="fa fa-search"></i>
                                        </button>
                                    </span>
                                </div>
                                <?php echo '<?php echo $this->Form->end();?>'; ?>
                            </div>
                            <div class="btn-group">
                                <?php echo "<?php echo \$this->Html->link('<i class=\"icon icon-refresh\"></i> View All',array('action'=>'index'),array('class'=>'btn btn-default','escape'=>false));?>"; ?>
                                <div class="btn-group">
                                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown">
                                        <i class="fa fa-cog"></i>
                                        <span class="caret"></span>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-right" role="menu">
                                        <li><a href="#">Action</a></li>
                                        <?php
                                        $done = array();
                                        foreach ($associations as $type => $data) {
                                            foreach ($data as $alias => $details) {
                                                if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                                                    echo "\t\t<li><?php echo \$this->Html->link(__('List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index')); ?> </li>\n";
                                                    echo "\t\t<li><?php echo \$this->Html->link(__('New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add')); ?> </li>\n";
                                                    $done[] = $details['controller'];
                                                }
                                            }
                                        }
                                        ?>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <?php
                                $h = 0;
                                foreach ($fields as $field):
                                    ?>
                                    <?php
                                    if ($h <= 8) {
                                        if ($field != 'deleted') {
                                            ?>
                                            <th><?php echo "<?php echo \$this->Paginator->sort('{$field}'); ?>"; ?></th>
                                            <?php
                                        }
                                    }
                                    ?>
                                    <?php
                                    $h++;
                                endforeach;
                                ?>
                                <th class="actions"><?php echo "<?php echo __('Actions'); ?>"; ?></th>
                            </tr>
                        </thead>
                        <?php
                        echo "<tbody><?php foreach (\${$pluralVar} as \${$singularVar}): ?>\n";
                        echo "\t <tr>\n";
                        $i = 0;
                        foreach ($fields as $field) {
                            if ($i <= 8) {
                                if ($field != 'deleted') {
                                    $isKey = false;
                                    if (!empty($associations['belongsTo'])) {
                                        foreach ($associations['belongsTo'] as $alias => $details) {
                                            if ($field === $details['foreignKey']) {
                                                $isKey = true;
                                                echo "\t\t<td>\n\t\t\t<?php echo \$this->Html->link(\${$singularVar}['{$alias}']['{$details['displayField']}'], array('controller' => '{$details['controller']}', 'action' => 'view', \${$singularVar}['{$alias}']['{$details['primaryKey']}'])); ?>\n\t\t</td>\n";
                                                break;
                                            }
                                        }
                                    }
                                    if ($isKey !== true) {
                                        echo "\t\t<td><?php echo h(\${$singularVar}['{$modelClass}']['{$field}']); ?>&nbsp;</td>\n";
                                    }
                                }
                            }
                            $i++;
                        }
                        echo "\t\t<td class=\"actionsx\">\n";
                        echo "\t\t\t<?php echo \$this->Html->link(__('<i class=\"fa fa-eye\"></i>'), array('action' => 'view', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('escape' => false,'title'=>'view details','class'=>'btn btn-default btn-sm')); ?>\n";
                        echo "\t\t\t<?php echo \$this->Html->link(__('<i class=\"fa fa-copy\"></i>'), array('action' => 'copy', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('escape' => false,'title'=>'copy','class'=>'btn btn-default btn-sm')); ?>\n";
                        echo "\t\t\t<?php echo \$this->Html->link(__('<i class=\"fa fa-edit\"></i>'), array('action' => 'edit', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('escape' => false,'title'=>'edit this record','class'=>'btn btn-default btn-sm')); ?>\n";
                        echo "\t\t\t<?php echo \$this->Form->postLink(__('<i class=\"fa fa-trash\"></i>'), array('action' => 'delete', \${$singularVar}['{$modelClass}']['{$primaryKey}']),array('escape' => false,'title'=>'delete this record','class'=>'btn btn-default btn-sm'), __('Are you sure you want to delete # %s?', \${$singularVar}['{$modelClass}']['{$primaryKey}'])); ?>\n";
                        echo "\t\t</td>\n";
                        echo "\t</tr>\n";
                        echo "<?php endforeach; ?>\n</tbody>";
                        ?>
                    </table>
                </div>
                <div class="row">
                    <div class="col-md-5 col-lg-offset-1">
                        <?php echo '<?php
            echo $this->Paginator->pagination(array(
                "ul" => "pagination"
            ));
            ?>'; ?>
                    </div>
                    <div class="col-md-6" style="margin-top:30px;">
                        <?php echo "<?php
	echo \$this->Paginator->counter(array(
	'format' => __('Page {:page} of {:pages}, showing {:current} records out of {:count} total, starting on record {:start}, ending on {:end}')
	));
	?>"; ?></div>
                </div>
            </div>

        </div>
    </div>
</div>
