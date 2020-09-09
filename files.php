<?php
ob_start();
include('includes/header.php');
?>
<main class="container d-flex flex-column justify-content-center align-items-center vh-100">
    <?php 
    // Include du tableau
        include('includes/table_files.php');
    ?>
    <div class="row d-flex justify-content-center">
        <a href="index.php" class="btn btn-primary mt-3 mb-3">Retour</a>
    </div>
</main>
<?php
include('includes/footer.php');
?>