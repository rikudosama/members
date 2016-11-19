<?php
session_start();
//on inclut tout les fichier fonction comme basse de donnée
require('includes/init.php');
include('filters/guest_filter.php');
require 'vendor/autoload.php';
//si le formulaire d'inscription a été soumis
if (isset($_POST['renit'])) {

    //si tout les champs ont été remplis
    //if all the field are not empty

    if (not_empty(['forgot'])) {

        extract($_POST);

        $query = $db->prepare("SELECT pseudo, email, password AS hashed_password
                         FROM members WHERE (pseudo = :forgot OR email = :forgot) 
                         AND active = '1'
                         ");
        $query->execute([
                  'forgot' =>$forgot
            ]);
        $member = $query->fetch(PDO::FETCH_OBJ);

 
        if ($member) {
            //envoi d'un mail de reinitialisation
            $token = sha1($member->pseudo.$member->email.$member->hashedpassword);
             // On créé une nouvelle instance de la classe
            $mail = new PHPMailer();
 
            // De qui vient le message, e-mail puis nom
            $mail->From = "Espace membres !";
            $mail->FromName = WEBSITE_NAME;
 
            // Définition du sujet/objet
            $mail->Subject = WEBSITE_NAME. "- REINITIALISATION DE MOT DE PASSE";
 
            // On lit le contenu d'une page html
            $body = file_get_contents('tmp/emails/reinitialisation.tmpl.php');
 
            // On définit le contenu de cette page comme message
            $mail->MsgHTML($body);
 
            // On pourra définir un message alternatif pour les boîtes de
            // messagerie n'acceptant pas le html
            $mail->AltBody = "Ce message est au format HTML, votre messagerie n'accepte pas ce format.";
 
            // Il reste encore à ajouter au moins un destinataire
            $mail->AddAddress($member->email);
 
           // Pour finir, on envoi l'e-mail
            $mail->send();


            //on informe l'utilisateur pour qu'il verifi sa boite mail
            set_flash("Un  mail vous a été envoyé! Veillez verifier votre boite email SVP", 'success');

            redirect('index.php');
        }else{
         set_flash("Aucun utilisateur pour ces information", "warning");
            save_input_data();
        }
    }

}else{
    clear_input_data();
}


?>



<?php require('views/forgot_password.view.php');?>
