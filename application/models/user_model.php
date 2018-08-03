<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class User_model extends CI_Model {

	private $tUser = "jd_rallye_user";

    function __construct()
    {
        parent::__construct();
    }
	
	function get($uid) {
		$this->db->where('id', $uid);
		$query = $this->db->get($this->tUser);
		return $query->row();
	}
	
	function loggedIn() {
		$uid = $this->session->userdata('uid');
		$username = $this->session->userdata('username');
		$hash = $this->session->userdata('hash');
		if ($hash == hash('sha256', $uid.$username)) {
			return TRUE;
		}
		return FALSE;
	}
	
	function getStation() {
		if ($this->loggedIn()) {
			$uid = $this->session->userdata('uid');
			$oUser = $this->get($uid);
			return $oUser->group_id;
		} else {
			return 0;
		}
	}

	function isAdmin() {
		if ($this->loggedIn()) {
			$uid = $this->session->userdata('uid');
			$oUser = $this->get($uid);
			return ($oUser->admin == 1);
		} else {
			return false;
		}
	}

	function login($username, $password) {
		$this->db->where('username', $username);
		$this->db->where('active', 1);
		$this->db->where('password', hash('sha256', $password));
		$query = $this->db->get($this->tUser);
		$oUser = $query->row();
		if ($oUser) {
			$this->session->set_userdata('uid', $oUser->id);
			$this->session->set_userdata('username', $oUser->username);
			$this->session->set_userdata('hash', hash('sha256', $oUser->id.$oUser->username));
			
			return TRUE;
		}
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('hash');
		return FALSE;
	}

	function logout() {
		$success = FALSE;
		if ($this->loggedIn()) {
			$success = TRUE;
		}
		$this->session->unset_userdata('uid');
		$this->session->unset_userdata('username');
		$this->session->unset_userdata('hash');
		return $success;
	}
}

