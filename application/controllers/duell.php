<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Duell extends CI_Controller {

	private $aViewData = array();

	function __construct()
	{
		parent::__construct();
		$this->aViewData['path'] = array();
		$this->load->model('User_model', 'user');
		$this->aViewData['flash_message'] = $this->session->flashdata('flash_message');
		$this->aViewData['flash_message_class'] = $this->session->flashdata('flash_message_class');
		$this->load->model('Result_model', 'result');
		//$this->load->library('form_validation');
	}

	public function index()
	{
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
	
		$this->aViewData['content'] = $this->load->view('duell/index', array(), TRUE);
		$this->load->view('layout', $this->aViewData);
	}

	public function createGame(){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$game = $this->duelllib->getCurrentGame(md5(rand(0,10).time()),true);
		echo $game->session;
	}

	public function game($session){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$oGame = $this->duelllib->getCurrentGame($session,false);
		$oLevel = $this->duelllib->getLevel($oGame->level);
		$points = $this->duelllib->getPoints($session);
		$points_array = array();
		$points_array['team_a'] = 0;
		$points_array['team_b'] = 0;
		foreach($points as $row){
			$points_array['team_'.$row->team] = $row->points;
		}
		$team_a = $this->result->getGroup($oGame->team_a);
		if($team_a){
			$team_a = $team_a->name;
		}
		$team_b = $this->result->getGroup($oGame->team_b);
		if($team_b){
			$team_b = $team_b->name;
		}
		$this->aViewData['session'] = $session;
		$this->aViewData['content'] = $this->load->view('duell/game', array('oGame'=>$oGame,'oLevel'=>$oLevel,'oPoints'=>$points_array,'team_a'=>$team_a, 'team_b'=>$team_b), TRUE);
		$this->load->view('duell', $this->aViewData);
	}

	public function tool($session){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$oGame = $this->duelllib->getCurrentGame($session, FALSE);
		//$aGames = $this->duelllib->getCurrentGames();
		$show_answer = $this->input->post('show_answer');
		if ($show_answer && $oGame) {
			if ($show_answer == -3) {
				$this->duelllib->setNextLevel($oGame->id);
				$oGame = $this->duelllib->getCurrentGame($oGame->session, FALSE);
				$this->aViewData['flash_message'] = "Nächstes Level";
				$this->aViewData['flash_message_class'] = "info";
			}
			$this->duelllib->showAnswer($show_answer, $oGame->session);
			$oLevel = $this->duelllib->getLevelWithPlayedStatus($oGame->level,$session);
		}
		else{
			$oLevel = $this->duelllib->getLevelWithPlayedStatus($oGame->level,$session);
		}
		$iStation = $this->user->getStation();
		$aNewGroups = $this->result->getNewGroups($iStation);
		$this->aViewData['content'] = $this->load->view('duell/tool', array('oLevel'=>$oLevel, 'oGame'=>$oGame,'aNewGroups'=>$aNewGroups), TRUE);
		$this->load->view('layout', $this->aViewData);
	}

	public function answer($session){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$xml = '<xml>';
		$show_answer = $this->duelllib->getShownAnswer($session);
		$points = $this->duelllib->getPoints($session);
		foreach($points as $res){
			$xml .='<points_'.$res->team.'>'.$res->points.'</points_'.$res->team.'>';
		}
		if($show_answer != null){
			$xml .='<show>'.$show_answer->answer.'</show>';
		}
		$xml .= '</xml>';
		echo $xml;
	}

	public function showAnswer($session, $answer){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$this->duelllib->showAnswer($answer, $session);
		echo "true";
	}

	public function addPoints($session, $answer, $team){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$this->duelllib->showAnswer($answer, $session);
		if($team == "c"){
			$this->duelllib->addPoints($answer, $session, "a");
			$this->duelllib->addPoints($answer, $session, "b");
		}
		else{
			$this->duelllib->addPoints($answer, $session, $team);
		}
		echo "true";
	}

	public function setTeam($session, $team, $teamID){
		if (!$this->user->loggedIn()) {
			redirect("home/login");
		}
		$this->duelllib->setTeam($session,$team,$teamID);
		$this->duelllib->showAnswer("-3", $session);
	}

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
