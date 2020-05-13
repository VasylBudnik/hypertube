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
            $title = makeInsertValue($res["title"]);
            $original_language = makeInsertValue($res['original_language']);
            $overview = makeInsertValue($res['overview']);
            $plot = makeInsertValue($res2["Plot"]);
            $year = makeInsertValue($res2["Year"]);
            $released = makeInsertValue($res2["Released"]);
            $runtime = makeInsertValue($res2["Runtime"]);
            $director = makeInsertValue($res2["Director"]);
            $actors = makeInsertValue($res2["Actors"]);
            $country = makeInsertValue($res2["Country"]);
            $awards = makeInsertValue($res2["Awards"]);
            $poster = makeInsertValue($res2["Poster"]);
            $ratings = makeInsertValue(
                str_replace('"', "'", str_replace("\/", "//", json_encode($res2["Ratings"])))
            );
            $imdbRating = makeInsertValue($res2["imdbRating"]);
            $imdbVotes = makeInsertValue($res2["imdbVotes"]);
            $imdbID = makeInsertValue($res2["imdbID"]);
            $production = makeInsertValue($res2["Production"]);
            $wtirer = makeInsertValue($res2["Writer"]);
            $genre = makeInsertValue($res2["Genre"]);

            $sql = "INSERT INTO `film_info` (`id`, `original_title`, `title`, `original_language`, `overview`, `plot`, `film_year`, `released`, `runtime`, `genre`, `director`, `writer`, `actors`, `country`, `awards`, `poster`, `ratings`, `imdbRating`, `imdbVotes`, `imdbID`, `production`)".
                " VALUES ({$id}, {$original_title}, {$title}, {$original_language}, {$overview}, {$plot}, {$year}, {$released}, {$runtime}, {$genre}, {$director}, {$wtirer}, {$actors}, {$country}, {$awards}, {$poster}, {$ratings}, {$imdbRating}, {$imdbVotes}, {$imdbID}, {$production});";

            if ($j == 100) {
                die("FINAL 100 ROW");
            }

            $result = $connect->exec($sql);
            $j++;
        }
    }

} catch (PDOException $e) {
    var_dump("kekeke");
    echo $e->getMessage();
    exit ;
}