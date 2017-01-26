<?php $title = "modification de mot de passe";?>
<?php include('partials/_nav.php');?>
<?php include('partials/_flash.php');?>
<div id="main-content">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-offset-1">
         <div class="panel panel-primary">
           <div class="panel-heading">
             <h3 class="panel-title">Réinitialiser mon mot de passe</h3>
             <?php require('partials/_errors.php');?>
           </div>
           <div class="panel-body">
           <div class="jumbotron">
             Huum c'est facheux tout ça!!!Mais pas de panique mettez votre pseudo ou votre adresse email et on s'en occupe.Tout ce que vous devrez faire c'est allez dans votre boite et clicquer sur le liens qui vous sera envoyé...
           </div>
             <form data-parsley-validate class="form-inline" method="post">
                 <div class="form-group">
                 <i class="fa fa-search"></i>
                 <input type="forgot" name="forgot" size="100" class="form-control" id="forgot"
                 placeholder="Peudo ou email ici" required="required" >
                 <label class="text-danger" for="forgot">Entrez votre pseudo ou E-mail * :</label>
                 </div>
                 <button type="submit" name="renit" class="btn btn-info pull-right"><i class="fa fa-search"></i> Rechercher</button>
            </form>
           </div>
         </div>
       </div>
    </div>
  </div>
</div>

<?php require('partials/_footer.php'); ?>
