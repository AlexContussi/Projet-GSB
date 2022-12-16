 <?php 
 use Modeles\PdoGsb;
 $pdo = PdoGsb::getPdoGsb();
$dateselected = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idvisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pdo->validerFicheFrais($idvisiteur, $dateselected);
header("Refresh: 0;URL=/validerFrais");