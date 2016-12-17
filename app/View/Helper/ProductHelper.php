<?php

/**
 * ProductHelper is 
 *
 * @author CRM
 * @since May 16, 2012
 * Copyright "PT Tricipta Media Perkasa" all rights reserved
 */
class ProductHelper extends Helper{
    public function __construct(View $view, $settings = array()){
        parent::__construct($view, $settings);
    }

    public function create_component($row, $asl = null, $product_id = null){
        echo '<label for="id_'.strtolower($row['attributes']['attribute_name']).'">'.$row['attributes']['attribute_name'].'</label>';
        if(strtolower($row['datatypes']['data_type_name']) == 'string'){
            echo '<input type="text" id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'].'" />';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'text'){
            echo '<textarea id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" rows="4">'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'].'</textarea>';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'integer'){
            echo '<input type="number" id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'].'" />';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'decimal'){
            echo '<input type="text" id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" class="auto" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'].'" />';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'float'){
            echo '<input type="text" id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'].'" />';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'double'){
            echo '<input type="text" id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'].'" />';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'boolean'){
            echo '<select id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" />
                    <option value="1" '.($asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'] == 1 ? 'selected' : '').'>Ya</option>
                    <option value="0" '.($asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'] == 0 ? 'selected' : '').'>Tidak</option>
                </select>
            ';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'multiple_select'){
            $values = explode(',', $row['attributes']['attribute_def_value']);
            echo '<select multiple size="5" class="mtsl" id="id_'.strtolower($row['attributes']['attribute_name']).'">';
            echo '<option value=""></option>';
            foreach ($values as $val) {
                echo '<option value="'.$val.'" '.(strpos($asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'], $val) !== false ? 'selected' : '').'>'.$val.'</option>';
            }
            echo '</select>';
            echo '<input type="hidden" id="res_id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'].'" />';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
        else if(strtolower($row['datatypes']['data_type_name']) == 'dropdown'){
            $values = explode(',', $row['attributes']['attribute_def_value']);
            echo '<select id="id_'.strtolower($row['attributes']['attribute_name']).'" name="data[asl][value][]">';
            echo '<option value=""></option>';
            foreach ($values as $val) {
                echo '<option value="'.$val.'" '.($val == $asl[$product_id][strtolower($row['attributes']['attribute_name'])]['value'] ? 'selected' : '').'>'.$val.'</option>';
            }
            echo '</select>';
            echo '<input type="hidden" name="data[asl][vid][]" value="'.$asl[$product_id][strtolower($row['attributes']['attribute_name'])]['id'].'" />';
            echo '<input type="hidden" name="data[asl][id][]" value="'.$row['attributes']['id'].'" />';
            echo '<input type="hidden" name="data[asl][dttp][]" value="Attribute_'.strtolower($row['datatypes']['data_type_name']).'_value" />';
        }
    }

    public function categoryName($category_id)
    {
        if (! is_numeric($category_id)) return False;

        $Category = ClassRegistry::init('Procategory');
        $row = $Category->find('first',array(
            'conditions'    =>  array(
                'Procategory.id'    =>  $category_id
            )
        ));

        return  ( !empty($row) ) ? $row : null;
    }
}