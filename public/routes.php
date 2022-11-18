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

// A route with a callback
get('/callback', function(){
  echo 'Callback executed';
});

// A route with a callback passing a variable
// To run this route, in the browser type:
// http://localhost/user/A
get('/callback/$name', function($name){
  echo "Callback executed. The name is $name";
});

// A route with a callback passing 2 variables
// To run this route, in the browser type:
// http://localhost/callback/A/B
get('/callback/$name/$last_name', function($name, $last_name){
  echo "Callback executed. The full name is $name $last_name";
});


// any can be used for GETs or POSTs

// For GET or POST
// The 404.php which is inside the views folder will be called
// The 404.php has access to $_GET and $_POST
any('/404','views/404.php');
