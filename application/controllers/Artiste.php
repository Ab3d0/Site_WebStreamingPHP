<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artiste extends CI_Controller {
    public $choice = 'artiste';
	public $filter = 'all';
	public $numArtiste = '1';

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->model('model_music');

		$this->choice = $this->input->get('choice') ?? 'artiste';
		$this->numArtiste = $this->input->get('numArtiste') ?? '1';
	}


    public function index($f='all')
	{
		if(session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if(!isset($_SESSION["sort"])){
			$_SESSION["sort"] = $f;
		} else {
			if($f == 'all'){
				$_SESSION["sort"] = 'all';
			} else if($f == 'tri'){
				if($_SESSION["sort"] == 'triaz'){
					$_SESSION["sort"] = "triza";
				} else if($_SESSION["sort"] == 'triza'){
					$_SESSION["sort"] = 'triaz';
				} else {
					$_SESSION["sort"] = 'triaz';
				}
			}
		}
		$musics = $this->model_music->getArtistes($_SESSION["sort"]);
		$this->load->view('layout/header');
		$this->load->view('artistes',['artistes'=>$musics,'filter'=>$f, 'choice'=>$this->choice]);
		$this->load->view('layout/footer');
	}

	public function view($id){
		$musics = $this->model_music->getAlbumsArtistes($id);
		$this->load->view('layout/header');
		$this->load->view('liste_album_artist',['songs'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice]);
		$this->load->view('layout/footer');
	}


}