<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album extends CI_Controller {
    public $choice = 'album';
	public $numAlbum = '1';
	public $genre = 'none';
	public $nameAlbum = 'none';

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');
		

		$this->load->model('model_music');

		$this->choice = $this->input->get('choice') ?? 'album';
		$this->numAlbum = $this->input->get('numAlbum') ?? '1';
		$this->genre = $this->input->get("genre") ?? 'none';
		$this->nameAlbum = $this->input->get("name") ?? 'none';
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
		$musics = $this->model_music->getAlbums($this->genre, $this->nameAlbum, $_SESSION["sort"]);
		$genres = $this->model_music->getGenres();
		if(isset($_SESSION["user_session"])){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
		} else {
			$this->load->view('layout/header', ["choice"=>$this->choice]);
		}
		$this->load->view('albums',['albums'=>$musics,'filter'=>$f, 'choice'=>$this->choice, "genres"=>$genres]);
		$this->load->view('layout/footer');
	}


	public function view($id){
		$musics = $this->model_music->getSongs($id);
		$name = 'none';
		foreach($musics as $song){
			if($name == 'none'){
				$name = $song->artistName;
				$nameAlbum = $song->albumName;
				$idArtist = $song->artistId;
			}
		}
		if(session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if(isset($_SESSION["user_session"])){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
		} else {
			$this->load->view('layout/header', ["choice"=>$this->choice]);
		}
		$this->load->view('track',['albums'=>$musics, 'choice'=>$this->choice, "nomArtiste"=>$name, "nomAlbum"=>$nameAlbum, "idArtiste"=>$idArtist, "idAlbum"=>$id]);
		$this->load->view('layout/footer');
	}

}