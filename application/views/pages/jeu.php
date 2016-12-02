<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>love letter</title>
        <link rel="stylesheet" href="<?php echo base_url() ?>styles/jeu.css" />
        <style>
            body{
                background-image: url("<?php echo base_url() ?>background/bouteille.jpg");
                background-size: cover;
            }
        </style>
    </head>
    <body>
        <form method="post" action="<?php echo base_url() ?>index.php/jeucontroller/reset">
            <input type="submit" value="Reset">
        </form>
        
        <div id="maj">
            <h1>Jeu</h1>
            <p>Vous êtes <?php echo $nomJoueur; ?></p>
            <p>Action en cours : <?php echo $nomJoueurActu . " : " . $actionActu; ?></p>
            <?php
            $tailleMain1 = count($main1);
            $tailleMain2 = count($main2);
            $tailleMain3 = count($main3);
            $tailleMain4 = count($main4);

            $taillePose1 = count($pose1);
            $taillePose2 = count($pose2);
            $taillePose3 = count($pose3);
            $taillePose4 = count($pose4);

            $tailleMilieu = count($retires);
            ?>


            <?php
            echo '<form id="pioche" method="post" action="' . base_url() . 'index.php/jeucontroller/action">';
            echo '<input type="image" src="' . base_url() . 'images_cartes/dos_carte.png" id="carte"/></td>';
            echo '</form>';

            echo '<div id="milieu">';
            echo '<table>';
            echo'<tr>';
            if ($tailleMilieu != 0) {
                for ($i = 0; $i < $tailleMilieu; $i++) {
                    echo '<td><img src="' . base_url($retires[$i]->image) . '" name="' . $retires[0]->id_carte . '" id="carte"/></td>';
                }
            }
            echo '</tr>';
            echo'</table>';
            echo'</div>';

            for ($j = 0; $j < $nbjoueurs; $j++) {
                switch ($j) {
                    case 0:
                        afficherJoueur1($tailleMain1, $main1, $taillePose1, $pose1);
                        break;
                    case 1:
                        afficherAutres("mainJ2", $main2[0]->id_carte, $tailleMain2, "j2", $pose2, $actionActu);
                        break;
                    case 2:
                        afficherAutres("mainJ3", $main3[0]->id_carte, $tailleMain3, "j3", $pose3, $actionActu);
                        break;
                    case 3:
                        afficherAutres("mainJ4", $main4[0]->id_carte, $tailleMain4, "j4", $pose4, $actionActu);
                }
            }

            function afficherJoueur1($nb_cartes, $main, $taillePose, $pose) {

                echo '<form id="mainJ1" method="post" action="' . base_url() . 'index.php/jeucontroller/action">';
                echo '<table>';
                if ($taillePose != 0) {
                    echo '<tr>';
                    for ($j = 0; $j < $taillePose; $j++) {
                        echo '<td><img src="' . base_url($pose[$j]->image) . '" name="posej1" value="' . $pose[$j]->id_carte . '" id="carte"/></td>';
                    }
                    echo '</tr>';
                }

                if ($nb_cartes != 0) {
                    echo '<tr>';
                    for ($i = 0; $i < $nb_cartes; $i++) {
                        echo '<td><input type="image" src="' . base_url($main[$i]->image) . '" name="c' . $i . '" value="' . $main[$i]->id_carte . '" id="carte"/></td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                echo '</form>';
            }

            function afficherAutres($id, $id_carte, $main, $num_joueur, $pose, $actionActu) {

                echo '<form id="' . $id . '" method="post" action="'.base_url().'index.php/jeucontroller/action" onsubmit="return appliquerRegle()">';
                echo '<table>';
                if (count($pose) != 0) {
                    echo '<tr>';
                    for ($j = 0; $j < count($pose); $j++) {
                        echo '<td><img src="' . base_url($pose[$j]->image) . '" id="carte"></td>';
                    }
                    echo '</tr>';
                }
                if ($main != 0) {
                    echo '<tr>';
                    for ($i = 0; $i < $main; $i++) {
                        echo '<td><input type="image" src="' . base_url() . 'images_cartes/dos_carte.png" name ="' . $num_joueur . '" value="' . $id_carte . '" id="carte" /></td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                echo '<input id="supposition" type="hidden" name="supposition" value="">';
                echo '<input id="etat" type="hidden" value="'.$actionActu.'">';
                echo '</form>';
            }
            ?>

            

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            /*
             
             Les patates sont meilleures cuites dans la bière.
             Le cataclysme est un pingouin
             
             */

            $(document).ready(function () {
                setInterval(function () {
                    console.log("maj");
                    $("#maj").load("/love_letter/index.php/jeucontroller/view" + ' #maj');
                }, 1000);
            });

            function appliquerRegle(){
                var etat = $("#etat").val();
                switch(etat){
                    case "supposition":
                        var res = prompt("Quelle carte pensez-vous que c'est ?");
                        $("#supposition").val(res);
                        console.log("supposition écrite : " + ("#supposition").val());
                        break;
                    default:
                        break;
                }
                return true;
            }

        </script>

    </body>

</html>


