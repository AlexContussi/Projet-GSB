<form action="/voirFrais"  method="post" role="form">
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
    <select id="selectDate" name="dateselected" >
        <option selected><?php echo ($date != null)? $date :"" ?></option>
        <?php 
        for($index = 1; $index < sizeof($dates); $index++) {  
        ?> 
            <option value="<?php echo $dates[$index]->format('Ym') ?>"<?php echo ($dates[$index]->format('Ym') == $dateselected)? "selected" : ""?>><?php echo $dates[$index]->format('m/Y') ?></option>

        <?php 
        }
        ?>  
    </select>
</form>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(function(){
    $("#selectVisiteur").select2();
    $("#selectDate").select2();
}); 

$('#selectDate').change(function(){
    $(this).parent('form').submit();
});

</script>