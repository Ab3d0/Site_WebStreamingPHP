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
		$this->filter = $this->input->get('filter') ?? 'all';
		$this->numArtiste = $this->input->get('numArtiste') ?? '1';
	}


    public function index()
	{
		$musics = $this->model_music->getArtistes($this->filter);
		$this->load->view('layout/header');
		$this->load->view('artistes',['artistes'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice]);
		$this->load->view('layout/footer');
	}

	public function view($id){
		$musics = $this->model_music->getAlbumsArtistes($id);
		$this->load->view('layout/header');
		$this->load->view('liste_album_artist',['songs'=>$musics,'filter'=>$this->filter, 'choice'=>$this->choice]);
		$this->load->view('layout/footer');
	}


}