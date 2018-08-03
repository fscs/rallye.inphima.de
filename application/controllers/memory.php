<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Memory extends CI_Controller {

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
		$sImageDirectory = BASEPATH.'../assets/img/memory/tiles';
		$iNumberOfPairs = 15;
		$iTileWidth = 100;
		$iTileHeight = 100;
		$iPlaytime = 300;

		$aFiles = array();
		if ($handle = opendir($sImageDirectory)) {
		    while (false !== ($file = readdir($handle))) {
				if (!in_array($file, array('.','..'))) {
					$aFiles[] = $file;
				}
		    }
		    closedir($handle);
		}
		shuffle($aFiles);

		$iNumberOfTiles = $iNumberOfPairs * 2;
		$aImages = array_slice($aFiles, 0, $iNumberOfPairs);
		$aTiles = array_merge($aImages, $aImages);
		shuffle($aTiles);

		$iOptimalWidth = ceil(sqrt($iNumberOfTiles));
		while ($iNumberOfTiles % $iOptimalWidth != 0) {
			$iOptimalWidth--;
		}

		$this->aViewData['content'] = $this->load->view('memory/index', array('aTiles' => $aTiles,'iTileWidth'=>$iTileWidth,'iTileHeight'=>$iTileHeight), TRUE);
		$this->aViewData['iNumberOfPairs'] = $iNumberOfPairs;
		$this->aViewData['iPlaytime'] = $iPlaytime;
		$this->aViewData['iOptimalWidth'] = $iOptimalWidth;
		$this->load->view('memory', $this->aViewData);
	}


}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
