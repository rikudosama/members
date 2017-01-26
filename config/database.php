<?php
/**
 * Created by sublime text.
 * User: lengam bonaventure
 * Date: 28/01/2017
 * Time: 13:18
 */
try{
    //database credentials

    define('DB_HOST', 'localhost');

    define('DB_NAME', 'espace');

    define('DB_USERNAME', 'root');

    define('DB_PASSWORD', '');






    $db =  new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME,DB_USERNAME,DB_PASSWORD);

    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch (PDOException $e){
    die('erreur: ' .$e->getMessage());
}
/*decommentez cette ligne si vous preferer faire
 ->$query->fetch();au lieu de
 $query->fetch(PDO::FETCH_OBJ); a chaque fois moi j'aime la seconde methode
 bon c'est juste preference!!!
$pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
*/
