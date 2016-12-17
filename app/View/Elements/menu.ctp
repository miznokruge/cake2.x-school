<br/>
<div class="row">
    <div class="col-sm-12">
        <?php
        $html = '';
        ?>
        <ul class="nav nav-tabs">
            <?php foreach ($menus as $menu): ?>
                <li>
                    <a data-toggle="tab" href="#tab-<?php echo str_replace(' ', '-', strtolower($menu['Menu']['name'])); ?>"><i class="fa <?php echo $menu['Menu']['icon']; ?>"></i> <?php echo ucwords($menu['Menu']['name']); ?></a>
                    <?php
                    if (count($menu['children']) > 0):
                        $html .= '<div id="tab-' . str_replace(' ', '-', strtolower($menu['Menu']['name'])) . '" class="tab-pane">';
                        $html .= '<div style="height:300px">';
                        foreach ($menu['children'] as $mc):
                            $html .= '';
                            $html .= $this->Html->linkSkipAcl(ucwords(str_replace("-", " ", $mc['Menu']['name'])), array('controller' => $mc['Menu']['controller'], 'action' => $mc['Menu']['action'])
                                    , array('escape' => false, 'class' => 'btn btn-primary btn-xs'));
                            if (count($mc['children']) > 0) {
                                $html .= '<ul>';
                                foreach ($mc['children'] as $c) {
                                    $html .= '<li>';
                                    $html .= $this->Html->linkSkipAcl(ucwords(str_replace("-", " ", $c['Menu']['name'])), array('controller' => $c['Menu']['controller'], 'action' => $mc['Menu']['action'])
                                            , array('escape' => false));
                                    $html .= '<ul class="nav nav-third-level collapse in" style="height: auto;">';
                                    foreach ($c['children'] as $menu_level_tiga) {
                                        $html .= '<li>';
                                        $html .= '<a href = "#">' . $menu_level_tiga['Menu']['name'] . '</a>';
                                        $html .= '</li>';
                                    }
                                    $html .= '</ul>';
                                    $html .= '</li>';
                                }
                                $html .= '</ul>';
                            }else{
                                $html .= $this->Html->linkSkipAcl(ucwords(str_replace("-", " ", $c['Menu']['name'])), array('controller' => $c['Menu']['controller'], 'action' => $mc['Menu']['action'])
                                            , array('escape' => false));
                            }
                            $html .= '</>';
                        endforeach;
                        $html .= '</div>';
                        $html .= '</div>';
                    else:
                        $html .= $this->Html->linkSkipAcl(ucwords(str_replace("-", " ", $c['Menu']['name'])), array('controller' => $c['Menu']['controller'], 'action' => $mc['Menu']['action'])
                                , array('escape' => false));
                    endif;
                    ?>
                </li>
            <?php endforeach; ?>
        </ul>
        <div class="tab-content">
            <?php echo $html; ?>
        </div>
    </div>
</div>