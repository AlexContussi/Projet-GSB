<?php

?>
<div class="row">
    <div class="">
        <form action="/miseEnPaiement"
              method="post" role="form">
            <div class="form-group">
                <table class="table table-striped table-bordered shadow" id="datatable">
                    <thead>
                        <tr>
                            <th> </th>
                            <th>Visiteur</th>
                            <th>Mois fiche de frais</th>
                            <th>Montant Validé</th>
                            <th>Date de validation de la fiche de frais</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fichesValidees as $uneFiche)
                        {
                            ?>
                        
                            <tr>
                                <td><input class="btnselect" type="checkbox" name="fichefrais[]" data_mois = <?php echo $uneFiche['mois']?> value="<?php echo $uneFiche['idvisiteur']?>"></td>
                                <td><?php echo $uneFiche['prenom'] . ' ' . $uneFiche['nom'] ?></td>
                                <td><?php echo $uneFiche['mois'] ?></td>
                                <td><?php echo $uneFiche['montantvalide'] ?></td>
                                <td><?php echo $uneFiche['datemodif'] ?></td>
                            </tr>
                            
                           
                                <?php
                        }
                        ?>
                    </tbody>
                </table>
                
                <table class="table table-bordered shadow">
                    <thead>
                        <tr>
                            <th>Visiteur</th>
                            <th>Total frais forfait</th>
                            <th>Total frais hors forfait</th>
                            <th>Total </th>
                        </tr>
                    </thead>
                    <tbody id="details">
                    </tbody>
                </table>
                
            </div>
            <input id="ok" type="submit" value="Valider" class="btn btn-success" 
                   role="button">
            <input id="btnannuler" type="reset" value="Effacer" class="btn btn-danger" 
                   role="button">
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.13.1/datatables.min.js"></script>
<script>
    $(document).ready(function () {
    $('#datatable').DataTable();
});
</script>
<script src="js/ajax.js"></script>