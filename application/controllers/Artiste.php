<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Artiste extends CI_Controller {
    public $choice = 'artiste';
	public $filter = 'all';
	public $numArtiste = '1';
	public $nameArtiste = 'none';

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->model('model_music');

		$this->choice = $this->input->get('choice') ?? 'artiste';
		$this->numArtiste = $this->input->get('numArtiste') ?? '1';
		$this->nameArtiste = $this->input->get("name") ?? 'none';
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
		$musics = $this->model_music->getArtistes($this->nameArtiste, $_SESSION["sort"]);
		if(isset($_SESSION["user_session"])){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
		} else {
			$this->load->view('layout/header', ["choice"=>$this->choice]);
		}
		$this->load->view('artistes',['artistes'=>$musics,'filter'=>$f, 'choice'=>$this->choice]);
		$this->load->view('layout/footer');
	}

	public function view($id){
		$musics = $this->model_music->getAlbumsArtistes($id);
		if(session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if(isset($_SESSION["user_session"])){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
		} else {
			$this->load->view('layout/header', ["choice"=>$this->choice]);
		}
		$this->load->view('liste_album_artist',['songs'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice, 'idArtist'=>$id]);
		$this->load->view('layout/footer');
	}

	public function addAllSong($id){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('playlist', 'Playlist', 'required');

		if ($this->form_validation->run() === FALSE){
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			if(isset($_SESSION["user_session"])){
				$music = $this->model_music->getPlaylists($_SESSION["user_session"]);
				$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
				$this->load->view('add_all_song', ['playlists'=>$music, 'idArtist'=>$id]);
				$this->load->view('layout/footer');
			} else {
				$this->load->view('layout/header', ["choice"=>$this->choice]);
				$this->load->view('connect');
				$this->load->view('layout/footer');
			}
		} else {
			$songs = $this->model_music->getAllSongOfArtist($id);
			foreach($songs as $song){
				$this->model_music->addSongInPlaylist($this->input->post("playlist"), $song->id);
			}
			redirect("playlist/view/{$this->input->post("playlist")}");
		}

	}


}