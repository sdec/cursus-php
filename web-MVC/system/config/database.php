<?php

define('SQL_USER', 'root');
define('SQL_HOST', 'localhost');
define('SQL_PASS', '');
define('SQL_DB', 'cursusphp');


// Start database connection
$link = mysqli_connect(SQL_HOST, SQL_USER, SQL_PASS, SQL_DB) or die(mysql_error());