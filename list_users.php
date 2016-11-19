<?php 
session_start();
$title = "list des membres";
require('includes/init.php');

$query = $db->query("SELECT id, pseudo, email, avatar FROM members WHERE active='1' ORDER BY pseudo");

$members = $query->fetchAll(PDO::FETCH_OBJ);



require('views/list_users.view.php');
?>