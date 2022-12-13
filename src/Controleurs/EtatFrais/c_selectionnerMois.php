<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$idVisiteur = $_SESSION['idVisiteur'];
$lesMois = $pdo->getLesMoisDisponibles($idVisiteur);
$lesCles = array_keys($lesMois);
$moisASelectionner = $lesCles[0];
include PATH_VIEWS .'v_entete.php';
include PATH_VIEWS . 'v_listeMois.php';