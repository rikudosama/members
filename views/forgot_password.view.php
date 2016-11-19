<?php $title = "modification de mot de passe";?>
<?php include('partials/_nav.php');?>
<?php include('partials/_flash.php');?>
<div id="main-content">
  <div class="container">
    <div class="row">
      <div class="col-md-9 col-md-offset-1">
         <div class="panel panel-info">
           <div class="panel-heading">
             <h3 class="panel-title">Réinitialiser mon mot de passe</h3>
           </div>
           <div class="panel-body">
             <form data-parsley-validate class="form-inline" method="post">
                 <div class="form-group">
                 <label class="text-danger" for="forgot">Entrez votre pseudo ou E-mail * :</label>
                 <input type="forgot" name="forgot" size="100" class="form-control" id="forgot"
                 placeholder="Peudo ou email ici" required="required" >
                 </div>
                 <button type="submit" name="renit" class="btn btn-info pull-right"><i class="fa fa-search"></i> Rechercher</button>
            </form>
           </div>
         </div>
       </div>
    </div>
  </div>
</div>

<?php include('partials/_footer.php'); ?>