<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jeopardy extends CI_Controller {

	private $aViewData = array();

	function __construct()
	{
		parent::__construct();
		$this->aViewData['path'] = array();
		$this->load->model('User_model', 'user');
		//$this->load->model('Result_model', 'result');
		//$this->load->library('form_validation');
	}

	public function index()
	{
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
	
		$this->aViewData['content'] = $this->load->view('jeopardy/index', array(), TRUE);
		$this->load->view('jeopardy', $this->aViewData);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
