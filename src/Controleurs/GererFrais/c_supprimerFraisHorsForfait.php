<?php
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
//$idFrais = filter_input(INPUT_GET, 'idFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
$pdo->supprimerFraisHorsForfait($id);
header("Refresh: 0;URL=/gererfrais");