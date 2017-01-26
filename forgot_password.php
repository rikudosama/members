<?php
session_start();
//on inclut tout les fichier fonction comme basse de donnée
require('includes/init.php');
include('filters/guest_filter.php');
require 'vendor/autoload.php';
//si le formulaire d'inscription a été soumis
if (isset($_POST['renit'])) {
   $errors = [];
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
            //envoi d'un mail d'activation

            $to = $email;

            $subject = WEBSITE_NAME. "- REINITIALISATION DU MOT DE PASSE";

            $password = bcrypt_hash_password($password);

            $token = sha1($pseudo.$email.$password);

            ob_start();
            require('templ/emails/reset.tmpl.php');
            $content = ob_get_clean();

            $headers = 'MIME Version 1.0'. "\r\n";

            $headers = 'Content-type: text/html;charset=iso-8859-1'."\r\n";

            mail($to, $subject, $content, $headers);

            //on informe l'utilisateur pour qu'il verifi sa boite mail
            set_flash("Un  mail vous a été envoyé! Veillez verifier votre boite email SVP <a href=\"login.php\">Connectez-vous</a>", 'success');

            redirect('index.php');
        }else{
         $errors[] = "Desolé vous n'avez pas compte veillez en créer !";
            save_input_data();
        }
    }

}else{
    clear_input_data();
}


?>



<?php require('views/forgot_password.view.php');?>
