<?php

/**
 * Vue Liste des frais au forfait
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
    <?php if($etat['idetat']=="CR"){
            ?>
            <div class="row">    
                        <h2>Renseigner ma fiche de frais du mois 
                            <?php echo $numMois . '-' . $numAnnee ?>
                        </h2>
                        <h3>Eléments forfaitisés</h3>
                        <?php if(!empty($_SESSION['erreurs'])){
                               include PATH_VIEWS . 'v_erreurs.php';
                               Utilitaires::supprimerErreurs();
                                        }
                                    ?>
                        <div class="col-md-4">
                            <form method="post" 
                                  action="gererFrais/validerMajFraisForfait" 
                                  role="form">
                                <fieldset>       
                                    <?php
                                    foreach ($lesFraisForfait as $unFrais) {
                                        $idFrais = $unFrais['idfrais'];
                                        $libelle = htmlspecialchars($unFrais['libelle']);
                                        $quantite = $unFrais['quantite']; ?>
                                        <div class="form-group">
                                            <label for="idFrais"><?php echo $libelle ?></label>
                                            <input type="text" id="idFrais" 
                                                   name="lesFrais[<?php echo $idFrais ?>]"
                                                   size="10" maxlength="5" 
                                                   value="<?php echo $quantite ?>" 
                                                   class="form-control">
                                        </div>
                                        <?php
                                    }
                                    ?>
                                    <button class="btn btn-success" type="submit" <?php echo ($etat['idetat']=="VA")? "disabled":"" ?> >Ajouter</button>
                                    <button class="btn btn-danger" type="reset" <?php echo ($etat['idetat']=="VA")?  "disabled":"" ?> >Effacer</button>
                                </fieldset>
                            </form>
                        </div>
                    </div>
               <?php 
               }else{ 
                   ?>
                    <div id="ficheCloturee" class="alert alert-info" role="alert"  >
                    Fiche de frais du mois <?=$numMois . '-' . $numAnnee ." cloturée !" ;?>
                    </div>
               <?php
           }
    