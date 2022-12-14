<?php

if ($estConnecte) {
    $action = filter_input(INPUT_GET, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $dateselected = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $idvisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lignes = $pdo->getLignesFicheFrais($idvisiteur, $dateselected);
    $date = null;
    foreach ($lignes as $ligne) {
        if ($ligne['idfraisforfait'] == 'ETP') {
            $etp = $ligne['quantite'];
        }
        if ($ligne['idfraisforfait'] == 'KM') {
            $km = $ligne['quantite'];
        }
        if ($ligne['idfraisforfait'] == 'NUI') {
            $nui = $ligne['quantite'];
        }
        if ($ligne['idfraisforfait'] == 'REP') {
            $rep = $ligne['quantite'];
        }
    }
    $lesFraisHorsForfait = $pdo->getLesFraisHorsForfait($idvisiteur, $dateselected);
    $visiteurs = $pdo->getAllVisiteur();
    $dateOfTheDay = new DateTime();
    $dates = [];
    $date1 = date_add($dateOfTheDay, date_interval_create_from_date_string('-1 m'));
    for ($index = 1; $index < 14; $index++) {
        $dates[$index] = date_add(new DateTime(), date_interval_create_from_date_string("-" . strval($index) . " month"));
    }


    include PATH_VIEWS . 'v_accueil_comptable.php';

    if ($action == 'voirFrais') {
        $nbjustificatifs = $pdo->getNbJustificatifs($idvisiteur, $dateselected);
        $date = date('m/Y', strtotime($dateselected));
        if (sizeof($lesFraisHorsForfait) > 0 || sizeof($lignes) > 0) {
            include PATH_VIEWS . 'v_detail_comptable_fiche_frais.php';
        } else {
            include PATH_VIEWS . 'v_comptable_aucun_frais.php';
        }
    }

    if ($action == 'refuserLigneHorsForfait') {
        $idLigneFraisHorsForfait = filter_input(INPUT_POST, 'idLigneFraisHorsForfait', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->refuserLigneHorsForfait($idLigneFraisHorsForfait);
        $date = date('m/Y', strtotime($dateselected));
        include PATH_VIEWS . 'v_detail_comptable_fiche_frais.php';
    }


    if ($action == 'modifHorsForfait') {
        $id = filter_input(INPUT_POST, 'id', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $date = filter_input(INPUT_POST, 'date', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $libelle = filter_input(INPUT_POST, 'libelle', FILTER_SANITIZE_FULL_SPECIAL_CHARS, FILTER_FLAG_NO_ENCODE_QUOTES);
        $montant = filter_input(INPUT_POST, 'montant', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $dateTemp = strtotime($date);
        $pdo->setLigneHorsForfait($id, htmlspecialchars_decode($libelle), date("Y-m-d", $dateTemp), $montant);
    }

    if ($action == 'validerMajFraisForfait') {
        $etape = filter_input(INPUT_POST, 'etape', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $km = filter_input(INPUT_POST, 'km', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $nui = filter_input(INPUT_POST, 'nui', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $rep = filter_input(INPUT_POST, 'rep', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $mois = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $id = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->setLigneFraisForfaitEtape($id, $mois, $etape);
        $pdo->setLigneFraisForfaitKm($id, $mois, $km);
        $pdo->setLigneFraisForfaitNui($id, $mois, $nui);
        $pdo->setLigneFraisForfaitRep($id, $mois, $rep);
    }

    if ($action == "confirmerValidationFicheFrais") {
        $nbJustificatifs = filter_input(INPUT_POST, 'nbJustificatifs', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->validerFicheDeFrais($idvisiteur, $mois, $nbJustificatifs);
    }
    if ($action == 'validerFicheFrais') {
        $dateselected = filter_input(INPUT_POST, 'dateselected', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $idvisiteur = filter_input(INPUT_POST, 'idvisiteur', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $pdo->validerFicheFrais($idvisiteur, $dateselected);
    }
} else {
    include PATH_VIEWS . 'v_connexion.php';
}


