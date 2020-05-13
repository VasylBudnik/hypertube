<?php

namespace App\Controllers;

use App\Models\Dating;
use App\Models\Movie;
use App\Models\User;

class MainController
{
	/**
	 * Show the home page.
	 */
	public function index()
    {
		$view = (Movie::movieVived($_SESSION['userId']));
		if (!empty($view)) {
			$i = 0;
			$j = 0;
			while ($view[$i]) {
				$movie[$j] = Movie::selectMovie("entity_id = ".$view[$i]->movie_id);
				$i++;
				$j++;
			}
			$movieArr = $movie;
			$movieArr =  json_decode(json_encode($movieArr), true);
			$acaunt = call_user_func_array('array_merge', $movieArr);
			$acaunt = array_reverse($acaunt);
			$acaunt = array_splice($acaunt, 0, 6);
		} else {
			$acauntarr = Movie::filmList(1);
			$acauntList = array_chunk($acauntarr, 18);
			$acaunt = $acauntList[0];
			$acaunt = array_splice($acaunt, 0, 6);
		}
		require_once('app/views/index.view.php');
	}

	public function page404()
    {
		return view('page404');
	}

}