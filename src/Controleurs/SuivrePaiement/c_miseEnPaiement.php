<?php
use Outils\Utilitaires;
use Modeles\PdoGsb;
$pdo = PdoGsb::getPdoGsb();
$checkboxs = filter_input(INPUT_POST,'fichefrais',FILTER_SANITIZE_FULL_SPECIAL_CHARS,FILTER_REQUIRE_ARRAY);
foreach($checkboxs as $valeur){
   $pdo->setFicheFraisMiseEnPaiement($valeur);
}
header("Refresh: 0;URL=/suivrePaiement");

?>