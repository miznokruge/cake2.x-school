<?php

/**
 * Helper for rendering JQuery Treegrid
 * Author : Mizno Kruge
 * Copyright Tricipta Media Perkasa
 */
class TreegridHelper extends Helper {

    //render Chart of Accounts tree representation
    public function renderCoas(array $data, $parent_id = NULL) {
        $tmp = '';
        if ($parent_id) {
            $parent_id = 'treegrid-parent-' . $parent_id;
        }
        foreach ($data as $dt) {
            //die( debug($dt) );
            $tmp .= '<tr class="treegrid-' . $dt['Coa']['id'] . ' ' . $parent_id . '" data-key="' . $dt['Coa']['id'] . '" >';

            $tmp .= '<td>' . $dt['Coa']['code'] . '</td>';

            if ((int) $dt['Coa']['tipe_rekening'] === 0)
                $tmp .= '<td><strong>' . $dt['Coa']['name'] . '</strong></td>';
            else
                $tmp .= '<td>' . $dt['Coa']['name'] . '</td>';
            //$tmp .= '<td>'.$dt['Coa']['keterangan'].'</td>';
            switch ((int) $dt['Coa']['tipe_rekening']) {
                case 0:
                    $tmp .= '<td style="text-align:right;"><div class="label label-danger">Header</div></td>';
                    break;
                case 1:
                    $tmp .= '<td style="text-align:right;"><div class="label label-info">Detail</div></td>';
                    break;
                default:
                    $tmp .= '<td style="text-align:right;"><div class="label label-default">Tidak diketahui</div></td>';
                    break;
            }

            //render Actions Column
            $tmp .= '<td style="text-align:right;" data-key="' . $dt['Coa']['id'] . '">';
            $tmp .= '<a class="btn btn-mini" href="' . $this->webroot . 'coas/account?parent=' . $dt['Coa']['id'] . '">Add Child</a>';
            $tmp .= '<a class="btn btn-mini" href="' . $this->webroot . 'coas/account/' . $dt['Coa']['id'] . '">Edit</a>';
            $tmp .= '<form style="display:inline;" method="POST" action="' . $this->webroot . 'coas/remove/' . $dt['Coa']['id'] . '"><a class="btn btn-mini btn-remove">Remove</a></form>';
            $tmp .= '</td>';

            $tmp .= '</tr>';

            //render childs
            if (count($dt['children']) > 0) {
                $tmp .= $this->renderCoas($dt['children'], $dt['Coa']['id']);
            }
        }

        return $tmp;
    }

    public function renderPermissions(array $data, $allowed_acos, $emm, $parent_id = NULL) {


        $tmp = '';
        if ($parent_id) {
            $parent_id_var = 'treegrid-parent-' . $parent_id;
        } else {
            $parent_id_var = 0;
        }
        foreach ($data as $dt) {
            if ($parent_id) {
                $is_parent = 'action';
                $name = $dt['Aco']['alias'];
            } else {
                $name = '';
                $is_parent = 'parent';
                $name = $dt['Aco']['alias'];
            }
            //die(debug($allowed_acos));
            $tmp .= '<tr class="treegrid-' . $dt['Aco']['id'] . ' ' . $parent_id_var . '" data-key="' . $dt['Aco']['id'] . '" >';

            $tmp .= '<td>' . $dt['Aco']['id'] . '</td>';
            if (strpos($emm[$dt['Aco']['id']], "/") == false) {
                #parent
                $alias = $dt['Aco']['alias'];
            } else {
                $alias = str_repeat('&nbsp;', 20) . $dt['Aco']['alias'];
            }
            $tmp .= '<td>' . $alias . '</td>';
            //render Actions Column
            $tmp .= '<td style="text-align:right;" data-key="' . $dt['Aco']['id'] . '">';
            //$tmp.='(' . $allowed_acos[$dt['Aco']['id']]['id'] . '---' . $dt['Aco']['id'] . ')';
            if (isset($allowed_acos[$dt['Aco']['id']]) && $allowed_acos[$dt['Aco']['id']]['id'] == $dt['Aco']['id']) {
                $cek = 'checked="checked"';
            } else {
                $cek = '';
            }

            $tmp .= '<input type="checkbox" class="cb" value="' . $dt['Aco']['alias'] . '" id="' . str_replace("/", "__", $emm[$dt['Aco']['id']]) . '"  ' . $cek . '/>
                </td>';
            $tmp .= '<td>' . $is_parent . '</td>';
            $tmp.='<td>
                <label id="message__' . str_replace("/", "__", $emm[$dt['Aco']['id']]) . '"></label>';
            $tmp .= '</td>';
            $tmp .= '</tr>';
            //render childs
            if (count($dt['children']) > 0) {
                $tmp .= $this->renderPermissions($dt['children'], $allowed_acos, $emm, $dt['Aco']['id']);
            }
        }

        return $tmp;
    }

}
