<html>
    <head>
        <title>Lobby</title>
        <meta charset="UTF-8"/>
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