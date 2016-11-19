<?php include('partials/_nav.php');?>
<?php include('partials/_flash.php');?>

<div id="main-content">
    <div class="container">
     <div class="row">
       <div class="col-md-12">
           <div class="panel panel-info">
             <div class="panel-heading">
             <h3 class="panel-title">Page de Profil de : <?= e($user->pseudo)?> </h3>
           </div>
           <div class="panel-body">
             <div class="row">
               <div class="col-md-5">
                 <img src="<?= $user->avatar ? $user->avatar : get_avatar_url(e($user->email)) ?>" alt="<?=e($user->pseudo)?>" class="img-polaroid avatar-md">
               </div>
               <div class="col-md-7">
               </div>
             </div>
             <div class="row">
               <div class="col-sm-6">
                 <strong><?=e($user->pseudo) ?></strong><br/>
                 <i></i><a href="mailto:<?=e($user->email, 100) ?>"><?= e($user->email) ?></a><br/>
                 <?=
                   $user->city && $user->country ? '<i class="fa fa-location-arrow"></i>&nbsp;'.e($user->city).' - '.e($user->country).'<br/>' : '';
                 ?><a href="https://www.google.com/maps?q=<?= ($user->city).' '.e($user->country) ?>" target="_blank">Voir sur Google Maps</a>
               </div>
               <div class="col-sm-6">
                 <?=
                   $user->twitter ? '<i class="fa fa-twitter"></i>&nbsp;<a href="//twitter.com/'.e($user->twitter).'">@'.e($user->twitter).'</a><br/>' : '';
                 ?>
                 <?=
                   $user->github ? '<i class="fa fa-github"></i>&nbsp;<a href="//github.com/'.e($user->github).'">'.e($user->github).'</a><br/>' : '';
                 ?>
                 <?=
                   $user->sex == "H" ? '<i class="fa fa-male"></i>' : '<i class="fa fa-female"></i>';
                 ?>
                 <?=
                   $user->available_for_hiring ? 'Disponible pour emploi' : 'Non disponible pour emploi';
                 ?>
               </div>
               <hr>
             </div>
             <div class="row">
               <div class="col-md-12 well">
                 <h4 style="color:black;">Petite description de <?= e($user->pseudo) ?></h4>
                 <p>
                   <?=
                      $user->bio ? nl2br(e($user->bio)) : 'Aucune biographie pour l\'instant';
                   ?>
                 </p>
               </div>
             </div>
           </div>
       </div>
      </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="libraries/sweetalert/sweetalert.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script type="text/javascript" src="assets/js/jquery.timeago.js"></script>
    <script type="text/javascript" src="assets/js/jquery.timeago.fr.js"></script>
    <script type="text/javascript" src="libraries/parsley/parsley.min.js"></script>
    <script type="text/javascript" src="libraries/parsley/i18n/fr.js"></script>
</body>
</html>