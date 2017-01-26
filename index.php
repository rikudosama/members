<?php

session_start();
//on inclut tout les fichier fonction comme basse de donnée
require('includes/init.php');
include('filters/guest_filter.php');
require 'vendor/autoload.php';
//si le formulaire d'inscription a été soumis
if (isset($_POST['register'])) {

	//si tout les champs ont été remplis
	//if all the field are not empty

	if (not_empty(['name', 'pseudo', 'email', 'password', 'password_confirm'])) {

		$errors = [];//tableau contenant l'ensemble des erreurs

		extract($_POST);

    //si le pseudo ne vaut pas 3 caractères
		if (mb_strlen($pseudo) < 3) {
			$errors[] = "Votre pseudo trop court! (minimum 3 caractères)";
		}
    //si l'email est valide
		if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {

			$errors[] = "Votre adresse email est non valide!";
		}
  //si le mot de passe est inferieur à 6 caractères
		if (mb_strlen($password) < 6) {
			$errors[] = "Votre mot de passe trop court! (minimum 6 caractères) ";
		}else{
			if ($password != $password_confirm) {

				$errors[] = "Les 2 mots de passe ne concordent pas";
			}
		}
    //si pseudo est deja pris
		if (is_already_in_use('pseudo', $pseudo, 'members')) {
			$errors[] = "Ce pseudonyme est déja utilisé !";
		}

    //si l'email est deja pris
		if (is_already_in_use('email', $email, 'members')) {
			$errors[] = "cette adresse E-mail déja utilisé !";
		}
    //si nous n'avons aucun erreur
		if (count($errors) == 0) {
			//envoi d'un mail d'activation

      $to = $email;

      $subject = WEBSITE_NAME. "- ACTIVATION DE COMPTE";

      $password = bcrypt_hash_password($password);

      $token = sha1($pseudo.$email.$password);

      ob_start();
      require('tmpl/emails/activation.tmpl.php');
      $content = ob_get_clean();

      $headers = 'MIME Version 1.0'. "\r\n";

      $headers = 'Content-type: text/html;charset=iso-8859-1'."\r\n";

      mail($to, $subject, $content, $headers);

			//on informe l'utilisateur pour qu'il verifi sa boite mail
			set_flash("Un  mail d'activation vous a été envoyé !", 'success');

			$query = $db->prepare('INSERT INTO members(name, pseudo, email, password) VALUES(:name, :pseudo, :email, :password)');
			$query->execute([
                'name'=>$name,
                'pseudo'=>$pseudo,
                'email'=>$email,
                'password'=>$password
				]);

			redirect('index.php');
		}else{
            save_input_data();
        }
	}else{
    //si tout les champs n'ont pas été remplis
		$errors[] = "Veillez SVP remplir tout les champs!";
    //on garde les champs pré-remplis avec les données entrées
		save_input_data();
	}

}else{
  //on efface les données dans le formulaire si le membre vient d'arriver
	clear_input_data();
}


?>



<?php require('views/index.view.php');?>
