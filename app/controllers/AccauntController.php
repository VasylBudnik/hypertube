<?php

namespace App\Controllers;

use App\Core\App;
use App\Models\Auth;
use App\Models\Movie;
use App\Models\User;

class AccountController
{
	protected $db;

	/**
	 * User constructor.
	 * @throws \Exception
	 */
	public function __construct()
	{
		$this->db = App::get('database');
	}

	public function	personalArea()
	{
		if (!$_SESSION['userId']) {
			redirect('login');
		}
		$view = (Movie::movieVived($_SESSION['userId']));
		$liked_movie = Movie::likeMovie($_SESSION['userId']);
		if (!empty($liked_movie)) {
			$i = 0;
			$j = 0;
			while ($liked_movie[$i]) {
				$movie[$j] = Movie::selectMovie("entity_id = ".$liked_movie[$i]->movie_id);
				$i++;
				$j++;
			}
			$movieArr = $movie;
			$movieArr =  json_decode(json_encode($movieArr), true);
			$acaunt = call_user_func_array('array_merge', $movieArr);
			$acaunt = array_reverse($acaunt);
		}
		require_once('app/views/accaunt.view.php');
	}

	public function dellUserImage()
    {
		$foto	= $_POST['foto'];
		User::userDeleteFoto($foto);
	}

	public function actionDelimg()
	{
		$foto	= $_POST['foto'];
		$res = User::delImg($foto);
		if ($res === true)
			echo "true";
		return true;
	}

	public function notifications()
    {
		if (!$_SESSION['userId']) {
			redirect('login');
		}
		$userId = User::checkLogged();
		User::offNotifications($userId);
		redirect('personalArea');
	}

	public function moviePage()
    {
		if (!$_SESSION['userId']) {
			redirect('login');
		}
		$id	= intval($_GET['id']);
		$chatId = 1;
		$movie = json_decode(json_encode(Movie::getMovie($id)),TRUE);
		$commentsList = array();
		$commentsList = Movie::arrayComment($id);
		$comm = array();
		if (empty(Movie::status($id, $_SESSION['userId']))) {
			$statusLike = 0;
		} else {
			$statusLike = 1;
		}
		foreach ($commentsList as $comment) {
			array_push($comm, $comment);
		}
		require_once('app/views/pageMovie.view.php');
	}

	public function addComment()
    {
		$comment = json_decode($_POST['comment']);
		$idMovie = json_decode($_POST['idMovie']);
		$comment = htmlentities($comment);

		$userid = $_SESSION['userId'];
		if ($userid == false) {
            echo "false";
        } else {
			Movie::putComment($userid, $idMovie, $comment);
			echo "true";
		}
	}

	public function viewedMovie()
    {
		$idMovie = json_decode($_POST['idMovie']);
		$userid = $_SESSION['userId'];
		if ($userid == false) {
            echo "false";
        } else {
			Movie::putViewed($userid, $idMovie);
			echo "true";
		}
	}

	public function likeAdd()
    {
		$movieId = $_POST['idMovie'];
		$userId = $_SESSION['userId'];
		Movie::addlikeMovie($userId, $movieId);
	}

	public function likeDel()
    {
		$movieId = $_POST['idMovie'];
		$userId = $_SESSION['userId'];
		Movie::dellLikeMovie($userId, $movieId);
	}

    public function lang()
    {
	    try {
            if (empty($_POST) || !isset($_POST['lang'])) {
                header("location: /");
            }
            $lang = $_POST['lang'];
            if ($lang == 'rus') {
                $_SESSION["lang"] = 'rus';
            }
            if ($lang == 'eng') {
                $_SESSION["lang"] = 'eng';
            }
            echo json_encode("DONE");
            return true;
        } catch (\Exception $e) {
	        reportLog($e->getMessage());
        }
    }

    public function search()
    {
	    if (!$_SESSION['userId']) {
            redirect('login');
        }
	    try {
	        $name = $_GET['name'] ?? "";
            $year = $_GET['year'] ?? "";
            $imdb = $_GET['imdb'] ?? "";
            $sort = $_GET['sort'] ?? "";

            $searchMovies = Movie::filmList();
            $result = [];
            foreach ($searchMovies as $index => $movie) {
                if (strpos($movie['title'], $name) !== false ||
                    strpos($movie['original_title'], $name) !== false ||
                    strpos($movie['film_year'], $year) !== false ||
                    strpos($movie['imdbRating'], $imdb) !== false
                ) {
                    if ($movie['title'] ==  $name || $movie['original_title'] == $name) {
                        $result = null;
                        $result[] = $movie;
                        break ;
                    }
                    $result[] = $movie;
                }
            }
            if ($sort == 'A - Z') {
                ksort($result);
            } else if ($sort == 'Z - A') {
                ksort($result);
                $result = array_reverse($result);
            } else {
                ksort($result);
            }

            $searchMovie = $result;
            require_once('app/views/search.view.php');
        } catch (\Exception $e) {
	        reportLog($e->getMessage());
        }
    }

