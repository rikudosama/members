<?php
require('config/database.php');
require('includes/functions.php');
require('includes/constants.php');

if(!empty($_COOKIE['pseudo']) && !empty($_COOKIE['user_id'])){
     $_SESSION['pseudo'] = $_COOKIE['pseudo'];
     $_SESSION['user_id'] = $_COOKIE['user_id'];
     $_SESSION['avatar'] = $_COOKIE['avatar'];
}

auto_login();