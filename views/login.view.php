<?php include('partials/_nav.php');?>
<?php include('partials/_flash.php');?>
<div class="container">
       <div class="row">
      	
      		<form data-parsley-validate class="col-lg-6 col-md-6 col-lg-offset-3 col-md-offset-3 col-xm-12 well" autocomplete="off" method="post" >
      		<legend class="text-center">connexion</legend>
                  <?php include('partials/_errors.php');?>
                        
                        <!--identifiant field-->
      			<div class="form-group col-lg-12">
      				<label class="control-label" for="identifiant">pseudo ou adresse email :</label>
      				<input id="identifiant" name="identifiant" type="text" class="form-control"  value="<?= get_input('identifiant') ?>" required="required" />
      			</div>
                        <!--password fild-->
      			<div class="form-group col-lg-12">
      				<label class="control-label" for="password">Votre mot de passe :</label>
      				<input id="password" name="password" type="password" class="form-control" required="required" />
      			</div>
                        <div class="form-group col-lg-12">
                              <label class="form-control" for="remember_me">
                              <input type="checkbox" name="remember_me" id="remember_me" />
                              Garder ma session active
                             </label>
                        </div>
                        <div class="form-group">
      				<button type="submit" class="btn btn-info btn-block" name="login"><span class="glyphicon glyphicon-ok-sign"> Connexion</span></button>
      			</div>
				<div class="pull-left">
				   <a href="index.php">Inscrivez vous !</a>
				</div>
				<div class="pull-right">
				    <a href="forgot_password.php">Mot de passe oublié ?</a>
				</div>
      		</form>
            
       </div>
</div>
<?php include('partials/_footer.php');?>