    public function callback()
    {
        if (!$_SESSION['userId']) {
            redirect('login');
        }
	    try {
            $authorization_code = $_GET['code'];
            $client_id = A42_CLIENT_ID;
            $client_secret = A42_CLIENT_SECRET;
            $redirect_uri = A42_REDIRECT_URI;
            $url = 'https://api.intra.42.fr/oauth/token';
            $data = array('code' => $authorization_code, 'client_id' => $client_id, 'client_secret' => $client_secret, 'redirect_uri' => $redirect_uri, 'grant_type' => "authorization_code");
            $options = array(
                'http' => array(
                    'header' => "Content-type: application/json\r\n",
                    'method' => 'POST',
                    'content' => json_encode($data)
                )
            );
            $context = stream_context_create($options);
            $result = file_get_contents($url, false, $context);

            $array = json_decode($result, true);
            $access_token = $array['access_token'];
            $info = file_get_contents('https://api.intra.42.fr/v2/me?access_token=' . $access_token);
            $arr = json_decode($info, true);

            $first_name = $arr["first_name"];
            $email = $arr["email"];
            $password = "default";

            if (User::getUserByEmail($email)) {
                try {
                    $user = User::getUserByEmail($email);
                    Auth::activRegistration42($email);
                    Auth::login($user);
                    header("Location: /");
                    return true;
                } catch (\Exception $e) {
                    var_dump($e->getMessage());
                }
            } else {
                User::register($first_name, $email, $password);
                $user = User::getUserByEmail($email);
                Auth::activRegistration42($email);
                Auth::login($user);
                header("Location: /");
                return true;
            }
            return false;
        } catch (\Exception $e) {
	        reportLog($e->getMessage());
        }
    }

    public function gitcallback()
    {
        if (!$_SESSION['userId']) {
            redirect('login');
        }
        try {
            $authorizeURL = 'https://github.com/login/oauth/authorize';
            $tokenURL = 'https://github.com/login/oauth/access_token';
            $apiURLBase = 'https://api.github.com/';

            if ($_GET['action'] == 'login') {
                $_SESSION['state'] = hash('sha256', microtime(TRUE) . rand().$_SERVER['REMOTE_ADDR']);
                unset($_SESSION['access_token']);

                $params = array(
                    'client_id' => OAUTH2_CLIENT_ID,
                    'redirect_uri' => GIT_REDIRECT_URI,
                    'scope' => 'user',
                    'state' => $_SESSION['state']
                );
                header('Location: ' . $authorizeURL . '?' . http_build_query($params));
                die();
            }

            if ($_GET['code']) {
                if(!$_GET['state'] || $_SESSION['state'] != $_GET['state']) {
                    header('Location: /');
                    die();
                }
                $token = $this->apiRequest($tokenURL, array(
                    'client_id' => OAUTH2_CLIENT_ID,
                    'client_secret' => OAUTH2_CLIENT_SECRET,
                    'redirect_uri' => GIT_REDIRECT_URI,
                    'state' => $_SESSION['state'],
                    'code' => $_GET['code']
                ));

                $_SESSION['access_token'] = $token->access_token;

                header('Location: gitcallback');
            }

            if ($this->session('access_token')) {

                $user = $this->apiRequest($apiURLBase . 'user');
                $first_name = $user->name;
                $email = $user->email ?? $this->generateRandomString(). "@hypertube.loc";
                $password = "default";

                if (User::getUserByEmail($email)) {
                    try {
                        $user = User::getUserByEmail($email);
                        Auth::activRegistration42($email);
                        Auth::login($user);
                        header("Location: /");
                        return true;
                    } catch (\Exception $e) {
                        var_dump($e->getMessage());
                    }
                } else {
                    User::register($first_name, $email, $password);
                    $user = User::getUserByEmail($email);
                    Auth::activRegistration42($email);
                    Auth::login($user);
                    header("Location: /");
                    return true;
                }
            } else {
                header("Location: register");
                return true;
            }
        } catch (\Exception $e) {
            reportLog($e->getMessage());
        }
    }


    private function apiRequest($url, $post = FALSE, $headers = array())
    {
	    try {
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
            if ($post) {
                curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            }
            $headers[] = 'Accept: application/json';
            if ($this->session('access_token')) {
                $headers[] = 'Authorization: Bearer ' . $this->session('access_token');
            }
            $headers[] = 'User-Agent:' . APP_NAME;
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            $response = curl_exec($ch);
            return json_decode($response);
        } catch (\Exception $e) {
            reportLog($e->getMessage());
	        die();
        }
    }

    private function session($key, $default = NULL)
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    private function generateRandomString($length = 6)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}