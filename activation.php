<?php
session_start();
require ("includes/init.php");
require ("filters/guest_filter.php");

if(!empty($_GET['p']) && is_already_in_use('pseudo', $_GET['p'], 'users')
	&& !empty($_GET['token'])
	){
   $pseudo = $_GET['p'];
   $token = $_GET['token'];

   $query = $db->prepare('SELECT id, email, password FROM users WHERE pseudo = ?');
   $query->execute([$pseudo]);

   $data = $query->fetch(PDO::FETCH_OBJ);

   $token_verif = sha1($pseudo.$data->email.$data->password);

   if ($token == $token_verif) {

   	  $query = $db->prepare("UPDATE members SET active = '1' WHERE pseudo = ?");
        $query->execute([$pseudo]);

      set_flash('Votre compte a été bien activé, remplissez les deux(2) champ pour vous connecter svp', 'success');

       redirect('login.php');

   }else{
   	  set_flash('jeton de securité invalide', 'danger');

   	  redirect('index.php');
   }

}else{
	redirect('index.php');
}
