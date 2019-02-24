<?php
error_reporting(0);
include 'inc/connect.php';
$appname = "Confessor";
$dbhost="localhost";
$dbuser="userr";
$dbpass="password";
$dbname="test";
$subs="conf_";
$db = new dbdriver();
$db->connect($dbhost,$dbuser,$dbpass,$dbname);
?>