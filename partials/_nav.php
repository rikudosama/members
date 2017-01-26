<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Espace membre, gerer les membres de son site web">
    <meta name="Author" content="Lengam Jean Bonaventure">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>
        <?=
          isset($title)
          ?$title.' - '.WEBSITE_NAME :
          WEBSITE_NAME.' -simple,rapide,facile,efficace!';
        ?>
    </title>

    <!-- Bootstrap -->
    <link href="assets/css/app.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/main.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>

    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">Espace Membre</a>
                <ul class="nav navbar-nav">
                  <li><a href="list_users.php">Liste des membres</a></li>
                </ul>
            </div>
            <div id="navbar" class="collapse navbar-collapse">
                <ul class="nav navbar-nav pull-right">
                    <li><a href="index.php">Acueil</a></li>
                    <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="caret"></span></a>
                <ul class="dropdown-menu">
                  <li><a href="profile.php"><i class="fa fa-user"></i> Mon profile</a></li>
                  <li><a href="change_password.php"><i class="fa fa-cog"></i> changer mon mot de passe</a></li>
                  <li><a href="edit_user.php?id=<?= get_session('user_id')?>"><i class="fa fa-pencil"></i> Edition de profil</a></li>
                  <li role="separator" class="divider"></li>
                  <!--<li class="dropdown-header">Nav header</li>-->
                  <li><a href="logout.php"><i class="fa fa-sign-out"></i> Déconnection</a></li>
                <?php endif; ?>
                <?php if(!isset($_SESSION['user_id'])): ?>
                <li><a href="login.php"><i class="fa fa-sign-in"></i> Connexion</a>
                </li>
              <?php endif; ?>
                </ul>
              </li>
                </ul>
            </div>
        </div>
    </nav>
