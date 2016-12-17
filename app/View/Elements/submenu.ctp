<?php if( !empty($parent['Menu']['controller']) ):?>	
<li>                
	<?php
	$divContent = '<div class="button_menu">
		<p style="font-size:36px;" class="'.$parent['Menu']['icon'].'"></p>                           
		<p>'.$parent['Menu']['label'].'</p>
	</div>';
	echo $this->Html->link($divContent, array('controller' => $parent['Menu']['controller'],'action' => $parent['Menu']['action'])
			, array('escape' => false));
	?>					
</li>			
<?php endif;?>
<?php foreach($sub_menus as $sub):?>
	<li>                
        <?php
        $divContent = '<div class="button_menu">
            <p style="font-size:36px;" class="'.$sub['Menu']['icon'].'"></p>                           
            <p>'.$sub['Menu']['label'].'</p>
        </div>';
        echo $this->Html->link($divContent, array('controller' => $sub['Menu']['controller'],'action' => $sub['Menu']['action'])
                , array('escape' => false));
        ?>					
    </li>
<?php endforeach;?>