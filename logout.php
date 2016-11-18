<?php 
session_start();
 
 //suprimée l'entrée en dbb au niveau de auth_tokens
 //selete the token in database field the token of authentification
 require"config/database.php";
 $query = $db->prepare('DELETE FROM auth_tokens WHERE user_id = ?');
 $query->execute([$_SESSION['user_id']]);

//suprimer les cookies et destruction des session
//Delete all the cookies et destroy the session informations
setcookie('auth', '',time()-3600);
Session_destroy();
$_SESSION = [];

//redirection vers la page d'inscription
//redirect the user at the incription page
header('location: index.php');
?>