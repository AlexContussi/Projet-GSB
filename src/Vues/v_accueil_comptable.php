<?php

/* 
 * Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
 * Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHP.php to edit this template
 */
?>


<h3>Comptable</h3>
<form action="index.php?uc=afficheFraisClient&action=voirFrais"  method="post" role="form">
    
    <label for="selectVisiteur">Choisir le visiteur</label>
    <select id="selectVisiteur">
        <?php 
        foreach($visiteurs as $visiteur) {
        ?>  
            <option value="<?php echo $visiteur['id'] ?>"><?php echo $visiteur['nom']. ' ' .$visiteur['prenom']?></option>
        <?php 
        }
        ?>  
    </select>

    <label for="selectDate">Date : </label>
    <select id="selectDate">
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
        <h2>Renseigner ma fiche de frais</h2>
        <h3>Eléments forfaitisés</h3>
        <div class="col-md-4">
            <form method="post" action="index.php?uc=afficheFraisClient&action=validerMajFraisForfait" role="form">
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
                    <button class="btn btn-success" type="submit">Corriger</button>
                    <button class="btn btn-danger" type="reset">Réinitialiser</button>
                </fieldset>
            </form>
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