<?php

/**
 * StateboxHelper is 
 *
 * @author Mizno Kruge
 * @since May 28, 2012
 * Copyright "PT Tricipta Media Perkasa" all rights reserved
 */
class TicketstateboxHelper extends Helper {

	protected $Util;
	protected $Arr;

	public function __construct(View $view, $settings = array()) {
		parent::__construct($view, $settings);
		// Do other initialization here
		App::import('Component', 'Util');
		$this->Util = new UtilComponent(new ComponentCollection());
		$this->Arr = new ArrComponent(new ComponentCollection());
	}

	public function createStateViewBy($current_state_id, $current_user = 0, $uri = 'tickets/index', array $conditions = NULL) {
		if ((int) $current_user > 0)
			$conditions['Ticket.assigned_to'] = $current_user;

		$conditions['Ticket.ticket_state_id'] = $current_state_id;
		$states = $this->Util->getAllTicketStates($conditions);
		$ctrl = $uri;
		$sbHtml = '<div class="ticketstateboxes">';
		$current = $current_state_id === 0 ? 'class="active"' : '';

		$current_url = $this->webroot . $ctrl;

		$mark = '?';
		if (count($conditions) > 0) {
			$mark = '?';
		}

		if ((int) $current_user > 0) {
			$mark = '&';
			$current_url .= '?user=' . $current_user;
		}

		if ((int) $this->Arr->Get($conditions, 'Ticket.ticket_type_id', 0) > 0) {
			$current_url .= $mark . 'ticket_type=' . $conditions['Ticket.ticket_type_id'];
		}

		//$mark = ($mark == '?') ? '&': '?';
		$sbHtml .= '<ul class="nav nav-tabs"><li ' . $current . '>' .
				'<a href="' . $current_url . '">' .
				'All' .
				'</a></li>';


		foreach ($states as $state) {
			$current = $current_state_id === $state['id'] ? 'class="active"' : '';
			$sbHtml .= '<li ' . $current . '><a href="' . $current_url . $mark . 'state_id=' . $state['id'] . '">';
			$sbHtml .= $state['name'] . '(' . $state['count_ticket'] . ')';
			$sbHtml .= '</a></li>';
		}
		$sbHtml .= '</ul>';
		$sbHtml .= '</div>';
		return $sbHtml;
	}

	public function renderTypeFilter($current = 0) {
		$tmp = '<label>Pilih Tipe Ticket</label><select id="ticket-types" name="ticket_type">';
		$tmp .= '<option value="0">----Semua----</option>';

		$TicketType = ClassRegistry::init('TicketType');
		$ttypes = $TicketType->find('all');

		foreach ($ttypes as $ttype) {
			$selected = ((int) $current === (int) $ttype['TicketType']['id'] ) ? 'selected="selected"' : '';
			$tmp .= '<option ' . $selected . ' value="' . $ttype['TicketType']['id'] . '">' . $ttype['TicketType']['name'] . '</option>';
		}

		$tmp .= '</select>';

		return $tmp;
	}

	public function renderState($current, $allow = 0) {
		$tmp = '<select name="edtTicketState" class="slcEditableState">';
		$TicketState = ClassRegistry::init('TicketState');
		$states = $TicketState->find('all');

		foreach ($states as $state) {
			$selected = ((int) $current === (int) $state['TicketState']['id'] ) ? 'selected="selected"' : '';
			if (strtolower($state['TicketState']['name']) =='closed' && $allow === 0) {
				$tmp .= '';
			} else {
				$tmp .= '<option ' . $selected . ' value="' . $state['TicketState']['id'] . '">' . $state['TicketState']['name'] . '</option>';
			}
		}

		$tmp .= '</select>';
		return $tmp;
	}

}
