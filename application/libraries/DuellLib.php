<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class DuellLib {

	function DuellLib() 
	{
		$this->CI =& get_instance();
		$this->CI->load->database();
	}

	function getCurrentGame($session_id, $create_new = TRUE) {
		$session_id = $this->CI->db->escape_str($session_id);
		$query = $this->CI->db->query("SELECT id, level, session, round, team_a, team_b FROM rallye_duell_games WHERE session = '$session_id'");
		if ($query->num_rows()) {
			return $query->row(); 
		} elseif ($create_new) {
			$oGame = new stdClass();
			$oGame->level = $this->findNextLevel(-1);
			$oGame->session = $session_id;
			$query = $this->CI->db->query("INSERT INTO rallye_duell_games (level, session, round) VALUES ({$oGame->level}, '$session_id',0)");
			$oGame->id = $this->CI->db->insert_id();
			$oGame->round = 1;
			$oGame->team_a = false;
			$oGame->team_b = false;
			$this->CI->db->query("INSERT INTO rallye_duell_played (level, game) VALUES ({$oGame->level}, {$oGame->id})");
			return $oGame;
		} else {
			return FALSE;
		}
	}
	function findNextLevel($game_id) {
		$game_id = $this->CI->db->escape_str($game_id);
		$query = $this->CI->db->query("SELECT id, rand() AS random FROM rallye_duell_level
		WHERE id NOT IN (SELECT level FROM rallye_duell_played WHERE game = $game_id)
		ORDER BY random LIMIT 1");
		if ($query->num_rows() == 1) {
			$oRow = $query->row();
			return $oRow->id;
		} else {
			return FALSE;
		}
	}

	function setNextLevel($game_id) {
		$game_id = $this->CI->db->escape_str($game_id);
		$next_level = $this->findNextLevel($game_id);
		$this->CI->db->query("UPDATE rallye_duell_games SET level = '$next_level', round=round+1 WHERE id = '$game_id'");
		$this->CI->db->query("INSERT INTO rallye_duell_played (level, game) VALUES ($next_level, $game_id)");
	}

	/*
	 * Get all games, which are currently played
	 */
	function getCurrentGames() {
		$query = $this->CI->db->query("SELECT id, level, session FROM rallye_duell_games");
		if ($query->num_rows() > 0) {
			$aGames = array();
			foreach ($query->result() as $row){
				$aGames[] = $row;
			}
			return $aGames;
		} else {
			return FALSE;
		}
	}

	/*
	 * Get level with answers 
	 */
	function getLevel($level_id) {
		$level_id = $this->CI->db->escape_str($level_id);
		$query = $this->CI->db->query( "SELECT id, title FROM rallye_duell_level WHERE id = '$level_id'");
		if ($query->num_rows() == 1) {
			$oLevel = $query->row();
			$sQuery = $this->CI->db->query("SELECT id, title, points FROM rallye_duell_answers WHERE level = {$oLevel->id} ORDER BY points DESC");
			if ($sQuery->num_rows() > 0) {
				$aAnswers = array();
				foreach ($sQuery->result() as $row){
					$aAnswers[] = $row;
				}
				$oLevel->answers = $aAnswers;
				return $oLevel;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	function setTeam($session, $team, $team_id){
		$session = $this->CI->db->escape_str($session);
		$team_id = $this->CI->db->escape_str($team_id);
		$team = $this->CI->db->escape_str($team);
		$this->CI->db->query("UPDATE rallye_duell_games SET team_".$team." = '$team_id' WHERE session = '$session'");
	}

	/*
	 * Get level with answers 
	 */
	function getLevelWithPlayedStatus($level_id, $session) {
		$level_id = $this->CI->db->escape_str($level_id);
		$query = $this->CI->db->query( "SELECT id, title FROM rallye_duell_level WHERE id = '$level_id'");
		if ($query->num_rows() == 1) {
			$oLevel = $query->row();
			$sQuery = $this->CI->db->query("SELECT id, title, points FROM rallye_duell_answers WHERE level = {$oLevel->id} ORDER BY points DESC");
			if ($sQuery->num_rows() > 0) {
				$aAnswers = array();
				foreach ($sQuery->result() as $row){
					$q = $this->CI->db->query("SELECT shown FROM rallye_duell_trigger WHERE answer = '{$row->id}' AND session = '{$session}'");
					if($q->num_rows()){
						$row->played = true;
					}
					else{
						$row->played = false;
					}
					$aAnswers[] = $row;
				}
				$oLevel->answers = $aAnswers;
				return $oLevel;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}

	/*
	 * Insert an answer which is to be shown in a given game
	 */
	function showAnswer($answer_id, $session_id) {
		$time = time();
		$answer_id = $this->CI->db->escape_str($answer_id);
		$session_id = $this->CI->db->escape_str($session_id);
		$sQuery = "INSERT INTO rallye_duell_trigger (answer, session, inserted, shown) VALUES ('$answer_id', '$session_id', '$time', 0)";
		$this->CI->db->query($sQuery);
	}

	/*
	 * Check, if a new answer has to be displayed
	 */
	function getShownAnswer($session_id) {
		$session_id = $this->CI->db->escape_str($session_id);
		$query = $this->CI->db->query("SELECT id, answer FROM rallye_duell_trigger WHERE session = '$session_id' AND shown='0' ORDER BY inserted ASC, id ASC LIMIT 1");
		if ($query->num_rows() == 1) {
			$oAnswer = $query->row();
			$sQuery = "UPDATE rallye_duell_trigger SET shown='1' WHERE session = '$session_id' AND answer = '{$oAnswer->answer}'";
			$this->CI->db->query($sQuery);
			return $oAnswer;
		} else {
			return FALSE;
		}
	}

	function addPoints($answer_id, $session_id, $team){
		$answer_id = $this->CI->db->escape_str($answer_id);
		$session_id = $this->CI->db->escape_str($session_id);
		$sQuery = "INSERT INTO rallye_duell_team_answers (answer, session, team) VALUES ('$answer_id', '$session_id', '$team')";
		$this->CI->db->query($sQuery);
	}

	function getPoints($session_id){
		$query = $this->CI->db->query("SELECT sum(b.points) AS `points`, a.team FROM `rallye_duell_team_answers` AS `a` 
			LEFT JOIN rallye_duell_answers AS `b` ON a.answer = b.id 
			WHERE session='$session_id'
			GROUP BY a.team");
		return $query->result();
	}

}