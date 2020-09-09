<?php 
require_once('includes/db_lite_connection.php');
if(isset($_POST['delete'])){
    $target = $_POST['delete'];
    $name_file = basename($target);
    $target = realpath($target);
    echo $queryDelete ="DELETE FROM note WHERE nom_fichier = '$name_file'";
    $delete = $bdd->prepare($queryDelete);
    $delete->execute();
    unlink($target);
}