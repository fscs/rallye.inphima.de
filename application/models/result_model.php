<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Result_model extends CI_Model {

	private $tResults = "jd_rallye_results";
	private $tGames = "jd_rallye_games";
	private $tGroups = "jd_rallye_groups";
	private $tParticipants = "jd_rallye_participants";
	private $aFinalPoints = array();
	private $aFirstplaces = array();

	function __construct() {
		parent::__construct();
	}

	function getGroup($id = null) {
		$this->db->where('id', $id);
		$query = $this->db->get($this->tGroups);
		if ($oGroup = $query->row()) {
			$oGroup->participants = array();
			$this->db->where('group_id', $oGroup->id);
			$query = $this->db->get($this->tParticipants);
			foreach ($query->result() as $oRow) {
				$oGroup->participants[] = $oRow;
			}
			return $oGroup;
		}
		return FALSE;
	}

	function save($iStation, $iGroup, $dPoints, $blUpdate = FALSE) {
		$oGroup = $this->getGroup($iGroup);
		$oGame = $this->getGame($iStation);
		$dPoints = floatval($dPoints);
		if ($oGroup && $oGame) {
			$aData = array(
				'group_id' => $oGroup->id,
				'game_id' => $oGame->id,
				'points' => $dPoints
			);
			if ($blUpdate) {
				$this->db->where('game_id', $oGame->id);
				$this->db->where('group_id', $oGroup->id);
				$this->db->update($this->tResults, $aData);
			} else {
				$this->db->insert($this->tResults, $aData);
			}
			return TRUE;
		}
		return FALSE;
	}
	
	function insert($iStation, $iGroup, $dPoints) {
		return $this->save($iStation, $iGroup, $dPoints);
	}

	function update($iStation, $iGroup, $dPoints) {
		return $this->save($iStation, $iGroup, $dPoints, TRUE);
	}

	function getOldGroups($iStation, $blOnlyIDs = false) {
		$this->db->where('game_id', $iStation);
		$query = $this->db->get($this->tResults);
		$aOldGroups = array();
		foreach ($query->result() as $oRow) {
			$aOldGroups[] = ($blOnlyIDs ? $oRow->group_id : $this->getGroup($oRow->group_id));
		}
		return $aOldGroups;
	}

	function getNewGroups($iStation) {
		$aOldGroups = $this->getOldGroups($iStation, TRUE);
		if (count($aOldGroups) > 0) {
			$this->db->where_not_in('id', $aOldGroups);
		}
		$query = $this->db->get($this->tGroups);
		$aNewGroups = array();
		foreach ($query->result() as $oRow) {
			$aNewGroups[] = $this->getGroup($oRow->id);
		}

		usort($aNewGroups, function($g1, $g2) {
			return strcmp($g1->name, $g2->name);
		});
		return $aNewGroups;
	}

	public function getAllGroups($blOnlyIDs = false){
		$query = $this->db->get($this->tGroups);
		$aOldGroups = array();
		foreach ($query->result() as $oRow) {
			$aOldGroups[] = ($blOnlyIDs ? $oRow->id : $this->getGroup($oRow->id));
		}
		usort($aOldGroups, function($g1, $g2) {
			return strcmp($g1->name, $g2->name);
		});
		return $aOldGroups;
	}

	function getFinalPoints() {
		if (!$this->aFinalPoints) {
			$this->getGames();
		}
		$aRet = array();
		foreach ($this->aFinalPoints as $gid => $iPoints) {
			$oGroup = $this->getGroup($gid);
			$oGroup->finalpoints = $iPoints;
			$oGroup->firstplaces = (isset($this->aFirstplaces[$gid]) ? $this->aFirstplaces[$gid] : 0);
			$aRet[] = $oGroup;
		}
		usort($aRet, array($this,'cmp_groups'));
		return $aRet;
	}

	function cmp_groups($grp1, $grp2) {
		if ($grp1->finalpoints > $grp2->finalpoints) {
			return -1;
		} elseif ($grp1->finalpoints < $grp2->finalpoints) {
			return 1;
		} else {
			if ($grp1->firstplaces > $grp2->firstplaces) {
				return -1;
			} elseif ($grp1->firstplaces > $grp2->firstplaces) {
				return 1;
			}
			return 0;
		}
	}

	function getGames() {
		$query = $this->db->get($this->tGames);
		$aGames = array();
		foreach ($query->result() as $oRow) {
			$g = $this->getGame($oRow->id);
			#print_r($g);
			$aGames[] = $g;
			foreach ($this->getGame($oRow->id)->results as $oResult) {
				if (!isset($aPoints[$oResult->group->id])) {
					$aPoints[$oResult->group->id] = 0;
				}
				$aPoints[$oResult->group->id] += $this->getPointsForPlacement($oResult->placement) * $g->weight;
				if (!isset($aFirstplaces[$oResult->group->id])) {
					$aFirstplaces[$oResult->group->id] = 0;
				}
				if ($oResult->placement == 1) {
					$aFirstplaces[$oResult->group->id] ++;
				}
			}
		}
		$this->aFinalPoints = $aPoints;
		$this->aFirstplaces = $aFirstplaces;
		return $aGames;
	}

	function getGamesArray(){
		$query = $this->db->get($this->tGames);
		$aGames = array();
		foreach ($query->result() as $oRow) {
			$aGames[$oRow->id] = $oRow->name;
		}
		return $aGames;
	}

	function getGame($id) {
		$this->db->where('id', $id);
		$query = $this->db->get($this->tGames);
		if ($oGame = $query->row()) {
			$aParticipants = array();
			$oGame->results = array();
			$this->db->where('game_id', $oGame->id);
			$this->db->order_by('points', $oGame->sorting);
			$query = $this->db->get($this->tResults);
			$iPlacement = 0;
			$iLastpoints = 0;
			$iSameplace = 1;
			foreach ($query->result() as $oResult) {
				if ($iLastpoints != $oResult->points) {
					$iPlacement += $iSameplace;
					$iSameplace = 1;
				} else {
					$iSameplace++;
				}
				$oResult->group = $this->getGroup($oResult->group_id);
				$oResult->placement = $iPlacement;
				$iLastpoints = $oResult->points;
				$aParticipants[] = $oResult->group_id;
				$oGame->results[] = $oResult;
			}
			if (count($aParticipants) > 0) {
				$this->db->where_not_in('id', $aParticipants);
			}
			$query = $this->db->get($this->tGroups);
			foreach ($query->result() as $oRow) {
				$oResult = new stdClass();
				$oResult->id = 0;
				$oResult->placement = '-';
				$oResult->game_id = $id;
				$oResult->group_id = $oRow->id;
				$oResult->group = $this->getGroup($oRow->id);
				$oResult->points = '-';
				$oGame->results[] = $oResult;
			}
			return $oGame;
		}
		return FALSE;
	}


	function getPlacement($group_id, $game_id) {
		$this->db->where('game_id', $game_id);
		$this->db->where('group_id', $group_id);
		$query = $this->db->get($this->tResults);
		if ($oResult = $query->row()) {
			$this->db->where('points >', $oResult->points);
			$this->db->where('game_id', $game_id);
			$iPlacement = $this->db->count_all($this->tResults);
			return $iPlacement;
		}
		return false;
	}

	function getPointsForPlacement($iPlacement) {
		$aPoints = array(
			 1 => 25,
			 2 => 21,
			 3 => 19,
			 4 => 17,
			 5 => 15,
			 6 => 14,
			 7 => 13,
			 8 => 12,
			 9 => 11,
			10 => 10,
			11 =>  9,
			12 =>  8,
			13 =>  7,
			14 =>  6,
			15 =>  5,
			16 =>  4,
			17 =>  3,
			18 =>  2,
			19 =>  1,
			20 =>  0
		);
		return (isset($aPoints[$iPlacement]) ? $aPoints[$iPlacement] : 0);
	}

}

