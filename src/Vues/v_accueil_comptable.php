<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>


<h3>Comptable</h3>
<form action="index.php?uc=afficheFraisClient&action=voirFrais"  method="post" role="form">
    
    <label for="selectVisiteur">Choisir le visiteur</label>
    <select id="selectVisiteur" name="idvisiteur">
        <?php 
        foreach($visiteurs as $visiteur) {
        ?>  
            <option value="<?php echo $visiteur['id'] ?>"><?php echo $visiteur['nom']. ' ' .$visiteur['prenom']?></option>
        <?php 
        }
        ?>  
    </select>

    <label for="selectDate">Date : </label>
    <select id="selectDate" name="dateselected">
        <option value="<?php echo $dateOfTheDay->format('Ym') ?>" selected><?php echo $dateOfTheDay->format('m/Y') ?></option>
        <?php 
        for($index = 1; $index < sizeof($dates); $index++) {  
        ?>  
            <option value="<?php echo $dates[$index]->format('Ym') ?>"><?php echo $dates[$index]->format('m/Y') ?></option>
        <?php 
        }
        ?>  
    </select>
    <button type="submit" class="btn btn-warning">Rechercher</button>
</form>

<?php
if(isset($ok)){
?>
    <div class="row">    
        <h2 class="colorComptable">Valider la fiche de frais</h2>
        <h3>Eléments forfaitisés</h3>
        <div class="col-md-4">
            <form method="post" action="index.php?uc=afficheFraisClient&action=validerMajFraisForfait" role="form">
                <fieldset>   
                    <div class="form-group">
                        <label for="etape">Forfait Etape</label>
                        <input type="text" id="etape" name="etape" size="10" maxlength="5" value="<?php echo $etp ?>" class="form-control">
                        
                        <label for="km">Frais Kilomètrique</label>
                        <input type="text" id="km" name="km" size="10" maxlength="5" value="<?php echo $km ?>" class="form-control">
                        
                        <label for="nui">Nuitée Hôtel</label>
                        <input type="text" id="nui" name="nui" size="10" maxlength="5" value="<?php echo $nui ?>"class="form-control">
                        
                        <label for="rep">Repas Restaurant</label>
                        <input type="text" id="rep" name="rep" size="10" maxlength="5" value="<?php echo $rep ?>" class="form-control">
                    </div>   
                    <button class="btn btn-success" type="submit">Corriger</button>
                    <button class="btn btn-danger" type="reset">Réinitialiser</button>
                </fieldset>
            </form>
        </div>
    </div>

    <div class="row">
        <div class="">
            <div class="backgroundComptable">Descriptif des éléments hors forfait</div>
            <table class="table table-bordered table-responsive">
                <thead>
                    <tr>
                        <th class="date">Date</th>
                        <th class="libelle">Libellé</th>  
                        <th class="montant">Montant</th>  
                        <th class="action">&nbsp;</th> 
                    </tr>
                </thead>  
                <tbody>
                <?php
                foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
                    $libelle = htmlspecialchars($unFraisHorsForfait['libelle']);
                    $date = $unFraisHorsForfait['date'];
                    $montant = $unFraisHorsForfait['montant'];
                    $id = $unFraisHorsForfait['id']; ?>           
                    <tr>
                        <td><input value="<?php echo $date ?>"/></td>
                        <td><input value="<?php echo $libelle ?>"/></td>
                        <td><input value="<?php echo $montant ?>"/></td>
                        <td>
                           
                        </td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>  
            </table>
        </div>
    </div>


















<?php
}
?>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function(){
    $("#selectVisiteur").select2();
}); 
 
</script>