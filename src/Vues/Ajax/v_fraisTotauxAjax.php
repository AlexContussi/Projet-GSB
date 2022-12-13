<?php

?>  <tr id="<?= $utilisateur['id']?>">
        <td><?php echo $utilisateur['prenom'] . " " . $utilisateur['nom']?></td>
        <td><?php echo $totalFraisForfait ?>€</td>
        <td><?php echo $totalFraisHorsForfait?>€</td>
        <td><?php echo $totalFraisForfait + $totalFraisHorsForfait ?>€</td>
    </tr>
