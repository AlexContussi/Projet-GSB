<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$idLigneFraisHorsForfait = filter_input(INPUT_POST, 'idLigneFraisHorsForfait', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pdo->refuserLigneHorsForfait($idLigneFraisHorsForfait);
header("Refresh: 0;URL=/validerFrais");
