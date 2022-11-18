<?php

/**
 * Vue Déconnexion
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

?>
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
        <h1>
                <img src="./images/logo.jpg"
                     class="img-responsive center-block"
                     alt="Laboratoire Galaxy-Swiss Bourdin"
                     title="Laboratoire Galaxy-Swiss Bourdin">
            </h1>
    <div class="alert alert-info" role="alert">
        <p>Vous avez bien été déconnecté ! <a href="/">Cliquez ici</a>
            pour revenir à la page de connexion.</p>
    </div>
<?php
header("Refresh: 3;URL=/");
