<?php
/**
 * Kalkun
 * An open source web based SMS Management
 *
 * @package		Kalkun
 * @author		Kalkun Dev Team
 * @license		https://spdx.org/licenses/GPL-3.0-or-later.html
 * @link		http://kalkun.sourceforge.net
 */

// ------------------------------------------------------------------------

/**
 * Sms_to_xmpp Class
 *
 * @package		Kalkun
 * @subpackage	Plugin
 * @category	Controllers
 */
include_once(APPPATH.'plugins/Plugin_controller.php');

class Sms_to_xmpp extends Plugin_controller {

	function __construct()
	{
		parent::__construct();
		$this->load->model('sms_to_xmpp_model');
	}

	function index()
	{
		$data['title'] = 'XMPP Account Status';
		$data['main'] = 'index';
		$data['status'] = $this->sms_to_xmpp_model->check_status($this->session->userdata('id_user'));
		$data['xmpp'] = $this->sms_to_xmpp_model->get_xmpp($this->session->userdata('id_user'));
		$this->load->view('main/layout', $data);
	}

	function add()
	{
		if ($_POST)
		{
			$this->sms_to_xmpp_model->save_xmpp();
			redirect('sms_to_xmpp');
		}
	}

	function delete()
	{
		$this->sms_to_xmpp_model->delete_xmpp($this->session->userdata('id_user'));
		redirect('sms_to_xmpp');
	}
}
