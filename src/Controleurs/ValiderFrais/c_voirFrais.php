<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
include PATH_VIEWS . 'v_entete.php';
$dateselected = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idvisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lignes = $pdo->getLignesFicheFraisCL($idvisiteur, $dateselected);
$lesFraisHorsForfait = $pdo->getLignesHorsForfaitCL($idvisiteur, $dateselected);
$nbjustificatifs = $pdo->getNbJustificatifs($idvisiteur, $dateselected);;
include PATH_VIEWS . 'v_detailValiderFrais.php';


