<?php
include('includes/header.php');
?>
    <main class="container d-flex align-items-center  vh-100">
        <div class="container-fluid">
            <div class="row d-flex flex-column justify-content-center align-items-center">
                <div class="col-6">
                        <!-- Formulaire d'upload -->
                        <form  method="POST" action="upload.php" id="form" enctype="multipart/form-data" class="dropzone">
                            <div class="fallback">
                                <input type="file" class="form-control-file" name="file" multiple>
                                <input type="submit" class="btn btn-success btn-block" id="button" value="Envoyer" name="submit">
                            </div>
                        </form>
                        <div class="alert alert-success" id="success" role="alert" style="display:none">Le fichier a été upload</div>
                        <div class="alert alert-danger" id="error" role="alert" style="display:none"></div>
                        <!-- end form upload -->
                </div>
            </div>
            <div class="row d-flex justify-content-center ">
                <a href="files.php" class="btn btn-primary mt-3">Vers les fichiers</a>
            </div>

            <?php // MODAL  ?>
            <div class="modal fade" id="ModalCenter" tabindex="-1" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <?php // titre du modal ajouter via javascript ?>
                            <h5 class="modal-title"></h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <form id="form-note" method="post">
                            <div class="modal-body d-flex justify-content-center">
                                <textarea name="note" id="note" cols="60" rows="10"></textarea>
                            </div>
                            <div class="modal-footer">
                                <input type='hidden' id="nameFile" name='name_file' value="">
                                <button type="button" class="btn btn-primary" id="submit-modal">Envoyer</button>
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>
<?php
include('includes/footer.php');
?>