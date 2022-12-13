<?php

require_once './router.php';


get('/', PATH_VIEWS. 'v_connexion.php');

post('/connexion', PATH_CTRLS. 'c_connexion.php');

post('/valideA2F', PATH_CTRLS. 'c_valideA2f.php');

get('/accueil', PATH_CTRLS. 'c_accueil.php');

get('/deconnexion', PATH_CTRLS. 'c_deconnexion.php');

get('/gererFrais', PATH_GERER. 'c_gererFrais.php');

post('/gererFrais/validerMajFraisForfait', PATH_GERER. 'c_validerMajFraisForfait.php');

post('/gererFrais/validerCreationFrais', PATH_GERER. 'c_validerCreationFrais.php');

get('/gererFrais/supprimerFrais/$id', PATH_GERER. 'c_supprimerFraisHorsForfait.php');

get('/etatFrais', PATH_ETAT. 'c_selectionnerMois.php');

post('/voirEtatFrais', PATH_ETAT. 'c_voirEtatFrais.php');

get('/validerFrais', PATH_CTRLS. 'c_validerFrais.php');

get('/suivrePaiement', PATH_CTRLS. 'c_suivrePaiement.php');

post('/ajax', PATH_CTRLS. 'Ajax/c_ajax.php');

post('/miseEnPaiement', PATH_CTRLS. 'c_miseEnPaiement.php');

any('/404',PATH_VIEWS.'v_404.php');

