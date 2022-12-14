<?php
?>
<style>
.colorComptable{color: #ff8800 !important}
.backgroundComptable{background-color: #ff8800 !important;color:#FFF}
.borderComptable{border:#ff8800 solid 2px !important}
.space{margin-top: 20px;}
    
    
</style>
<div class="row">    
    <h2 class="colorComptable">Valider la fiche de frais</h2>
    <h3>Eléments forfaitisés</h3>
    <div class="col-md-4">
        <form method="post" action="index.php?uc=afficheFraisClient&action=validerMajFraisForfait" role="form">
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
                    <form action="index.php?uc=afficheFraisClient&action=modifHorsForfait"  method="post" role="form">
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
                    <form action="index.php?uc=afficheFraisClient&action=refuserLigneHorsForfait"  method="post" role="form">
                        <td class="borderComptable">
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
<form method="post" action="index.php?uc=afficheFraisClient&action=confirmerValidationFicheFrais" role="form">
    <div>
        <label for="nbJustificatifs">
            Nombre de justificatifs :
            <input class="form-control" name="nbJustificatifs" id="nbJustificatifs" type="number"size="10" maxlength="5" min="0" value="<?php echo $nbjustificatifs ?>" />
        </label>
    </div>
    <div>
        <button class="btn btn-success" type="submit">Corriger</button>
        <button class="btn btn-danger" type="reset">Réinitialiser</button>
    </div>
</form>
<div class="space">
    <form method="post" action="index.php?uc=afficheFraisClient&action=validerFicheFrais" role="form">        
        <div>
            <input name="idvisiteur" value="<?php echo $idvisiteur ?>" hidden/>
            <input name="dateselected" value="<?php echo $dateselected ?>" hidden />
            <button class="btn btn-success" type="submit">Valider</button>
        </div>
    </form>
</div>
