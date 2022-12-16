<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$dateSelected = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idVisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idLigneFraisHorsForfait = filter_input(INPUT_POST, 'idLigneFraisHorsForfait', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pdo->refuserLigneHorsForfait($idLigneFraisHorsForfait,$idVisiteur);
header("Refresh: 0;URL=/voirFrais?idvisiteur=".$idVisiteur."&dateselected=".$dateSelected."");
