<html>
    <head>
        <title>Lobby</title>
        <meta charset="UTF-8"/>
        <style>
            body{
                background-image: url(<?php echo base_url() ?>background/Furi.jpg);
                background-size: cover;
            }

            table{
                border-style: solid;
                border-width: 2px;
                border-collapse: collapse;
            }

            tr{
                border-style: solid;
                border-width: 2px;
            }

            td{
                text-align: center;
                border-style: solid;
                border-width: 2px;
            }
        </style>

    </head>
    <body>
        <div id="maj">

            <form action="<?php echo base_url() ?>index.php/jeucontroller/demarrer">
                <input type="submit" value="Démarrer">
            </form>

            <table>
                <?php

                    foreach ($noms as $n){
                        echo "<tr>";
                        echo "<td>";

                        echo $n->nom;

                        echo "</td>";
                        echo "</tr>";
                    }

                ?>
            </table>

        </div>


        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
<script>
    $(document).ready(function(){
        setInterval(function () {
            console.log("maj");
            //$("#maj").load("/love_letter/index.php/jeucontroller/lobby" + ' #maj');
            $(location).attr("href", "/love_letter/index.php/jeucontroller/lobby");
        }, 5000);
    });
</script>
    </body>
</html>