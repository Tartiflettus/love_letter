<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
    </head>
    <body>
        <form action="<?php echo base_url() ?>index.php/jeucontroller/enregistrer" method="post">
            <span id="msgErreur"></span>
            <label for="nomInput">nom</label><input id="nomInput" type="text" name="nom">
            <!-- <a href="#!" id="btnConfirmerNom">Choisir ce nom</a> -->
            <input type="submit">
        </form>
    </body>
</html>




