<?php

/**
 * Gestion de l'accueil
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
$estConnecte = Utilitaires::estConnecte();

if ($estConnecte) {
    include_once PATH_VIEWS . 'v_entete.php';
} else {
    header("Location : URL=/");
}
