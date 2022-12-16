<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$fichesValidees = $pdo->getFichesValidees();
include PATH_VIEWS . 'v_entete.php';
include PATH_VIEWS . 'v_suivrePaiement.php';