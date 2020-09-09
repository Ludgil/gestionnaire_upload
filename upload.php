<?php
require_once('includes/db_lite_connection.php');
include "functions/functions.php";

if(!empty($_FILES)){
    $files= niceArrayForFile($_FILES['file']);
    $max_length = 5000000000000;
    // array se trouvant les extensions de fichier ne pouvant pas être accepter 
    $not_allowed = array('php', 'js','sql', 'py', 'exe', 'html', 'msi', 'dll', 'ini');// à compléter

    foreach($files as $file) {
        $date = new DateTime();
        $timestamp = $date->getTimestamp();
        $file_name = $file['name'];
        $file_length = $file['size'];
        $error_file = $file['error'];
         //recupératon du nom du fichier sans l'extension
        $file_name_without_ext = pathinfo($file_name, PATHINFO_FILENAME);
        $file_name_without_ext = normalize_filename($file_name_without_ext);
        //récupération de l'extension du fichier
        $extension = pathinfo($file_name, PATHINFO_EXTENSION);
        $extension = strtolower($extension);
        //Si l'extension ne se trouve pas dans le tableau on continue et on check une autre condition
        if(!in_array($extension, $not_allowed)){ 
            // si il n'y a pas d'erreur dans le fichier on continue et on check une autre condition
            if($error_file === 0){
                // on regarde si la taille du fichier est plus petite que la taille autorisée, si oui on continue, si non => erreur
                if($file_length < $max_length){
                    // création du chemin 
                    $target_dir = 'uploads/';
                    if(is_dir($target_dir)){
                        $file_name_db = $file_name_without_ext.'_'.$timestamp.'.'.$extension;
                        $target_file = $target_dir . $file_name_without_ext.'_'.$timestamp.'.'.$extension;
                        if(move_uploaded_file($file['tmp_name'], $target_file)){
                            $day_date = date('d-m-Y');
                            $queryInsertFile = "INSERT INTO note (chemin, nom_fichier, date ) VALUES('$target_file', '$file_name_db', '$day_date')";   
                            $insertFile = $bdd->prepare($queryInsertFile);
                            $insertFile->execute();  
                          echo json_encode($target_file);
                        }else{
                          http_response_code(500);
                          echo  $error = "Erreur lors de l'upload";
                        }
                    }else{
                        mkdir($target_dir, 0777);
                        $target_file = $target_dir . $file_name_without_ext.'_'.$timestamp.'.'.$extension;
                        if(move_uploaded_file($file['tmp_name'], $target_file)){
                          echo   $success = 'Upload effectué avec succès !';
                        }else{
                          http_response_code(500);
                        echo  $error = "Erreur lors de l'upload";
                        }
                    }
                }else{
                  http_response_code(413);
                  echo   $error = 'Le fichier est trop gros';
                }
            }else{
              http_response_code(500);
              echo  $error = "Il y a une erreur lors de l'upload {$error_file}";
            }
        }else{
          http_response_code(415);
          echo  $error = 'Vous devez uploader un fichier de type png, gif, jpg, jpeg, txt, docx...';
        }
    }
}

