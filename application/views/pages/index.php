<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
    </head>
    <body>
        <p>Partie n°<?php echo $num_partie ?></p>
        <p>Joueur n°<?php echo $id_joueur ?></p>
        <form action="localhost/love_letter/index.php/accueilcontroller/">
            <span id="msgErreur"></span>
            <label for="nomInput">nom</label><input id="nomInput" type="text" name="nom">
            <a href="#!" id="btnConfirmerNom">Choisir ce nom</a>
            <input type="submit">
        </form>




        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            $(document).ready(function(){
                $("#btnConfirmerNom").click(function(){
                    $nom = $("#nomInput").val();
                    console.log($nom);
                    $.ajax({
                        url: "<?php echo base_url(); ?>index.php/accueilcontroller/enregistrer/" + $nom,
                        fail: function(){
                            $("#msgErreur").html("Nom incorrect");
                        },
                        success: function(){
                            $("#msgErreur").html("");
                        }
                    })
                });
            });
        </script>
    </body>
</html>




