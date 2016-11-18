<?php

if(!isset($_SESSION['user_id']) || !isset($_SESSION['pseudo'])){
	$_SESSION['notification']['message'] = 'Vous dévez être connecter pour accéder à cette page';
    $_SESSION['notification']['type'] = 'danger';
	header('location: index.php');
	exit();
}

?>