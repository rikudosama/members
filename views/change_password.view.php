<?php $title = "modification de mot de passe";?>
<?php include('partials/_nav.php');?>
<div id="main-content">
  <div class="container">
    <div class="row">
      <div class="col-md-6 col-md-offset-3">
         <div class="panel panel-info">
           <div class="panel-heading">
             <h3 class="panel-title">Modifier mon mot de passe</h3>
           </div>
           <div class="panel-body">
             <?php include('partials/_errors.php');?>
             <form data-parsley-validate method="post" class="well" autocomplete="off">
               <div class="form-group">
                       <label for="current_password">Mot de passe actuel<span class="text-danger"> *</span></label>
                       <input type="password" name="current_password" class="form-control" id="current_password" required="required" />
                </div>
               <div class="form-group">
                       <label for="new_password">Nouveau mot de passe<span class="text-danger"> *</span></label>
                       <input type="password" name="new_password" class="form-control" id="new_password" required="required" data-parsley-minlength="6" data-parsley-trigger="keypress" />
               </div>
               <div class="form-group">
                       <label for="new_password_confirmation">Confirmer votre nouveau mot de passe<span class="text-danger"> *</span></label>
                       <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required="required" data-parsley-equalto="#new_password" data-parsley-trigger="keypress" />
               </div>
               <button type="submit" class="btn btn-block btn-info" name="change_password"><span class="glyphicon glyphicon-ok-sign"></span> Valider</button>
             </form>
           </div>
         </div>
       </div>
    </div>
  </div>
</div>

<?php include('partials/_footer.php'); ?>