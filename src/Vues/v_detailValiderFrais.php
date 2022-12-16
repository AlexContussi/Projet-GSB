<?php 
if (sizeof($lesFraisHorsForfait) > 0 || sizeof($lignes) > 0) {
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
    ?>
   
<div class="row">    
    <h2 class="colorComptable">Valider la fiche de frais</h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" action="/modifFraisForfait" role="form">
            <fieldset>   
                <div class="form-group">
                    <input name="dateselected" value="<?php echo $dateselected ?>" hidden />
                    <input name="idvisiteur" value="<?php echo $idvisiteur ?>" hidden />
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

<div class="space">
    <table class="table ">
        <thead>
            <tr >
                <th colspan="5" class="backgroundComptable borderComptable">Descriptif des éléments hors forfait</th>
            </tr>
            <tr>
                <th class="date borderComptable">Date</th>
                <th class="libelle borderComptable">Libellé</th>  
                <th class="montant borderComptable">Montant</th>  
                <th class="action borderComptable" colspan="2"></th> 
            </tr> 
        </thead>  
        <tbody>
        <?php
        foreach ($lesFraisHorsForfait as $unFraisHorsForfait) {
            ?>
                <tr >
                    <form action="/modifHorsForfait"  method="post" role="form">
                    <input name="dateselected" value="<?php echo $dateselected ?>" hidden />
                    <input name="idvisiteur" value="<?php echo $idvisiteur ?>" hidden />
                        <td class="borderComptable">
                            <input name="id" hidden value="<?php echo $unFraisHorsForfait['id'] ?>"/>
                            <input name="date" value="<?php echo $unFraisHorsForfait['date'] ?>"/>
                        </td>
                        <td class="borderComptable"><input name="libelle" value="<?php echo htmlspecialchars($unFraisHorsForfait['libelle']) ?>"/></td>
                        <td class="borderComptable"><input name="montant" value="<?php echo $unFraisHorsForfait['montant'] ?>"/></td>
                        <td class="borderComptable">
                            <button class="btn btn-success" type="submit">Corriger</button>
                            <button class="btn btn-danger" type="reset">Réinitialiser</button>                            
                        </td>
                    </form>
                    <form action="/refuserLigneHorsForfait"  method="post" role="form">
                        <td class="borderComptable">
                        <input name="dateselected" value="<?php echo $dateselected ?>" hidden />
                        <input name="idvisiteur" value="<?php echo $idvisiteur ?>" hidden />
                            <button class="btn backgroundComptable"  type="submit" name="idLigneFraisHorsForfait" value="<?php echo $unFraisHorsForfait['id'] ?>">REFUSER</button>
                        </td>
                    </form>
                </tr>
            <?php  
        }
        ?>
        </tbody>  
    </table>
</div>
<form method="post" action="/modifJustificatifs" role="form">
    <div>
        <label for="nbJustificatifs">
            Nombre de justificatifs :
            <input class="form-control" name="nbJustificatifs" id="nbJustificatifs" type="number"size="10" maxlength="5" min="0" value="<?php echo $nbjustificatifs ?>" />
            <input name="idvisiteur"  value="<?php echo $idvisiteur ?>" hidden />
            <input name="mois"  value="<?php echo $dateselected ?>" hidden />
        </label>
    </div>
    <div>
        <button class="btn btn-success" type="submit">Corriger</button>
        <button class="btn btn-danger" type="reset">Réinitialiser</button>
    </div>
</form>
<div class="space">
    <form method="post" action="/validerFicheFrais" role="form">        
        <div>
            <input name="idvisiteur" value="<?php echo $idvisiteur ?>" hidden/>
            <input name="dateselected" value="<?php echo $dateselected ?>" hidden />
            <button class="btn btn-success" type="submit">Valider</button>
        </div>
    </form>
</div>
<?php 
}else{
    ?>
    <div class="alert alert-info" role="alert">Pas de fiche de frais pour ce visiteur ce mois</div>
    <?php
}
