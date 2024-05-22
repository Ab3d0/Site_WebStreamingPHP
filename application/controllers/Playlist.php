<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Playlist extends CI_Controller {
    public $choice = 'playlist';
	public $filter = 'all';

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->model('model_music');

		$this->choice = $this->input->get('choice') ?? 'playlist';
		$this->filter = $this->input->get('filter') ?? 'all';
	}


    public function index()
	{
		session_start();
		//echo "{$_SESSION['user_session']}";
		if(isset($_SESSION["user_session"])){
			$musics = $this->model_music->getPlaylists($this->filter);
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
	

	public function create(){
		$password = $this->input->post('password');
		$cpassword = $this->input->post('cpassword');
		$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
		$email = $this->input->post('email');


		/* Fonction qui vérifie si l'email n'est pas déjà utiliser */
		if($password != $cpassword){
			$this->load->view('layout/header');
			$this->load->view('inscriptions');
			echo "Le mot de passe n'est pas identique";
			$this->load->view('layout/footer');
		} else if($this->model_music->emailExists($email) == 1) {
			$this->load->view('layout/header');
			$this->load->view('inscriptions');
			echo "L'email est déjà utiliser";
			$this->load->view('layout/footer');
		} else {
			$this->model_music->addUser($email, $hashedPassword);
			$this->load->view('layout/header');
			$this->load->view("connect.php");
			$this->load->view('layout/footer');
		}
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
		$this->load->view('layout/header');
		$this->load->view('inscriptions');
		$this->load->view('layout/footer');
	}


	public function createPlaylist(){
		$this->load->view('layout/header');
		$this->load->view('create_playlist');
		$this->load->view('layout/footer');
	}

	public function creationPlaylist(){
		
	}

}