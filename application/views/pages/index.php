<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Accueil</title>
        <style>
            body{
                background-image: url(<?php echo base_url() ?>background/soleil.jpg);
                background-size: cover;
            }

            #tab{
                position : absolute;
                bottom : 50%;
                right : 50%;
            }
            
            #label{
                font-size: 25px;
                font-family:impact;
            }

        </style>
    </head>
    <body>
        <form action="<?php echo base_url() ?>index.php/jeucontroller/enregistrer" method="post">
            <span id="msgErreur"></span>
            <table id="tab">
                <tr>
                    <td><p id="label">Entrez un nom :</p></td>
                </tr>
                <tr>
                    <td><input id="nomInput" type="text" name="nom"></td>
                    <td><input type="submit" id="btn"></td>
                </tr>
            </table>
        </form>
    </body>
</html>




