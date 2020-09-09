<?php 
require_once("includes/db_lite_connection.php");
// si la remarque est envoyée mettre à jour la colonne 'note'
if(isset($_POST['note'])){
    $note = $_POST['note'];
    $name_file  = $_POST['name_file'];
    $queryInsertNote = "UPDATE note SET note = '$note' WHERE nom_fichier = '$name_file'";   
    $insertNote = $bdd->prepare($queryInsertNote);
    $insertNote->execute();  
}
?>