<?php
require_once('db_lite_connection.php');
// array contenant des extensions de fichier utiliser à la ligne 97
$ext = ['docx', 'rar', 'zip', 'csv', 'xlsx', 'txt', 'mp3', 'mp4', 'avi', 'sql', 's3db', 'db', 'html', 'php', 'js'];
// création du listing des fichiers contenu dans le dossier du client choisi

// query pour récupérer les remarques
// le fetch se situe plus bas dans la table 
$queryGetNote ="SELECT * FROM note";
$getNote = $bdd->prepare($queryGetNote);
$getNote->execute();

// check les fichiers dans le dossier upload pour savoir si le dossier est vide ou non, Si le dossier est vide 
// il sera afficher qu'il n'y a aucun fichier
if ($handle = opendir('uploads/')){
    while (false !== ($file = readdir($handle))){
        if ($file != "." && $file != ".."){
            $files[] = $file;
        }
    }
    closedir($handle);
}
$target_dir = 'uploads/';
 
// permet de télécharger un fichier zip avec les fichiers séléctionnés 
if(isset($_POST['downloads'])){
    // nom du fichier zip 
    $zipname = date('d-m-y').'.zip';
    // création de l'objet zip
    $zip = new ZipArchive();
    $zip->open($zipname, ZIPARCHIVE::CREATE);
    // loop dans la séléction 
    foreach ($_POST['downloads'] as $key => $val){
    // récupération du chemin du fichier 
    $file =  $val;
    // ajout du fichier ( utilisation de basename pour récupérer le nom du fichier sans le chemin)
    $zip->addFromString(basename($file),file_get_contents($file));
    }
    $zip->close();
    // header pour lancer le téléchargement du zip
    header($_SERVER['SERVER_PROTOCOL'].' 200 OK');
    header('Content-Type: application/zip');
    header('Content-Transfer-Encoding: binary');
    header("Content-Length: ".filesize($zipname));
    header("Content-Disposition: attachment; filename=\"".$zipname."\"");
    ob_clean();
    readfile($zipname);
    // supression du zip dans le dossier racine
    unlink($zipname);
}
?>
        <div class="row d-flex justify-content-center">
            <?php if(!empty($files)){?>
            <form method="post" action='files.php'>
                    <table id="table_id" class="table table-bordered table-hover mt-3">
                        <thead>
                            <tr>
                                <th>
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" id="select_all">
                                        <label class="form-check-label" for="select_all">Tout séléctionner</label> 
                                    </div> 
                                </th>
                                <th>Téléchargement</th>
                                <th>Supprimer</th>
                                <th>Nom du fichier</th>
                                <th>Remarque</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <!-- fetch des notes -->
                    <?php   while($row = $getNote->fetch(PDO::FETCH_BOTH)){ 
                                $path_file = $row['chemin'];
                                $name_file = $row['nom_fichier'];
                                $remarque = $row['note'];
                                $day_date = $row['date'];
                        ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" name="downloads[]" class='select_one' value="<?= $path_file ?>">
                                    </td>
                                    <td>
                                        <a href="<?= $path_file ?>" class="btn btn-success" download>télécharger</a>
                                    </td>
                                    <td>
                                        <?php //voir javascript pour la suppression ?>
                                        <input type="button" data-value="<?= $path_file ?>" name="delete" class="btn btn-danger btn_delete" value="Supprimer">      
                                    </td>
                                    <td>
                                        <p><?= $name_file ?></p>
                                        
                                <?php // si l'extension n'est pas dans l'array $ext alors ne pas montrer l'apperçu ( pour éviter que chrome lance le téléchargement du fichier par mouseover)
                                    if(!in_array(pathinfo($path_file, PATHINFO_EXTENSION), $ext )){ ?>
                                        <div class="box">
                                            <embed src="<?= $path_file ?>" width="250" height="250" />
                                        </div> 
                                <?php } ?>
                                    </td>
                                    <td>
                                        <p><?= $remarque ?></p>
                                    </td>
                                    <td>
                                        <p><?= $day_date ?></p>
                                    </td>
                                </tr>
                                <?php } ?>
                                <tfoot>
                                    <td colspan="6">
                                        <input type="submit" name="submit" id="dl_select" class='btn btn-success'  value="Télécharger la séléction"/>
                                    </td>
                                </tfoot>
                            </tbody>
                        </table>
                    </form>    
    <?php }else{ ?>
            <p class="h2 mt-4 text-center">Aucun fichiers</p>
  <?php  } ?>
        </div>