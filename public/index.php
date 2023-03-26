<?php

define("ROOT", "http://localhost/BlogProject/public");


// ROUTING PAGE
$url = $_GET['url'] ?? 'home'; //default home if dont exist param url 
$url = explode("/", $url); //split

$page_name = trim($url[0]);
$filename = "../app/pages/".$page_name.".php";

if(file_exists($filename)){
	require_once $filename;
}else{
	require_once  "../app/pages/404.php";
}

?>