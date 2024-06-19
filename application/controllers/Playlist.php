<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist extends CI_Controller {
    public $choice = 'playlist';
	public $filter = 'all';
	public $identifiantAlbum = 1;

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->model('model_music');

		$this->choice = $this->input->get('choice') ?? 'playlist';
		$this->filter = $this->input->get('filter') ?? 'all';
		$this->identifiantAlbum = $this->input->get('album') ?? 1;
	}


    public function index()
	{
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if(isset($_SESSION["user_session"])){
			$musics = $this->model_music->getPlaylists($_SESSION["user_session"], $this->filter);
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
			$this->load->view('playlists',['playlists'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice]);
			$this->load->view('layout/footer');
		} else {
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			$this->load->view('layout/footer');
		}
	}

	public function pageI(){
		$this->load->view('layout/header', ["choice"=>$this->choice]);
		$this->load->view('inscriptions.php');
		$this->load->view('layout/footer');
	}


	public function auth(){
		session_start();
		$email = $this->input->post('Mail');
		$_SESSION['user_session'] = "$email";

		
		if($this->model_music->emailExists($email) != 1){
			$this->model_music->destroySession();
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view("connect");
			echo "L'adresse mail ou le mot de passe est incorrect.";
			$this->load->view('layout/footer');
		} else if(password_verify($this->input->post("Pwd"), $this->model_music->getHashedPassword($email))){
			redirect("playlist");	
		} else {
			$this->model_music->destroySession();
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			echo "L'adresse mail ou le mot de passe est incorrect.";
			$this->load->view('layout/footer');
		}
	}

	public function create_users(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('Email', 'Adresse mail', 'valid_email');
		$this->form_validation->set_rules('Password', 'current password', 'min_length[5]|required');
		$this->form_validation->set_rules('Cpwd', 'confirm password', 'required|matches[Password]');

		if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('inscriptions');
			$this->load->view('layout/footer');
		} else {
			$password = $this->input->post('Password');
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$email = $this->input->post('Email');
			if($this->model_music->emailExists($email) == 1){
				$this->load->view('layout/header', ["choice"=>$this->choice]);
				echo "l'email est déjà utiliser";
				$this->load->view("inscriptions");
				$this->load->view('layout/footer');
			} else {
				$this->model_music->addUser($email, $hashedPassword);
				$this->load->view('layout/header', ["choice"=>$this->choice]);
				$this->load->view("connect.php");
				$this->load->view('layout/footer');
			}
		}




		
	}


	public function createPlaylist(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Nom', 'required');

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION['user_session']]);
			$this->load->view('create_playlist');
			$this->load->view('layout/footer');
		} else {
			$idUser = $this->model_music->getIdUser($_SESSION['user_session']);
			/* fonction qui ajoute dans la bdd la playlist vide */
			$this->model_music->addPlaylist($idUser, $this->input->post("name"));

			$this->index();
		}
	}


	public function view($id){
		/* variable = methode qui récup les sons d'une playlist */
		
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else {
			$idUser = $this->model_music->getIdUser($_SESSION["user_session"]);
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION['user_session']]);
			$name = $this->model_music->getNameOfPlaylist($id, $idUser);
			if($name != null){
				$songs = $this->model_music->getSongsOfPlaylist($id);
				$this->load->view('songs_playlist', ['songs'=>$songs,'filter'=>$this->filter, 'choice'=>$this->choice, "playlist"=>$id, "user"=>$_SESSION['user_session'], "nameP"=>$name]);
				$this->load->view('layout/footer');		
			} else {
				redirect("playlist");
			}
		}
		
	}

	public function deconnect(){
		session_start();
		$this->model_music->destroySession();
		redirect('playlist');
	}

	public function addAlbum($id){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('playlist', 'Playlist', 'required');

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
			$music = $this->model_music->getPlaylists($_SESSION["user_session"]);
			$this->load->view('add_albums', ["playlists"=>$music, "idAlbum"=>$id]);
			$this->load->view('layout/footer');
		} else {
			$songs = $this->model_music->getSongs($id);
			foreach($songs as $song){
				$trackId = $this->model_music->getTrackId($id, $song->songId);
				$this->model_music->addSongInPlaylist($this->input->post("playlist"), $trackId);
			}
			redirect("playlist/view/{$this->input->post('playlist')}");
		}
	}

	public function addSong($id){
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		$this->load->library('form_validation');
		$this->form_validation->set_rules('playlist', 'Playlist', 'required');

		
		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
			$music = $this->model_music->getPlaylists($_SESSION["user_session"]);
			$this->load->view('add_song', ["playlists"=>$music, "idSong"=>$id, "idAlbum"=>$this->identifiantAlbum]);
			$this->load->view('layout/footer');
		} else {
			$trackId = $this->model_music->getTrackId($this->identifiantAlbum, $id);
			$this->model_music->addSongInPlaylist($this->input->post("playlist"), $trackId);
			redirect("playlist/view/{$this->input->post("playlist")}");
		}
	}


	public function deletePlaylist($id){
		$songs = $this->model_music->getSongsOfPlaylist($id);
		foreach($songs as $song){
			$this->model_music->removeSongInPlaylist($song->id, $id);
		}
		$this->model_music->removePlaylist($id);
		redirect("playlist");
	}

	public function deleteSongOfPlaylist($id){
		$this->model_music->removeSongInPlaylist($id, $this->identifiantAlbum);
		redirect("playlist/view/{$this->identifiantAlbum}");		
	}


	public function generatePlaylist(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('nombre', 'Nombre', 'required');
		$this->form_validation->set_rules('name', 'Nom', 'required');

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
			$this->load->view('generate_playlist');
			$this->load->view('layout/footer');
		} else {
			$idUser = $this->model_music->getIdUser($_SESSION['user_session']);
			$this->model_music->addPlaylist($idUser, $this->input->post("name"));
			$num = $this->input->post("nombre");
			$idPlaylist = $this->model_music->getIdPlaylist($this->input->post("name"));
			for($i = 0; $i < $num; $i++){
				$son = rand(1, 4403);
				/* Ajoute la chanson $son dans playlist */
				$this->model_music->addSongInPlaylist($idPlaylist, $son);
			}

			redirect("playlist/view/$idPlaylist");
		}
	}

	public function duplicate(){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('playlist', 'Playlist', 'required');
		$this->form_validation->set_rules('name', 'Nom', 'required');

		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header', ["choice"=>$this->choice]);
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header2', ["choice"=>$this->choice, "user"=>$_SESSION["user_session"]]);
			$music = $this->model_music->getPlaylists($_SESSION["user_session"]);
			$this->load->view('duplicate', ["playlists"=>$music]);
			$this->load->view('layout/footer');
		} else {
			$songs = $this->model_music->getSongsOfPlaylist($this->input->post("playlist"));
			$idUser = $this->model_music->getIdUser($_SESSION['user_session']);
			$this->model_music->addPlaylist($idUser, $this->input->post("name"));
			$idP = $this->model_music->getIdPlaylist($this->input->post("name"));
			foreach($songs as $song){
				/*$trackId = $this->model_music->getTrackId($id, $song->songId);*/
				$this->model_music->addSongInPlaylist($idP, $song->id);
			}
			redirect("playlist/view/$idP");
		}
	}





}