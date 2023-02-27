<?php /** * using mysqli_connectfor database connection */ 
$databaseHost= 'localhost';
$databaseName= 'blogsite';
$databaseUsername= 'root';
$databasePassword= '';

$mysqli= mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName);
