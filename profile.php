<?php 
session_start();
$title = "Page de profil";
require('includes/init.php');
include('filters/auth_filter.php');
 
 
if (! empty($_GET['id'])) {
	//recuperation du fameux user en base de donnée
	//select the current user information in the database
	$user = find_user_by_id($_GET['id']);

	if (!$user) {
		//if nobody have this identitity we redirect the member at the inscription page(here index.php)
		//si aucun membre n'a cette identifiant recuperer on redirige le fameu memre la page d'inscription ici (index.php)
		redirect('index.php');
	}
}else{
	// on le redirige vers la page de profile en ajoutant l'id du fameu membre stocker en session avec $_SESSION['user_id']
	redirect('profile.php?id='.get_session('user_id'));
}
require('views/profile.view.php');
?>
