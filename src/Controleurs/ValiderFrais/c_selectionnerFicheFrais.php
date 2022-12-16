<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
include PATH_VIEWS . 'v_entete.php';
$dateselected = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idvisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date=null;
$visiteurs = $pdo->getAllVisiteur();
$dateOfTheDay = new DateTime();
$dates = [];
$date1 = date_add($dateOfTheDay, date_interval_create_from_date_string('-1 m'));
for ($index = 1; $index < 14; $index++) {
    $dates[$index] = date_add(new DateTime(), date_interval_create_from_date_string("-" . strval($index) . " month"));
}
include PATH_VIEWS . 'v_validerFrais.php';
