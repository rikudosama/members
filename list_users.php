<?php
session_start();
$title = "list des membres";
require('includes/init.php');


//here we have the pagination systeme
$req = $db->query("SELECT id FROM members WHERE active = '1'");

  $nbre_total_members = $req->rowCount();

  $nbre_members_par_page = 12;

  $nbre_pages_max_gauche_et_droite = 4;

  $last_page = ceil($nbre_total_members / $nbre_members_par_page);

  if(isset($_GET['page']) && is_numeric($_GET['page'])){
    $page_num = $_GET['page'];
  } else {
    $page_num = 1;
  }

  if($page_num < 1){
    $page_num = 1;
  } else if($page_num > $last_page) {
    $page_num = $last_page;
  }

  $limit = 'LIMIT '.($page_num - 1) * $nbre_members_par_page. ',' . $nbre_members_par_page;

  $query = $db->query("SELECT id, pseudo, email, avatar
                       FROM members WHERE active='1'
                       ORDER BY pseudo $limit");

  $members = $query->fetchAll(PDO::FETCH_OBJ);

  $pagination = '<nav class="text-center"><ul class="pagination">';

  if($last_page != 1){
    if($page_num > 1){
      $previous = $page_num - 1;
      $pagination .= '<li><a href="list_users.php?page='.$previous.'">Précédent</a></li>';

      for($i = $page_num - $nbre_pages_max_gauche_et_droite; $i < $page_num; $i++){
        if($i > 0){
          $pagination .= '<li><a href="list_users.php?page='.$i.'">'.$i.'</a></li>';
        }
      }
    }

    $pagination .= '<li class="active"><a href="#">'.$page_num.'</a></li>';

    for($i = $page_num+1; $i <= $last_page; $i++){
      $pagination .= '<li><a href="list_users.php?page='.$i.'">'.$i.'</a></li>';

      if($i >= $page_num + $nbre_pages_max_gauche_et_droite){
        break;
      }
    }

    if($page_num != $last_page){
      $next = $page_num + 1;
      $pagination .= '<li><a href="list_users.php?page='.$next.'">Suivant</a></li>';
    }
  }
  $pagination .='</ul></nav>';
require('views/list_users.view.php');
?>
