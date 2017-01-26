<?php $title="Accueil";?>
<?php include('partials/_nav.php');?>
<?php include('partials/_flash.php');?>

    <div class="container">
      <div class="row">
      	<div class="col-lg-6 col-md-6">
      		<form data-parsley-validate class="col-lg-12" autocomplete="off" method="post" action="index.php">
      		<legend>Inscription</legend>
          <?php include('partials/_errors.php');?>

            <!--name fild-->
      			<div class="form-group col-lg-12">
              <i class="fa fa-edit"></i>
      				<input id="name" name="name" type="text" class="form-control" value="<?= get_input('name') ?>" required="required" />
              <label for="name"> Votre Nom de famille :</label>
      			</div>
            <!--Pseudo fild-->
      			<div class="form-group col-lg-12">
              <i class="fa fa-user"></i>
      				<input id="pseudo" name="pseudo" type="text"  class="form-control"  data-parsley-trigger="change" data-parsley-minlength="3" value="<?= get_input('pseudo') ?>"  required="required" />
              <label for="pseudo"> choisissez un pseudonyme pour ce site :</label>
      			</div>
            <!--E-mail  fild-->
      			<div class="form-group col-lg-12">
              <i class="fa fa-envelope"></i>
      				<input id="email" name="email" type="email" class="form-control" data-parsley-trigger="keypress" value="<?= get_input('email') ?>" required="required" />
              <label for="email">Saisissez votre adresse mail :</label>
      			</div>
            <!--password fild-->
      			<div class="form-group col-lg-12">
      				<i class="fa fa-lock"></i>
      				<input type="password" id="password" name="password" class="form-control" required="required" />
              <label for="password" >Votre mot de passe :</label>
      			</div>
            <!--password confirmation fild-->
      			<div class="form-group col-lg-12">
      				<i class="fa fa-lock"></i>
      				<input type="password" id="password_confirm" name="password_confirm" class="form-control" data-parsley-trigger="keypress" required="required" data-parsley-equalto="#password" />
              <label for="password_confirm" >Confirmez votre mot de passe :</label>
      			</div>
      			<div class="form-group">
      				<button type="submit" class="btn btn-success btn-block" name="register"><span class="glyphicon glyphicon-ok-sign"> S'inscrire</span></button>
      			</div>
						<div class="pull-right">
					   <a href="login.php">Connecter vous !</a>
					  </div>
      		</form>
      	</div>
      	<div class="jumbotron col-lg-6 col-md-6">
      		<legend><?=WEBSITE_NAME?>???</legend>
      		<div>
      			 <p>bienvenu sur notre espace membre 😄.Nous mettons cette plateforme à la disposition du grand public ☜.<br/>
            Gérer vos membres et amuser vous avec ce script qui à la fois celui des teachers du net et du rikudo.<br/>
          sans plus attendre <a href="http://github.com/espace_membre">Télécharger <strong>cet espace membre☔</strong></a> et gagner en temps.”</p>
          <p>
          	si vous n'avez pas de compte remplisez le ☜ formulaire avec le titre <strong>inscription</strong>.<br/>
          </p>
          <em>Je sais mon design est impeu mama miya je ne suis pas doué donc on fera avec 😄😄😄!!!</em>
      		</div>
      	</div>
      </div>

    </div><!-- /.container -->


   <?php include('partials/_footer.php');?>
