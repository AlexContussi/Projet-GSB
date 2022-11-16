<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

if ($estConnecte) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if($action == 'voirFrais'){
        $ok ="ok";
    }
    $visiteurs = $pdo->getAllVisiteur();      
    $dateOfTheDay = new DateTime();
    $dates=[];
    //$dates = date_add($dateOfTheDay,date_interval_create_from_date_string('-1 m'))
    $date1 = date_add($dateOfTheDay,date_interval_create_from_date_string('-1 m'));
    for ($index = 1; $index < 14; $index++) {
        $dates[$index] = date_add(new DateTime() ,date_interval_create_from_date_string("-".strval($index)." month"));
    }
    
    include PATH_VIEWS . 'v_accueil_comptable.php';
    
}
else{
     include PATH_VIEWS . 'v_connexion.php';
}


