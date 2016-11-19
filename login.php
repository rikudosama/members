<?php
session_start();

require('includes/init.php');
include('filters/guest_filter.php');

//si le formulaire d'inscription a été soumis
//if you submit the form
if (isset($_POST['login'])) {

      //si tout les champs ont été remplis
      //if all the fields are not empty

      if (not_empty(['identifiant', 'password'])) {
       
         extract($_POST);

         $query = $db->prepare("SELECT id, pseudo, password AS hashed_password, email FROM members  
                            WHERE (pseudo = :identifiant OR email = :identifiant) 
                            AND active = '1' ");
         $query->execute([

             'identifiant' => $identifiant

            ]);

         $user = $query->fetch(PDO::FETCH_OBJ);

         if ($user && bcrypt_verify_password($password, $user->hashed_password)) {
          
              $_SESSION['user_id'] = $user->id;
              $_SESSION['pseudo'] = $user->pseudo;
              $_SESSION['avatar'] = $user->avatar;
              $_SESSION['email'] = $user->email;

              //si l'utilisateur a decidé de garder sa session active 
              //if tje user decide to be remembered
              if (isset($_POST['remember_me']) && $_POST['remember_me'] == 'on') {
                   remember_me($user->id);
              }

               redirect_intent_or('profile.php?id='.$user->id);
         }else{
            set_flash('combinaison indentifiant/password incorrect', 'danger');
            save_input_data();

         }

     }
      
}else{
 //à son arrivé aucun champ de devra être pre-remplis(users)
 //clear all the fields when the is a new comer
      clear_input_data();

}


require('views/login.view.php');
?>