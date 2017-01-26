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

      set_flash("veillez créer un autre mot de passe !");
      if (isset($_POST['password_reset'])) {
        $errors = [];
        if (not_empty(['password', ['password_confirm']])) {
          extract($_POST);
          if (mb_strlen($password < 6)) {
              $errors[] = "mot de passe trop court! (minimum 6 caractères) ";
          }else
          if ($password != $password_confirm) {
            $errors[] = "Les 2 mots de passe ne concordent pas";
          }
        }
        if (count($errors) == 0) {
          $query = $db->prepare("SELECT password AS hashed_password FROM users
                            WHERE (pseudo = :pseudo )
                            AND active = '1' ");
          $query->execute([

             'pseudo' => $data->pseudo

            ]);

          $member = $query->fetch(PDO::FETCH_OBJ);
          if ($member) {
            $query = $db->prepare("UPDATE users
                                SET password = :password
                                WHERE pseudo = :pseudo");
            $query->execute([

             'password' => bcrypt_hash_password($new_password),
             'pseudo' =>$data->pseudo
             ]);
            set_flash("Votre mot de passe a été bien modifier");
            redirect('login.php');
          }
        }
      }


   }else{
      set_flash('Erreur de données', 'danger');

      redirect('index.php');
   }

}else{
  set_flash('Veillez verifier votre boîte mail');
  redirect('index.php');
}

require('views/reset.view.php');
 ?>
