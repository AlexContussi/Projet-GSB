<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$etape = filter_input(INPUT_POST, 'etape', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$km = filter_input(INPUT_POST, 'km', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$nui = filter_input(INPUT_POST, 'nui', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$rep = filter_input(INPUT_POST, 'rep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$mois = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$id = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pdo->setLigneFraisForfaitEtape($id, $mois, $etape);
$pdo->setLigneFraisForfaitKm($id, $mois, $km);
$pdo->setLigneFraisForfaitNui($id, $mois, $nui);
$pdo->setLigneFraisForfaitRep($id, $mois, $rep);
header("Refresh: 0;URL=/voirFrais?idvisiteur=".$id."&dateselected=".$mois."");
