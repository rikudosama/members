<?php
/**
 * Created by PhpStorm.
 * User: lengam bonaventure
 * Date: 20/08/2016
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
