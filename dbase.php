<?php
// Database information
$database    = 'database';
$dbHost      = 'dbhost';
$dbUser      = 'dbuser';
$dbPass      = 'dbpass';
$connection  = mysql_connect ($dbHost, $dbUser, $dbPass);
mysql_select_db ($database, $connection);
?>
