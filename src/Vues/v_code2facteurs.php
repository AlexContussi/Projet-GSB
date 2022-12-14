<?php 
use Outils\Utilitaires;
?>
<head>
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta charset="UTF-8">
        <title>Intranet du Laboratoire Galaxy-Swiss Bourdin</title> 
        <meta name="description" content="">
        <meta name="author" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="./styles/bootstrap/bootstrap.css" rel="stylesheet">
        <link href="./styles/style.css" rel="stylesheet">
    </head>
<h1>
    <img src="./images/logo.jpg"
         class="img-responsive center-block"
         alt="Laboratoire Galaxy-Swiss Bourdin"
         title="Laboratoire Galaxy-Swiss Bourdin">
</h1>

    
<div class="container">
            <?php if(!empty($_SESSION['erreurs'])){
                    include PATH_VIEWS . 'v_erreurs.php';
                    Utilitaires::supprimerErreurs();
           
    }
?>
<div class="alert alert-info" role="alert">Un email contenant un code à 4 chiffres vous a été envoyé, merci de le saisir ici...</div>
<div class="row">
    <div class="col-md-6 col-md-offset-3">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Identification utilisateur - Authentification à deux facteurs (A2F)</h3>
            </div>
            <div class="panel-body">
                <form role="form" method="post" 
                      action="valideA2F">
                    <fieldset>
                        <div class="form-group">
                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="glyphicon glyphicon-qrcode"></i>
                                </span>
                                <input class="form-control" placeholder="Code"
                                       name="code" type="text" maxlength="4">
                            </div>
                        </div>
                        <input class="btn btn-lg btn-success btn-block"
                               type="submit" value="Se connecter">
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div>