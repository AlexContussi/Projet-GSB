<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$nbJustificatifs = filter_input(INPUT_POST, 'nbJustificatifs', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mois = filter_input(INPUT_POST, 'mois', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idvisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pdo->validerJustificatifs($idvisiteur, $mois, $nbJustificatifs);
header("Refresh: 0;URL=/validerFrais");