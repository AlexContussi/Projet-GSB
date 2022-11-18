<?php
use Outils\Utilitaires;
use Modeles\PdoGsb;

 $pdo = PdoGsb::getPdoGsb();
 $code = filter_input(INPUT_POST, 'code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if ($pdo->getCodeVisiteur($_SESSION['idVisiteur']) !== $code) {
            Utilitaires::ajouterErreur('Code de vérification incorrect');
            include PATH_VIEWS . 'v_erreurs.php';
            include PATH_VIEWS .'v_code2facteurs.php';
        } else {
            Utilitaires::connecterA2f($code);
            header("Refresh: 0;URL=/accueil");
        }