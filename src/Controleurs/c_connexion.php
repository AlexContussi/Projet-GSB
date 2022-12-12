<?php

/**
 * Gestion de la connexion
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

use Modeles\PdoGsb;
use Outils\Utilitaires;

        $pdo = PdoGsb::getPdoGsb();
        $login = filter_input(INPUT_POST, 'login', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mdp = filter_input(INPUT_POST, 'mdp', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        if (!password_verify($mdp, $pdo->getMdpVisiteur($login))) {
            Utilitaires::ajouterErreur('Login ou mot de passe incorrect');
            Utilitaires::journaliser("Connexion échouée pour le login : " . $login . " à partir de l'ip :" . $_SERVER['REMOTE_ADDR']);
            include PATH_VIEWS . 'v_connexion.php';
            include PATH_VIEWS . 'v_erreurs.php';

        } else {
            $visiteur = $pdo->getInfosVisiteur($login);
            $id = $visiteur['id'];
            $nom = $visiteur['nom'];
            $prenom = $visiteur['prenom'];
            $role = $visiteur['role'];
            Utilitaires::connecter($id, $nom, $prenom,$role);
            $email = $visiteur['email'];
            $code = rand(1000, 9999);
            $pdo->setCodeA2f($id, $code);
            mail($email, '[GSB-AppliFrais] Code de vérification', "Code : $code");
            include  PATH_VIEWS . 'v_code2facteurs.php';
        }

