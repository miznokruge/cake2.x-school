<?php

/**
 * StateboxHelper is
 *
 * @author Mizno Kruge
 * @since May 28, 2012
 * Copyright "PT Tricipta Media Perkasa" all rights reserved
 */
class StateboxHelper extends Helper {

    var $Util;

    public function __construct(View $view, $settings = array()) {
        parent::__construct($view, $settings);
        // Do other initialization here
        App::import('Component', 'Util');
        $this->Util = new UtilComponent(new ComponentCollection());
    }

    public function create($orderId) {
        $currentStateId = $this->Util->getCurrentState($orderId);
        $states = $this->Util->getAllStates();
        $normalFlow = $this->getNormalFlow($states);

        $status = 'done';
        $sbHtml = '<div class="stateboxes">';
        foreach ($normalFlow as $state) {
            if ($state['id'] == $currentStateId) {
                $status = 'btn-danger';
            }
            $sbHtml .= '<div class="btn ' . $status . '">' .
                    '<span class="bubble">' .
                    '<p>' .
                    $state['label'] .
                    '</p>';
            $sbHtml .='</div>' .
                    '</span>';
            if ($status == 'current') {
                $status = 'notdone';
            }
        }
        $sbHtml .= '</div>';
        if ($currentStateId < 0) {
            $sbHtml .= '<div class="special_state cancelled_state">' .
                    'Cancelled' .
                    '</div>';
        } else if ($status == 'done' && $states[$currentStateId]) {
            $sbHtml .= '<div class="special_state">' .
                    $states[$currentStateId]['label'] .
                    '</div>';
        }
        return $sbHtml;
    }

    public function createStateViewBy($current_state_id) {
        $states = $this->Util->getAllStates();
        $normalFlow = $this->getNormalFlow($states);
        $sbHtml = '<div class="stateboxes">';
        $current = $current_state_id === 0 ? 'btn-danger' : 'btn-primary';
        $sbHtml .= '<a class="btn btn-xs ' . $current . '" href="' . $this->webroot . 'orders/index' . '">' .
                'All' .
                '</a>';
        foreach ($normalFlow as $state) {
            $current = $current_state_id === $state['id'] ? 'btn-danger' : 'btn-primary';
            $sbHtml .= '<a class="btn btn-xs ' . $current . '" href="' . $this->webroot . 'orders/index?state_id=' . $state['id'] . '" style="margin:2px;">';
            $sbHtml .= $state['label'];
            $sbHtml .= '</a>';
        }
        $sbHtml .= '</div>';
        return $sbHtml;
    }

    public function createOwnStateView($current_state_id) {
        $states = $this->Util->getAllStates();
        $normalFlow = $this->getNormalFlow($states);
        $sbHtml = '<div class="stateboxes">';
        $current = $current_state_id === 0 ? 'btn-danger' : '';
        $sbHtml .= '<a class="btn ' . $current . '" href="' . $this->webroot . 'orders/own' . '">' .
                'All' .
                '</a>';
        foreach ($normalFlow as $state) {
            $current = $current_state_id === $state['id'] ? 'current' : '';
            $sbHtml .= '<a class="btn ' . $current . '" href="' . $this->webroot . 'orders/own?state_id=' . $state['id'] . '">';
            $sbHtml .=$state['label'];
            $sbHtml .= '</a>';
        }
        $sbHtml .= '</div>';
        return $sbHtml;
    }

    function getNormalFlow($states) {
        $normal_flow = array();
        $current_state = $states[1]; // Open Lead
        $normal_flow[] = $current_state;
        do {
            $current_state = $states[$current_state['next_id']];
            $normal_flow[] = $current_state;
        } while ($current_state['next_id'] != 0);
        return $normal_flow;
    }

}

?>
