<?php

define('SQL_USER', 'root');
define('SQL_HOST', 'localhost');
define('SQL_PASS', '');
define('SQL_DB', 'cursusphp');


// Start database connection
//$link = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or die(mysql_error());


//$port = ':81';
$db_config = array(
    'driver' => 'mysql',
    'username' => 'root',
    'password' => '',
    //'schema' => 'cursusphp', // verander dit in je eigen schema
    'dsn' => array(
        'dbname' => 'cursusphp', // verander dit in de db van je reeks
        'host' => '127.0.0.1',
        'port' => '3306',
    )
);

/*
$dsn = 'mysql:dbname=testdb;host=127.0.0.1';
$user = 'dbuser';
$password = 'dbpass';
try {
    $dbh = new PDO($dsn, $user, $password);
} catch (PDOException $e) {
    echo 'Connection failed: ' . $e->getMessage();
}*/