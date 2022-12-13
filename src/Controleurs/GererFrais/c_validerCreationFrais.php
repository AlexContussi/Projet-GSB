<?php

use Modeles\PdoGsb;
use Outils\Utilitaires;

$idVisiteur = $_SESSION['idVisiteur'];
$mois = Utilitaires::getMois(date('d/m/Y'));
$pdo = PdoGsb::getPdoGsb();
$dateFrais = Utilitaires::dateAnglaisVersFrancais(
            filter_input(INPUT_POST, 'dateFrais', FILTER_SANITIZE_FULL_SPECIAL_CHARS)
        );
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_VALIDATE_FLOAT);
        Utilitaires::valideInfosFrais($dateFrais, $libelle, $montant);
        if (Utilitaires::nbErreurs() != 0) {
            include PATH_VIEWS . 'v_erreurs.php';
            header("Refresh: 0;URL=/gererFrais");
        } else {
            header("Refresh: 0;URL=/gererFrais");
            $pdo->creeNouveauFraisHorsForfait($idVisiteur, $mois, $libelle, $dateFrais, $montant);
        }
