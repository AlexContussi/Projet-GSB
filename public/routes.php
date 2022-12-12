<?php

require_once './router.php';


// Static GET
// In the URL -> http://localhost
// The output -> Index
get('/', PATH_VIEWS. 'v_connexion.php');

post('/connexion', PATH_CTRLS. 'c_connexion.php');

post('/valideA2F', PATH_CTRLS. 'c_valideA2f.php');

get('/accueil', PATH_CTRLS. 'c_accueil.php');

get('/deconnexion', PATH_CTRLS. 'c_deconnexion.php');

get('/gererfrais', PATH_GERER. 'c_gererFrais.php');

post('/gererfrais/validerMajFraisForfait', PATH_GERER. 'c_validerMajFraisForfait.php');

post('/gererfrais/validerCreationFrais', PATH_GERER. 'c_validerCreationFrais.php');

get('/gererfrais/supprimerFrais/$id', PATH_GERER. 'c_supprimerFraisHorsForfait.php');

get('/etatfrais', PATH_ETAT. 'c_etatFrais_selectionnerMois.php');

post('/voirEtatFrais', PATH_ETAT. 'c_etatFrais_voirEtatFrais.php');

get('/validerfrais', PATH_CTRLS. 'c_validerFrais.php');

get('/suivrepaiement', PATH_CTRLS. 'c_suivrePaiement.php');

any('/404',PATH_VIEWS.'v_404.php');

