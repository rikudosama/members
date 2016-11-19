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

		if (mb_strlen($pseudo) < 3) {
			$errors[] = "Votre pseudo trop court! (minimum 3 caractères)";
		}

		if (! filter_var($email, FILTER_VALIDATE_EMAIL)) {
			
			$errors[] = "Votre adresse email est non valide!";
		}

		if (mb_strlen($password) < 6) {
			$errors[] = "Votre mot de passe trop court! (minimum 6 caractères) ";
		}else{
			if ($password != $password_confirm) {
				
				$errors[] = "Les 2 mots de passe ne concordent pas";
			}
		}

		if (is_already_in_use('pseudo', $pseudo, 'members')) {
			$errors[] = "Ce pseudonyme est déja utilisé !";
		}


		if (is_already_in_use('email', $email, 'members')) {
			$errors[] = "cette adresse E-mail déja utilisé !";
		}
 
		if (count($errors) == 0) {
			//envoi d'un mail d'activation
            $password = bcrypt_hash_password($password);
			$token = sha1($pseudo.$email.$password);
			 // On créé une nouvelle instance de la classe
            $mail = new PHPMailer();
 
            // De qui vient le message, e-mail puis nom
            $mail->From = "Espace membres !";
            $mail->FromName = WEBSITE_NAME;
 
            // Définition du sujet/objet
            $mail->Subject = WEBSITE_NAME. "- ACTIVATION DE COMPTE";
 
            // On lit le contenu d'une page html
            $body = file_get_contents('tmp/emails/activation.tmpl.php');
 
            // On définit le contenu de cette page comme message
            $mail->MsgHTML($body);
 
            // On pourra définir un message alternatif pour les boîtes de
            // messagerie n'acceptant pas le html
            $mail->AltBody = "Ce message est au format HTML, votre messagerie n'accepte pas ce format.";
 
            // Il reste encore à ajouter au moins un destinataire
            $mail->AddAddress($email);
 
           // Pour finir, on envoi l'e-mail
            $mail->send();


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
		$errors[] = "Veillez SVP remplir tout les champs!";
		save_input_data();
	}

}else{
	clear_input_data();
}


?>



<?php require('views/index.view.php');?>
