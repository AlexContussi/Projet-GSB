<?php

/**
 * Gestion de la déconnexion
 *
 * PHP Version 8
 *
 * @category  PPE
 * @package   GSB
 * @author    Réseau CERTA <contact@reseaucerta.org>
 * @author    José GIL <jgil@ac-nice.fr>
 * @copyright 2017 Réseau CERTA
 * @license   Réseau CERTA
 * @version   GIT: <0>
 * @link      http://www.reseaucerta.org Contexte « Laboratoire GSB »
 */

use Outils\Utilitaires;

        if (Utilitaires::estConnecte()) {
            Utilitaires::deconnecter();
            include PATH_VIEWS . 'v_deconnexion.php';
        } else {
            Utilitaires::ajouterErreur("Vous n'êtes pas connecté");
            header("Location : URL=/");
            include PATH_VIEWS . 'v_erreurs.php';
        }
