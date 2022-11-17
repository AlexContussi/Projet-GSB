<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

if ($estConnecte) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
    if($action == 'voirFrais'){
        $ok ="ok";
        $dateselected = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idvisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        
        $lignes=$pdo->getLignesFicheFrais($idvisiteur,$dateselected);
        foreach($lignes as $ligne){
            if($ligne['idfraisforfait'] == 'ETP'){
                $etp = $ligne['quantite'];
            }
            if($ligne['idfraisforfait'] == 'KM'){
                $km = $ligne['quantite'];
            }
            if($ligne['idfraisforfait'] == 'NUI'){
                $nui = $ligne['quantite'];
            }
            if($ligne['idfraisforfait'] == 'REP'){
                $rep = $ligne['quantite'];
            }
        }
        $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisiteur, $dateselected);
        
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


