<?php

namespace App\Controllers;

use App\Core\Pagination;
use App\Models\Movie;
use App\Models\User;
use App\Models\Dating;

class DatingController
{

	public $errors;

	public function __construct()
	{
		$this->errors = [];
	}

	public function dating()
    {
	    try {
            if (!$_SESSION['userId']) {
                return redirect('login');
            }
            $acaunt = array();
            if ($_GET['page'] == null) {
                $page = 1;
            } else {
                $page = $_GET['page'];
            }
            $acauntarr = Movie::filmList($page);
			$i = 0;
            while ($acauntarr[$i]) {
				$acauntarr[$i]['statusViewed'] = Movie::checkMovie($_SESSION['userId'], $acauntarr[$i]['entity_id']);
            	$i++;
			}
            $movieYears = Movie::getMovieYear();
            $movieIMDB = Movie::getMoviesIMDB();

            $acauntList = array_chunk($acauntarr, 18);
            $acaunt = $acauntList[$page - 1];
            $len = count($acauntarr);
            $pagination = new Pagination('datingMovie', $len);
            $pag = $pagination->get();
            require_once('app/views/dating.view.php');
        } catch (\Exception $e) {
	        reportLog($e->getMessage());
        }
	}
}