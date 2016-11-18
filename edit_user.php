<?php
session_start();

$title = "edition de profile";
require('includes/init.php');
include('filters/auth_filter.php');
if (! empty($_GET['id'])) {
    //recuperation du fameux user en base de donnée
    $user = find_user_by_id($_GET['id'] && $_GET['id'] === get_session('user_id'));

    if (!$user) {
        //si aucun membre n'a cette identifiant recuperer on redirige le fameu memre la page d'inscription ici (index.php)
        redirect('index.php');
    }
}else{
    // on le redirige vers la page de profile en ajoutant l'id du fameu membre stocker en session avec $_SESSION['user_id']
    redirect('profile.php?id='.get_session('user_id'));
}


//si le formulaire d'inscription a été soumis
if (isset($_POST['update'])) {

	$errors = [];

      //si tout les champs ont été remplis

      if (not_empty(['firstname', 'name', 'pseudo', 'city', 'country', 'sex', 'bio'])) {
       
         extract($_POST);

         $query = $db->prepare("UPDATE users 
         	                    SET firstname = :firstname,
         	                    name = :name, pseudo = :pseudo, 
         	                    city = :city, country = :country, 
         	                    sex = :sex, twitter = :twitter, github = :github, facebook = :facebook, 
         	                    website = :website, available_for_hiring = :available_for_hiring, bio = :bio
         	                    WHERE id = :id");
         $query->execute([

             'firstname' => $firstname,
             'name' => $name,
             'pseudo' => $pseudo,
             'city' => $city,
             'country' => $country,
             'sex' => $sex,
             'twitter' => $twitter,
             'github' => $github,
             'facebook' => $facebook,
             'website' => $website,
             'available_for_hiring' => !empty($available_for_hiring)? '1' :'0',
             'bio' => $bio,
             'id' =>get_session('user_id')
            ]);
        set_flash("Félicitation,votre profile a été mis à jour");
        redirect('profile.php?id='.get_session('user_id'));

     }else{
     	save_input_data();

     	$errors[] ="Veillez remplir tout les chmps marqués d'un (*)";
     }
      
}else{
      clear_input_data();//à son arrivé aucun champ de devra être pre-remplis(users)
}

require('views/edit_user.view.php');