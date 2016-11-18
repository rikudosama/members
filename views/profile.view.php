<?php include('partials/_nav.php');?>
<?php include('partials/_flash.php');?>

<div id="main-content">
    <div class="container">
     <div class="row">
       <div class="col-md-6">
           <div class="panel panel-info">
             <div class="panel-heading">
             <h3 class="panel-title">Page de Profil <?= e($user->pseudo)?> (<?= friends_count($_GET['id']) ?> ami<?=friends_count($_GET['id']) == '1'? '' : 's'?>)</h3>
           </div>
           <div class="panel-body">
             <div class="row">
               <div class="col-md-5">
                 <img src="<?= $user->avatar ? $user->avatar : get_avatar_url(e($user->email)) ?>" alt="<?=e($user->pseudo)?>" class="img-polaroid avatar-md">
               </div>
               <div class="col-md-7">
                      <?php if(!empty($_GET['id']) && $_GET['id'] !== get_session('user_id')): ?>
                        <?php include('partials/_relation_links.php');?>
                 <?php endif; ?>
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
                   $user->facebook ? '<i class="fa fa-facebook"></i>&nbsp;<a href="//facebook.com/'.e($user->facebook).'">'.e($user->facebook).'</a><br/>' : '';
                 ?>
                 <?=
                   $user->website ? '<i class="fa fa-globe"></i>&nbsp;<a href="//'.e($user->website).'">'.e($user->website).'</a><br/>' : '';
                 ?>
                 <?=
                   $user->sex == "H" ? '<i class="fa fa-male"></i>' : '<i class="fa fa-female"></i>';
                 ?>
                 <?=
                   $user->available_for_hiring ? 'Disponible pour emploi' : 'Non disponible pour emploi';
                 ?>
               </div>
               <hr>
               <?php if(!empty($_GET['id']) && $_GET['id'] !== get_session('user_id')): ?>
               <div class="row">
                <div class="col-md-12">
                 <button class="btn btn-info btn-block" id="contact" title="clicker dessus pour envoyer votre message"><i class="fa fa-envelope"></i>  Contacter</button>
                </div>
               </div>
             <?php endif; ?>
             </div>
             <div class="status-post" id="aff">
                 <form data-parsley-validate action="send_message.php?id=<?=$_GET['id'];?>" method="post">
                   <div class="form-group">
                      <label for="message" class="sr-only">Envoyer message</label>
                      <textarea name="message" id="message" rows="3" data-parsley-minlength="3" class="form-control" placeholder="votre message" required="required"></textarea>
                    </div>
                    <div class="form-group status-post-submit">
                      <input type="submit" name="send" value="Envoyer" class="btn btn-info btn-xs">
                    </div>
                 </form>
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
     <div class="col-md-6">
     <?php if(!empty($_GET['id']) && $_GET['id'] === get_session('user_id')): ?>
      <div class="status-post">
       <form data-parsley-validate action="microposts.php" method="post">
         <div class="form-group">
           <label for="content" class="sr-only">Statut</label>
           <textarea name="content" id="content" rows="3" data-parsley-minlength="3" class="form-control" placeholder="Quoi de neuf ?" required="required"></textarea>
         </div>
         <div class="form-group status-post-submit">
           <input type="submit" name="publish" value="publier" class="btn btn-info btn-xs">
         </div>
       </form>
      </div>
    <?php endif;?>

    <?php if (count($microposts) !=0) : ?>
      <?php foreach ($microposts as $micropost) : ?>
        <?php include('partials/_microposts.php'); ?>
      <?php endforeach; ?>
    <?php else : ?>
      <p>Aucune publication pour l'instant ...</p>
    <?php endif; ?>
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
    <script>
       $(document).ready(function() {
       $(".timeago").timeago();

       $("a.like").on("click", function(event){
            event.preventDefault();

            var id = $(this).attr("id");
            var url = 'ajax/micropost_like.php';
            var action =$(this).data("action");
            var micropost_id = id.split("like")[1];

            $.ajax({
              type: 'POST',
              url: url,
              data: {
                micropost_id: micropost_id,
                action: action
              },
              success: function(likers){
                $("#likers_" + micropost_id).html(likers);
                if (action == 'like') {
                  $("#" + id).html("Je n'aime plus").data('action', 'unlike');
                }else{
                  $("#" + id).html("J'aime").data('action', 'like');
                }
              }
            });
       });
    });
    </script>
    <script>
      $("document").ready(function(){
        $("#aff").hide();
        $("#contact").click(function(){
          $("#aff").show();
        });
      });
    </script>