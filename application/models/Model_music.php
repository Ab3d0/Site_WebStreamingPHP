<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Model_music extends CI_Model {

    public function __construct()
	{
		$this->load->database();
	}

    public function getAlbums($genre, $name, $filter='all')
	{
		if($genre == 'none' && $name == 'none'){
			if ($filter == 'all')
				$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid");
			if ($filter == 'triaz')
				$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid ORDER BY albumName ASC");
			if ($filter == 'triza')
				$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid ORDER BY albumName DESC");
		} else if($genre != 'none'){
			$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid WHERE album.genreId = $genre");
		} else if($name != 'none'){
			$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid WHERE album.name LIKE '%$name%'");
		}




		return $query->result();
	}

	public function getArtistes($name, $filter='all')
	{
		if($name == 'none'){
			if ($filter == 'all')
				$query = $this->db->query("SELECT artist.id, artist.name, COUNT(album.id) AS nombre_albums FROM artist LEFT JOIN album ON artist.id = album.artistId GROUP BY artist.id, artist.name");
			if ($filter == 'triaz')
				$query = $this->db->query("SELECT artist.id, artist.name, COUNT(album.id) AS nombre_albums FROM artist LEFT JOIN album ON artist.id = album.artistId GROUP BY artist.id, artist.name ORDER BY name ASC");
			if ($filter == 'triza')
				$query = $this->db->query("SELECT artist.id, artist.name, COUNT(album.id) AS nombre_albums FROM artist LEFT JOIN album ON artist.id = album.artistId GROUP BY artist.id, artist.name ORDER BY name DESC");
		} else if($name != 'none') {
			$query = $this->db->query("SELECT artist.id, artist.name, COUNT(album.id) AS nombre_albums FROM artist LEFT JOIN album ON artist.id = album.artistId WHERE artist.name LIKE '%$name%' GROUP BY artist.id, artist.name ");
		}


		return $query->result();
	}

	public function getPlaylists($email, $filter='all')
	{
		if ($filter == 'all')
			$query = $this->db->query("SELECT playlist.id AS playlistId, playlist.name AS playlistName, COUNT(playlistsong.songid) AS songCount FROM user JOIN playlist ON user.id = playlist.userid LEFT JOIN playlistsong ON playlist.id = playlistsong.playlistid  WHERE user.email = '$email' GROUP BY playlist.id, playlist.name");
		if ($filter == 'triaz')
			$query = $this->db->query("SELECT playlist.id AS playlistId, playlist.name AS playlistName, COUNT(playlistsong.songid) AS songCount FROM user JOIN playlist ON user.id = playlist.userid LEFT JOIN playlistsong ON playlist.id = playlistsong.playlistid  WHERE user.email = '$email' GROUP BY playlist.id, playlist.name ORDER BY playlistName ASC");
		if ($filter == 'triza')
			$query = $this->db->query("SELECT playlist.id AS playlistId, playlist.name AS playlistName, COUNT(playlistsong.songid) AS songCount FROM user JOIN playlist ON user.id = playlist.userid LEFT JOIN playlistsong ON playlist.id = playlistsong.playlistid  WHERE user.email = '$email' GROUP BY playlist.id, playlist.name ORDER BY playlistName DESC");

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
		$query = $this->db->query("SELECT track.number,track.duration,album.name AS albumName,artist.name AS artistName, artist.id AS artistId, song.name AS songName, song.id AS songId FROM track JOIN album ON album.id = track.albumid JOIN artist ON artist.id = album.artistid JOIN song ON song.id = track.songid WHERE albumid = $id ORDER BY number ASC");
		return $query->result();
	}

	public function getAlbumsArtistes($id){
		$query = $this->db->query("SELECT album.id AS albumId,album.name AS albumName, album.year,artist.id AS artistId,artist.name AS artistName,cover.jpeg AS coverJpeg FROM `album` JOIN artist ON artist.id = album.artistid JOIN cover ON cover.id = album.coverid WHERE album.artistId = $id");

		return $query->result();
	}

	public function getIdUser($email){
		$query = $this->db->query("SELECT id FROM user WHERE email = '$email'");
		$res = $query->result();
		foreach($res as $row){
			$identifiant = $row->id;
		}

		return $identifiant;
	}

	public function addPlaylist($id, $name){
		$query = $this->db->query("INSERT INTO playlist (userid, name) VALUES($id, '$name')");
	}

	public function getSongsOfPlaylist($id){
		$query = $this->db->query("SELECT track.number, track.duration, song.name, track.id FROM playlistsong JOIN track ON track.id = playlistsong.songId JOIN song ON song.id = track.songId WHERE playlistId = $id");

		return $query->result();
	}

	public function isAuth(){
		if (session_status() === PHP_SESSION_NONE) {
			session_start();
		}
		if(isset($_SESSION["user_session"])){
			return true;
		} else {
			return false;
		}
	}

	public function addSongInPlaylist($idPlaylist, $idSong){
		$query = $this->db->query("INSERT INTO playlistsong (playlistId, songId) VALUES($idPlaylist, $idSong)");
	}

	public function removeSongInPlaylist($idSong, $idPlaylist){
		$query = $this->db->query("DELETE FROM playlistsong WHERE playlistId = $idPlaylist AND songId = $idSong");
	}
	
	public function removePlaylist($id){
		$query = $this->db->query("DELETE FROM playlist WHERE id = $id");
	}


	public function getGenres(){
		$query = $this->db->query("SELECT id, name FROM genre");
		return $query->result();

	}

	public function getIdPlaylist($name){
		$query = $this->db->query("SELECT id FROM playlist WHERE name = '$name'");

		$res = $query->result();
		foreach($res as $row){
			$id = $row->id;
		}

		return $id;
	}

	public function getNameOfPlaylist($id){
		$query = $this->db->query("SELECT name FROM playlist WHERE id = $id");

		$res = $query->result();
		foreach($res as $row){
			$id = $row->name;
		}

		return $id;
	}

	public function getAllSongOfArtist($id){
		$query = $this->db->query("SELECT DISTINCT track.id FROM album JOIN track ON track.albumId = album.id JOIN song ON song.id = track.songId WHERE album.artistId = $id");

		return $query->result();
	}

	public function getTrackId($album, $song){
		$query = $this->db->query("SELECT track.id FROM track WHERE track.albumId = $album AND track.songId = $song");

		$res = $query->result();
		foreach($res as $row){
			$track = $row->id;
		}

		return $track;
	}


}