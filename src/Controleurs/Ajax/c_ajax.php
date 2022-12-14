<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();

$id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$totalFraisForfait = $pdo->getTotauxFicheFraisForfait($id, $mois);
$totalFraisHorsForfait = $pdo->getTotauxFicheFraisHorsForfait($id, $mois);
$utilisateur = $pdo->getUtilisateurFicheFrais($id);

include PATH_VIEWS . 'Ajax/v_fraisTotauxAjax.php';
