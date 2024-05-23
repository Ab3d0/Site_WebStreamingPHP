<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Album extends CI_Controller {
    public $choice = 'album';
	public $filter = 'all';
	public $numAlbum = '1';

    public function __construct()
	{
		parent::__construct();
		$this->load->helper('html');
		$this->load->helper('url');
		$this->load->helper('form');

		$this->load->model('model_music');

		$this->choice = $this->input->get('choice') ?? 'album';
		$this->filter = $this->input->get('filter') ?? 'all';
		$this->numAlbum = $this->input->get('numAlbum') ?? '1';
	}


    public function index()
	{
		$musics = $this->model_music->getAlbums($this->filter);
		$this->load->view('layout/header');
		$this->load->view('albums',['albums'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice]);
		$this->load->view('layout/footer');
	}


	public function view($id){
		$musics = $this->model_music->getSongs($id);
		$this->load->view('layout/header');
		$this->load->view('track',['albums'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice]);
		$this->load->view('layout/footer');
	}

}