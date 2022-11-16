<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */

if ($estConnecte) {
    include PATH_VIEWS . 'v_accueil_comptable.php';
}
else{
     include PATH_VIEWS . 'v_connexion.php';
}