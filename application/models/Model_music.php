<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_music extends CI_Model {

    public function __construct()
	{
		$this->load->database();
	}

    public function getAlbums($filter='all')
	{
		if ($filter == 'all')
			$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid");
		if ($filter == 'triaz')
			$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid ORDER BY albumName ASC");
		if ($filter == 'triza')
			$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid ORDER BY albumName DESC");

		return $query->result();
	}

	public function getArtistes($filter='all')
	{
		if ($filter == 'all')
			$query = $this->db->query("SELECT * FROM artist");
		if ($filter == 'triaz')
			$query = $this->db->query("SELECT * FROM artist ORDER BY name ASC");
		if ($filter == 'triza')
			$query = $this->db->query("SELECT * FROM artist ORDER BY name DESC");

		return $query->result();
	}

	public function getPlaylists($filter='all')
	{
		if ($filter == 'all')
			$query = $this->db->query("SELECT playlist.name FROM playlist JOIN user ON user.id = playlist.userid WHERE user.email = 'dubreuil.christopher13@gmail.com'");
		if ($filter == 'triaz')
			$query = $this->db->query("SELECT playlist.name FROM playlist JOIN user ON user.id = playlist.userid WHERE user.email = 'dubreuil.christopher13@gmail.com' ORDER BY name ASC");
		if ($filter == 'triza')
			$query = $this->db->query("SELECT playlist.name FROM playlist JOIN user ON user.id = playlist.userid WHERE user.email = 'dubreuil.christopher13@gmail.com' ORDER BY name DESC");

		return $query->result();
	}

	public function emailExists($email){
		$query = $this->db->query("SELECT email FROM user WHERE email = '$email'");

		$res = 0;


		foreach($query->result() as $row){
			if($row->email == $email) {
				$res = 1;
			} else {
				$res = 2;
			}
		}

		return $res;
	}

	public function addUser($email, $password){
		$query = $this->db->query("INSERT INTO user (email, password) VALUES('$email', '$password')");
	}

	public function getHashedPassword($email){
		$query = $this->db->query("SELECT password FROM user WHERE email = '$email'");
		$res = $query->result();
		foreach($res as $row){
			$password = $row->password;
		}


		return $password;
	}


	public function destroySession(){
		$_SESSION = array();
			if (ini_get("session.use_cookies")) {
				$params = session_get_cookie_params();
				setcookie(session_name(), '', time() - 42000,
					$params["path"], $params["domain"],
					$params["secure"], $params["httponly"]
				);
			}
		session_destroy();
	}

	public function getSongs($id){
		$query = $this->db->query("SELECT track.number,track.duration,album.name AS albumName,artist.name AS artistName,song.name AS songName FROM track JOIN album ON album.id = track.albumid JOIN artist ON artist.id = album.artistid JOIN song ON song.id = track.songid WHERE albumid = $id ORDER BY number ASC");
		return $query->result();
	}
	

}