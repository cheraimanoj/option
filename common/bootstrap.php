<?php
$config_file = realpath(dirname(__DIR__)) . "/config/config.php";

if (file_exists($config_file)) {
    $config = include $config_file;
}
//Creating Object for database connection
try {

    $conn = new PDO("mysql:host={$config['db']['host']};port={$config['db']['port']};dbname={$config['db']['name']};", $config['db']['user'], $config['db']['pass']);

} catch  (PDOException $e) {

    echo "DB connection failed".$e;

}

include_once realpath(__DIR__ . "/dbqueries.php");


