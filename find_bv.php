<?php

    function getImdbIdUrl($filmeId) {
        return "https://api.themoviedb.org/3/movie/" . $filmeId . "/external_ids?api_key=4084c07502a720532f5068169281abff";
    }

function getFileDescription($imdbId) {
    return "https://www.omdbapi.com/?i=" . $imdbId . "&apikey=1f18a935";
}

function getImdbUrl($imdbId) {
    return "https://www.imdb.com/title/" . $imdbId;
}

function makeInsertValue($value) {
    return '"' . $value . '"';
}

try {
    $paramPath = __DIR__. "/config.php";

    $dsn = $params['database']['connection'];
    $params = include ($paramPath);

    $dsn = $params['database']['connection'] . ";dbname={$params['database']['name']}";
    $user = $params['database']['username'];
    $password = $params['database']['password'];

    $connect = new \PDO($dsn, $user, $password);

    $totalUrl = 'https://api.themoviedb.org/3/discover/movie?sort_by=popularity.desc&api_key=4084c07502a720532f5068169281abff';
    $url = "https://api.themoviedb.org/3/movie/popular?api_key=4084c07502a720532f5068169281abff&language=ru&page=";

    $tt = file_get_contents($totalUrl);
    $page = json_decode($tt, true);
    $totalPage = $page['total_pages'];

    $test = [];
    $tmp = '';
    $result = [];
    $j = 0;
    for($i = 1; $i <= $totalPage; $i++) {
        $tmp = file_get_contents($url . $i);
        $k = json_decode($tmp, true);
        foreach ($k['results'] as $res) {
            $id = $res["id"];
            $imdbId = json_decode(file_get_contents(getImdbIdUrl($id)), true)["imdb_id"];
            $res2 = json_decode(file_get_contents(getFileDescription($imdbId)), true);
            $id = $res["id"];
            $original_title = makeInsertValue($res['original_title']);
            $year = makeInsertValue($res2["Year"]);
            $film_name = $res['original_title'] . " " . $res2["Year"];
            $url = "http://localhost:3000/startDownload/" . $film_name;

            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_HEADER, true);
            curl_setopt($ch, CURLOPT_NOBODY, true);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch, CURLOPT_TIMEOUT,10);
            $output = curl_exec($ch);
            if (!$output) {
            	continue;
            }
            $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);
            if ($httpcode != 0) {
                echo $url . "\n";
            }
        }
    }

} catch (PDOException $e) {
    var_dump("kekeke");
    echo $e->getMessage();
    exit ;
}