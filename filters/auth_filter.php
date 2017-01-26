<?php

if(!isset($_SESSION['user_id']) || !isset($_SESSION['pseudo'])){
	$_SESSION['forwarding_url'] = $_SERVER['REQUEST_URI'];
	
	$_SESSION['notification']['message'] = 'Vous dévez être connecter pour accéder à cette page';
    $_SESSION['notification']['type'] = 'danger';
	header('location: login.php');
	exit();
}

?>