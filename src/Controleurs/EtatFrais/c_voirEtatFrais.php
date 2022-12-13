<?php
use Modeles\PdoGsb;
use Outils\Utilitaires;

include PATH_VIEWS . 'v_entete.php';
$pdo = PdoGsb::getPdoGsb();
$idVisiteur = $_SESSION['idVisiteur'];
$leMois = filter_input(INPUT_POST, 'lstMois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
$moisASelectionner = $leMois;
include PATH_VIEWS . 'v_listeMois.php';
$lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idVisiteur, $leMois);
$lesFraisForfait = $pdo->getLesFraisForfait($idVisiteur, $leMois);
$lesInfosFicheFrais = $pdo->getLesInfosFicheFrais($idVisiteur, $leMois);
$numAnnee = substr($leMois, 0, 4);
$numMois = substr($leMois, 4, 2);
$libEtat = $lesInfosFicheFrais['libEtat'];
$montantValide = $lesInfosFicheFrais['montantValide'];
$nbJustificatifs = $lesInfosFicheFrais['nbJustificatifs'];
$dateModif = Utilitaires::dateAnglaisVersFrancais($lesInfosFicheFrais['dateModif']);
include PATH_VIEWS . 'v_etatFrais.php';
