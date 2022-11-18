<?php

/**
 * Vue Entête
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
$role = $_SESSION['role']
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="UTF-8">
        <title>Intranet du Laboratoire Galaxy-Swiss Bourdin</title> 
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./styles/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="./styles/style.css" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <?php
            if ($estConnecte && $role == 1) {
                ?>
            <div class="header">
                <div class="row vertical-align">
                    <div class="col-md-4">
                        <h1>
                            <img src="./images/logo.jpg" class="img-responsive" 
                                 alt="Laboratoire Galaxy-Swiss Bourdin" 
                                 title="Laboratoire Galaxy-Swiss Bourdin">
                        </h1>
                    </div>
                    <div class="col-md-8">
                        <ul class="nav nav-pills pull-right" role="tablist">
                            <li <?php if ($_SERVER['REQUEST_URI'] == '/accueil') { ?>class="active" <?php } ?>>
                                <a href="accueil">
                                    <span class="glyphicon glyphicon-home"></span>
                                    Accueil
                                </a>
                            </li>
                            <li <?php if ($_SERVER['REQUEST_URI'] == '/gererfrais') { ?>class="active"<?php } ?>>
                                <a href="gererfrais">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    Renseigner la fiche de frais
                                </a>
                            </li>
                            <li <?php if ($_SERVER['REQUEST_URI'] == '/etatfrais' || $_SERVER['REQUEST_URI'] == '/voirEtatFrais' ) { ?>class="active"<?php } ?>>
                                <a href="etatfrais">
                                    <span class="glyphicon glyphicon-list-alt"></span>
                                    Afficher mes fiches de frais
                                </a>
                            </li>
                            <li 
                            <?php if ($_SERVER['REQUEST_URI'] ==  '/deconnexion') { ?>class="active"<?php } ?>>
                                <a href="deconnexion">
                                    <span class="glyphicon glyphicon-log-out"></span>
                                    Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <?php } elseif($estConnecte && $role == 2) {
                  ?>  
                 <div class="row vertical-align">
                    <div class="col-md-4">
                        <h1>
                            <img src="./images/logo.jpg" class="img-responsive" 
                                 alt="Laboratoire Galaxy-Swiss Bourdin" 
                                 title="Laboratoire Galaxy-Swiss Bourdin">
                        </h1>
                    </div>
                    <div class="col-md-8">
                        <ul class="nav nav-pills pull-right" role="tablist">
                            <li <?php if ($_SERVER['REQUEST_URI'] == '/accueil') { ?>class="active active-comptable" <?php } ?>>
                                <a href="accueil" class="header-comptable">
                                    <span class="glyphicon glyphicon-home"></span>
                                    Accueil
                                </a>
                            </li>
                            <li <?php if ($_SERVER['REQUEST_URI'] == '/validerfrais') { ?>class="active active-comptable"<?php } ?>>
                                <a href="validerfrais" class="header-comptable">
                                    <span class="glyphicon glyphicon-ok"></span> 
                                     Valider les fiches de frais
                                </a>
                            </li>
                            <li <?php if ($_SERVER['REQUEST_URI'] == '/suivrepaiement') { ?>class="active active-comptable"<?php } ?>>
                                <a href="suivrepaiement" class="header-comptable">
                                   <span class="glyphicon glyphicon-euro"></span> 
                                     Suivre le paiement des fiches de frais
                                </a>
                            </li>
                            <li 
                            <?php if ($_SERVER['REQUEST_URI'] ==  '/deconnexion') { ?>class="active active-comptable"<?php } ?>>
                                <a href="deconnexion" class="header-comptable">
                                    <span class="glyphicon glyphicon-log-out"></span>
                                    Déconnexion
                                </a>
                            </li>
                        </ul>
                    </div>
            
                <?php } else{
                ?>
                <h1>
                    <img src="./images/logo.jpg"
                         class="img-responsive center-block"
                         alt="Laboratoire Galaxy-Swiss Bourdin"
                         title="Laboratoire Galaxy-Swiss Bourdin">
                </h1>
                <?php
            }
