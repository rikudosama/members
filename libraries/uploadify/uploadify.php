<?php
session_start();
require '../../config/database.php';
/*
Uploadify
Copyright (c) 2012 Reactive Apps, Ronnie Garcia
Released under the MIT License <http://www.opensource.org/licenses/mit-license.php>
*/

// Define a destination(defintion de la destination)
$targetFolder = '/images/'.$_SESSION['user_id']; // Relative to the root(le chemin relatif du fichier)
$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['avatar']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $targetFolder;

	if(!file_exists($targetPath)){
		mkdir($targetPath, 0755, true);
	}
	// Validate the file type(Validatetion du fichier)
	$fileTypes = array('jpg','jpeg','gif','png'); // File extensions,(extensions des fichiers)
	$fileParts = pathinfo($_FILES['avatar']['name']);

	$randomFileName = md5(uniqid(rand())) .'.' .$fileParts['extension'];
	$targetFile = rtrim($targetPath,'/') . '/' . $randomFileName;

	if (in_array($fileParts['extension'],$fileTypes)) {
		if(move_uploaded_file($tempFile,$targetFile)){

           $query = $db->prepare('UPDATE members SET avatar = ? WHERE id = ?');
           $query->execute([$targetFolder.'/'.$randomFileName, $_POST['user_id']]);
           $_SESSION['avatar'] = $targetFolder.'/'.$randomFileName;
		}

	} else {
		echo 'Type de fichier non supporté.';
	}
}
?>
