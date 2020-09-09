<?php 

// connection db lite

try {
    $bdd = new PDO('sqlite:db/file_note.db');
    $bdd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $bdd->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
 } catch (\PDOException $e) {
    echo "problème lors de la connection à la base de donnée . $e";
 }




