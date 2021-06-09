<?php 
$dbServerName = 'localhost';
$dbUserName = 'root';
$dbPassword = '';
$dbName = 'quizdb';

$conn = new mysqli($dbServerName, $dbUserName, $dbPassword, $dbName) or die("Unable to connect!");
?>