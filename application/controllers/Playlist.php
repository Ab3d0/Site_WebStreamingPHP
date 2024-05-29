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
			$this->load->view('layout/header');
			$this->load->view('playlists',['playlists'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice]);
			$this->load->view('layout/footer');
		} else {
			$this->load->view('layout/header');
			$this->load->view('connect');
			$this->load->view('layout/footer');
		}
	}

	public function pageI(){
		$this->load->view('layout/header');
		$this->load->view('inscriptions.php');
		$this->load->view('layout/footer');
	}


	public function auth(){
		session_start();
		$email = $this->input->post('email');
		$_SESSION['user_session'] = "$email";

		
		if($this->model_music->emailExists($email) != 1){
			$this->model_music->destroySession();
			$this->load->view('layout/header');
			$this->load->view("connect");
			echo "L'adresse mail ou le mot de passe est incorrect.";
			$this->load->view('layout/footer');
		} else if(password_verify($this->input->post("password"), $this->model_music->getHashedPassword($email))){
			$this->index();
		} else {
			$this->model_music->destroySession();
			$this->load->view('layout/header');
			$this->load->view('connect');
			echo "L'adresse mail ou le mot de passe est incorrect.";
			$this->load->view('layout/footer');
		}
	}

	public function create_users(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('email', 'Adresse mail', 'valid_email');
		$this->form_validation->set_rules('password', 'current password', 'min_length[5]|required');
		$this->form_validation->set_rules('cpassword', 'confirm password', 'required|matches[password]');

		if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header');
			$this->load->view('inscriptions');
			$this->load->view('layout/footer');
		} else {
			$password = $this->input->post('password');
			$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
			$email = $this->input->post('email');
			if($this->model_music->emailExists($email) == 1){
				$this->load->view('layout/header');
				echo "l'email est déjà utiliser";
				$this->load->view("inscriptions");
				$this->load->view('layout/footer');
			} else {
				$this->model_music->addUser($email, $hashedPassword);
				$this->load->view('layout/header');
				$this->load->view("connect.php");
				$this->load->view('layout/footer');
			}
		}




		
	}


	public function createPlaylist(){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('name', 'Nom', 'required');


		if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header');
			$this->load->view('create_playlist');
			$this->load->view('layout/footer');
		} else {
			session_start();
			$idUser = $this->model_music->getIdUser($_SESSION['user_session']);
			/* fonction qui ajoute dans la bdd la playlist vide */
			$this->model_music->addPlaylist($idUser, $this->input->post("name"));

			$this->index();
		}
	}


	public function view($id){
		/* variable = methode qui récup les sons d'une playlist */
		$songs = $this->model_music->getSongsOfPlaylist($id);
		$this->load->view('layout/header');
		$this->load->view('songs_playlist', ['songs'=>$songs,'filter'=>$this->filter, 'choice'=>$this->choice, "playlist"=>$id]);
		$this->load->view('layout/footer');
	}

	public function deconnect(){
		session_start();
		$this->model_music->destroySession();
		redirect('playlist');
	}

	public function addAlbum($id){
		$this->load->library('form_validation');
		$this->form_validation->set_rules('playlist', 'Playlist', 'required');
		


		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header');
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else if ($this->form_validation->run() === FALSE){
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			$this->load->view('layout/header');
			$music = $this->model_music->getPlaylists($_SESSION["user_session"]);
			$this->load->view('add_albums', ["playlists"=>$music, "idAlbum"=>$id]);
			$this->load->view('layout/footer');
		} else {
			$songs = $this->model_music->getSongs($id);
			foreach($songs as $song){
				$this->model_music->addSongInPlaylist($this->input->post("playlist"), $song->songId);
			}
			redirect("playlist/view/{$this->input->post('playlist')}");
		}
	}

	public function addSong($id){

		$this->load->library('form_validation');
		$this->form_validation->set_rules('playlist', 'Playlist', 'required');


		if($this->model_music->isAuth() == false){
			$this->load->view('layout/header');
			$this->load->view('connect');
			$this->load->view('layout/footer');
		} else if ($this->form_validation->run() === FALSE){
			if (session_status() === PHP_SESSION_NONE) {
				session_start();
			}
			$this->load->view('layout/header');
			$music = $this->model_music->getPlaylists($_SESSION["user_session"]);
			$this->load->view('add_song', ["playlists"=>$music, "idSong"=>$id]);
			$this->load->view('layout/footer');
		} else {
			$this->model_music->addSongInPlaylist($this->input->post("playlist"), $id);
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


		if ($this->form_validation->run() === FALSE){
			$this->load->view('layout/header');
			$this->load->view('generate_playlist');
			$this->load->view('layout/footer');
		} else {
			session_start();
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




}