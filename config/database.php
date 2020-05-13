<?php

$paramPath = ROOT. "/config.php";

if (file_exists($paramPath)) {
    $params = include ($paramPath);
    $dsn = $params['database']['connection'];
    try {
        $connect = new PDO($dsn, $params['database']['username'], $params['database']['password']);
        $connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $checkExistSQL = "show databases like '" . $params['database']['name'] . "';";
        $result = $connect->query($checkExistSQL);
        if (!$result->fetchAll()) {
            $sql = "CREATE DATABASE IF NOT EXISTS ".$params['database']['name'];
            $result = $connect->exec($sql);
            $connect = null;
            $dsn = "{$dsn};dbname={$params['database']['name']}";
            $connect = new PDO($dsn, $params['database']['username'], $params['database']['password']);
            $generalSQL = file_get_contents(ROOT.'/hypertube.sql');
            $result = $connect->exec($generalSQL);
            $connect = null;
        }
    } catch (PDOException $e) {
        reportLog($e->getMessage());
        echo $e->getMessage();
        exit ;
    }
}