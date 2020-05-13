<?php

namespace App\Models;

use App\Core\App;

class Movie
{

	protected $db;

	public function __construct()
	{
		$this->db = App::get('database');
	}

	public static function filmList($page = 1)
    {
        try {
            $sql = new self();
            $account = $sql->db->selectLimit('film_info');
            if (!$account) {
                return null;
            }
            return $account;
        } catch (\Exception  $e) {
            reportLog($e->getMessage());
        } catch (PDOException $e) {
            reportLog($e->getMessage());
        }
	}

    public static function getMovieYear()
    {
        try {
            $sql = new self();
            $account = $sql->db->selectDistinctYear('film_info');
            if (!$account) {
                return null;
            }
            return $account;
        } catch (\Exception  $e) {
            reportLog($e->getMessage());
        } catch (PDOException $e) {
            reportLog($e->getMessage());
        }
    }

    public static function getMoviesIMDB()
    {
        try {
            $sql = new self();
            $account = $sql->db->selectDistinctIMDB('film_info');
            if (!$account) {
                return null;
            }
            return $account;
        } catch (\Exception  $e) {
            reportLog($e->getMessage());
        } catch (PDOException $e) {
            reportLog($e->getMessage());
        }
    }

    public static function getMoviesSearchResult($name, $year, $imdb, $sort)
    {
        try {
            $sql = new self();

            $account = $sql->db->selectSearchFilm($name, $year, $imdb, $sort);
            if (!$account) {
                return null;
            }
            return $account;
        } catch (\Exception  $e) {
            reportLog($e->getMessage());
        } catch (PDOException $e) {
            reportLog($e->getMessage());
        }
    }

	public static function getMovie($id) {
		$sql = new self();
		$film = $sql->db->selectOne("film_info", "entity_id", $id);
		return $film;
	}

	public static function arrayComment($movieId)
    {
		$movieId = intval($movieId);
		$sql = new self();
		$response = $sql->db->selectAll('user_comments');
		$com_arr  = array();
		$i = 0;
		while($response[$i])
		{
			if ($response[$i]->torrent_id == $movieId) {
				$com_arr[$i]['id'] = $response[$i]->id;
				$com_arr[$i]['torrent_id'] = $response[$i]->torrent_id;
				$com_arr[$i]['userid'] = User::nameUser($response[$i]->userid);
				$com_arr[$i]['comment_text'] = '<code>' . $response[$i]->comment_text . '</code>';
			}
			$i++;
		}
		return ($com_arr);
	}

	public static function putComment($userid, $idMovie, $comment)
    {
		$torrent_id = intval($idMovie);
		$userid = intval($userid);
		$comment_text = strval($comment);

		$sql = new self();
		$sql->db->insert('user_comments', [
			'torrent_id' => $torrent_id,
			'userid' => $userid,
			'comment_text' => $comment_text,
		]);
	}
	public static function movieVived($userId)
    {
		$userid = intval($userId);
		$search = "movie_id";
		$table = "viewed_movie";
		$where  = " user_id = ".$userid;
		$sql = new self();
		$status = $sql->db->selectAllWhere($table, $where);
		$status = json_decode(json_encode($status));

		return $status;
	}

	public static function likeMovie($userId)
    {
		$userid = intval($userId);
		$search = "movie_id";
		$table = "like_movie";
		$where  = " user_id = ".$userid;
		$sql = new self();
		$status = $sql->db->selectAllWhere($table, $where);
		$status = json_decode(json_encode($status));

		return $status;
	}

	public static function status($movieId, $userId)
    {
		$userid = intval($movieId);
		$search = "movie_id";
		$table = "like_movie";
		$userid = intval($userId);
		$where = " user_id = ".$userid." and movie_id = ".$movieId;
		$sql = new self();
		$status = $sql->db->selectAllWhere($table, $where) ;

		return $status;
	}

	public static function checkMovie($userId, $movieId)
    {
		$torrent_id = intval($movieId);
		$userid = intval($userId);
		$search = "movie_id";
		$table = "viewed_movie";
		$where  = " user_id = ".$userid;
		$sql = new self();
		$status = $sql->db->selectAllWhere($table, $where);
		$status = json_decode(json_encode($status));
		$i = 0;
		while ($status[$i]) {
			if (intval($status[$i]->movie_id) == $torrent_id) {
				return 1;
			}
			$i++;
		}
		return 0;
	}

	public static function putViewed($userid, $idMovie)
    {
		$torrent_id = intval($idMovie);
		$userid = intval($userid);
		if (Movie::checkMovie($userid, $torrent_id) == 0) {
			$sql = new self();
			$sql->db->insert('viewed_movie', [
				'user_id' => $userid,
				'movie_id' => $torrent_id,
			]);
		}
	}

	public static function selectMovie($where) {
	    $where = strval($where);
		$table = "film_info";
		$sql = new self();
		$movie = $sql->db->selectAllWhere($table, $where);
		$movie = json_decode(json_encode($movie));
		return $movie;
	}

	public static function addlikeMovie($userId, $movieId)
    {
		$sql = new self();
		$userId = intval($userId);
		$table = "like_movie";
		if (empty(Movie::status($movieId, $userId))) {
			$sql->db->insert('like_movie', [
				'user_id' => $userId,
				'movie_id' => $movieId,
			]);
		}
	}

	public static function dellLikeMovie($userId, $movieId)
    {
		$sql = new self();
		$userId = intval($userId);
		$table = "like_movie";
		$where =  " user_id = ".$userId." and "."movie_id = ".$movieId;
		if (!empty(Movie::status($movieId, $userId))) {
			$sql->db->deleteUniversal($table, $where);
		}
	}
}