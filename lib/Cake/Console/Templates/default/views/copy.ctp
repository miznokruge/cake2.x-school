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
    <div class="col-md-10">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php printf("<?php echo __('%s %s'); ?>", Inflector::humanize($action), $singularHumanName); ?></h3>
            </div>
            <div class="panel-body">
                <div class="<?php echo $pluralVar; ?> form">
                    <?php echo "<?php
                    echo \$this->Form->create('{$modelClass}', array(
                        'inputDefaults' => array(
                            'div' => 'form-group',
                            'wrapInput' => false,
                            'class' => 'form-control'
                        ),
                        'class' => ''
                    ));
                    ?>\n"; ?>
                    <?php
                    echo "\t<?php\n";
                    foreach ($fields as $field) {
                        if ((strpos($action, 'add') !== false || strpos($action, 'copy') !== false) && $field === $primaryKey) {
                            continue;
                        } elseif (!in_array($field, array('created', 'created_by', 'modified_by', 'modified', 'updated', 'deleted', 'deleted_date', 'deleted_by'))) {
                            echo "\t\techo \$this->Form->input('{$field}');\n";
                        }
                    }
                    if (!empty($associations['hasAndBelongsToMany'])) {
                        foreach ($associations['hasAndBelongsToMany'] as $assocName => $assocData) {
                            echo "\t\techo \$this->Form->input('{$assocName}');\n";
                        }
                    }
                    echo "\t?>\n";
                    echo "<?php echo \$this->Form->submit(__('Submit'), array('class' => 'btn btn-primary btn-lg', 'div' => 'col-sm-12', 'style' => 'margin-top:10px;')); ?>";
                    echo "<?php echo \$this->Form->end(); ?>\n";
                    ?>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-2">
        <div class="panel">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo "<?php echo __('Actions'); ?>"; ?></h3>
            </div> <!-- /panel-header -->
            <div class="panel-body">
                <?php echo "<?php echo \$this->Html->link(__('<i class=\"icon icon-chevron-left\"></i> Back to Index'), array('action' => 'index'),array('class'=>'btn btn-block btn-primary','escape'=>false)); ?> </li>\n"; ?>
                <ul class="nav nav-list nav-stacked">
                    <?php if (strpos($action, 'add') === false): ?>
                        <li><?php echo "<?php echo \$this->Form->postLink(__('<i class=\"icon icon-trash\"></i> Delete'), array('action' => 'delete', \$this->Form->value('{$modelClass}.{$primaryKey}')),array('escape'=>false), __('Are you sure you want to delete # %s?', \$this->Form->value('{$modelClass}.{$primaryKey}'))); ?>"; ?></li>
                    <?php endif; ?>
                    <li><?php echo "<?php echo \$this->Html->link(__('<i class=\"icon icon-th-list\"></i> List " . $pluralHumanName . "'), array('action' => 'index'),array('escape'=>false)); ?>"; ?></li>
                    <?php
                    $done = array();
                    foreach ($associations as $type => $data) {
                        foreach ($data as $alias => $details) {
                            if ($details['controller'] != $this->name && !in_array($details['controller'], $done)) {
                                echo "\t\t<li><?php echo \$this->Html->link(__('<i class=\"icon icon-th-list\"></i> List " . Inflector::humanize($details['controller']) . "'), array('controller' => '{$details['controller']}', 'action' => 'index'),array('escape'=>false)); ?> </li>\n";
                                echo "\t\t<li><?php echo \$this->Html->link(__('<i class=\"icon icon-th-list\"></i> New " . Inflector::humanize(Inflector::underscore($alias)) . "'), array('controller' => '{$details['controller']}', 'action' => 'add'),array('escape'=>false)); ?> </li>\n";
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
