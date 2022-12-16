<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
$montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$dateTemp = strtotime($date);
$pdo->setLigneHorsForfait($id, htmlspecialchars_decode($libelle), date("Y-m-d", $dateTemp), $montant);
header("Refresh: 0;URL=/validerFrais");
