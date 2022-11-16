<?php        


$fichesdefrais = $pdo->getAllFicheFraisAValider();
$test = "ok";
include PATH_VIEWS . 'v_validFrais.php';
