<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller {

	private $aViewData = array();

	function __construct()
	{
		parent::__construct();
		$this->aViewData['flash_message'] = $this->session->flashdata('flash_message');
		$this->aViewData['flash_message_class'] = $this->session->flashdata('flash_message_class');
		$this->aViewData['path'] = array();
		$this->load->model('User_model', 'user');
		$this->load->model('Result_model', 'result');
		$this->load->library('form_validation');
	}

	public function index()
	{
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		//$this->aViewData['content'] = $this->load->view('home/index', array(), TRUE);
		//$this->load->view('layout', $this->aViewData);
		$aGames = $this->result->getGames();
		$aFinalpoints = $this->result->getFinalPoints();
		$this->aViewData['content'] = $this->load->view('home/index', array('aGames' => $aGames, 'aFinalpoints' => $aFinalpoints), TRUE);
		$this->load->view('layout', $this->aViewData);
	}

	public function punkte(){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$aGames = $this->result->getGames();
		$aFinalpoints = $this->result->getFinalPoints();
		$this->aViewData['content'] = $this->load->view('home/punkte', array('aGames' => $aGames, 'aFinalpoints' => $aFinalpoints), TRUE);
		$this->load->view('layout', $this->aViewData);
	}

	public function siegerehrung() {
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$aGames = $this->result->getGames();
		$aFinalpoints = $this->result->getFinalPoints();
		$this->aViewData['content'] = $this->load->view('home/siegerehrung', array('aGames' => $aGames, 'aFinalpoints' => $aFinalpoints), TRUE);
		$this->load->view('layout', $this->aViewData);
	}

	public function eintragen($punkte = false) {
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		if($this->user->isAdmin()){
			$iStation = $this->input->post('station');
		}
		else{
			$iStation = $this->user->getStation();
		}
		$action = $this->input->post('action');
		$iGroup = $this->input->post('group');
		$dPoints = $this->input->post('points');
		if ($action && $iGroup && $dPoints !== FALSE) {
			$dPoints = str_replace(',','.',$dPoints);
			switch ($action) {
				case 'insert':
					if ($this->result->insert($iStation, $iGroup, $dPoints)) {
						$this->jd_lib->_flash_message('Punkte eingetragen.', 'success', 'eintragen');
					} else {
						$this->jd_lib->_flash_message('Fehler beim Eintragen (Gruppe oder Punkte vergessen?)', 'danger', 'eintragen');
					}
					break;
				case 'update':
					if ($this->result->update($iStation, $iGroup, $dPoints)) {
						$this->jd_lib->_flash_message('Punkte eingetragen.', 'success', 'eintragen');
					} else {
						$this->jd_lib->_flash_message('Fehler beim Eintragen (Gruppe oder Punkte vergessen?)', 'danger', 'eintragen');
					}
					break;
			}
		} else if ($action) {
			$this->jd_lib->_flash_message('Fehler beim Eintragen (Gruppe oder Punkte vergessen?)', 'danger', 'eintragen');
		}
		if($this->user->isAdmin()){
			$aOldGroups = $this->result->getAllGroups();
			$aNewGroups = $aOldGroups;
		}
		else{
			$aOldGroups = $this->result->getOldGroups($iStation);
			$aNewGroups = $this->result->getNewGroups($iStation);
		}
		if($punkte !== false){
			$aPunkte = (int)$punkte;
		}
		else{
			$aPunkte = "";
		}
		$this->aViewData['content'] = $this->load->view('home/eintragen', array('aPunkte'=>$aPunkte,'aOldGroups' => $aOldGroups, 'aNewGroups' => $aNewGroups,'stations'=>$this->result->getGamesArray(),'isAdmin'=>$this->user->isAdmin()), TRUE);
		$this->load->view('layout', $this->aViewData);
	}

	public function login() {
		if ($this->user->loggedIn()) {
			$this->jd_lib->_flash_message('Du bist bereits angemeldet.', 'notice', '');
		}
		if ($this->form_validation->run() == FALSE) {
			$submit = $this->input->post('submitlogin');
			if ($submit) {
				$this->aViewData['flash_message'] = validation_errors();
				$this->aViewData['flash_message_class'] = 'danger';
			}
			$oLogin = new stdClass();
			$oLogin->anchor = 'home/login';
			$oLogin->menu_title = 'Login';
			$this->aViewData['path'] = array($oLogin);
			$this->aViewData['content'] = $this->load->view('home/login', null, TRUE);
			$this->load->view('layout', $this->aViewData);
		} else {
			$username = $this->input->post('username');
			$pass = $this->input->post('password');
			if ($this->user->login($username, $pass, $blCookie)) {
				$target = $this->session->userdata('login_goto');
				$this->session->unset_userdata('login_goto');
				if (!$target) {
					$target = '';
				}
				$this->jd_lib->_flash_message('Du wurdest erfolgreich angemeldet.', 'info', $target);
			} else {
				$this->jd_lib->_flash_message('Kombination aus Benutzername und Passwort ist falsch.', 'danger', 'home/login');
			}
		}
	}

	public function logout() {
		if ($this->user->logout()) {
			$this->jd_lib->_flash_message('Du wurdest abgemeldet.', 'info', '');
		} else {
			$this->jd_lib->_flash_message('Du bist nicht angemeldet.', 'info', '');
		}
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
