<?php
session_start();

require('includes/init.php');
include('filters/auth_filter.php');


//si le formulaire d'inscription a été soumis
if (isset($_POST['change_password'])) {

	$errors = [];

      //si tout les champs ont été remplis

      if (not_empty(['current_password', 'new_password', 'new_password_confirmation'])) {
       
         extract($_POST);

         if (mb_strlen($new_password) < 6) {
            $errors[] = "mot de passe trop court! (minimum 6 caractères) ";
        }else{
            if ($new_password != $new_password_confirmation) {
                
                $errors[] = "Les 2 mots de passe ne concordent pas";
            }
        }
        if (count($errors) == 0) {
            $query = $db->prepare("SELECT password AS hashed_password FROM users  
                            WHERE (id = :id ) 
                            AND active = '1' ");
            $query->execute([

             'id' => get_session('user_id')

            ]);

            $user = $query->fetch(PDO::FETCH_OBJ);

         if ($user && bcrypt_verify_password($current_password, $user->hashed_password)) {
             
             $query = $db->prepare("UPDATE users 
                                SET password = :password
                                WHERE id = :id");
         $query->execute([

             'password' => bcrypt_hash_password($new_password),
             'id' =>get_session('user_id')
            ]);
         set_flash("Votre mot de passe a été bien modifier");
         redirect('profile.php?id='.get_session('user_id'));

             }else{
                save_input_data();

                $errors[] ="Le mot de passe actuel indiqué est incorrect";
             }
        }

         
     }else{
     	save_input_data();

     	$errors[] ="Veillez remplir tout les chmps marqués d'un (*)";
     }
      
}else{
      clear_input_data();//à son arrivé aucun champ de devra être pre-remplis(users)
}

require('views/change_password.view.php');