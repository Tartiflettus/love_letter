<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <link rel="stylesheet" href="<?php echo base_url() ?>styles/jeu.css" />
    </head>
    <body>
        <div id="maj">
            <h1>Jeu</h1>
            <p>Vous Ítes <?php echo $nomJoueur; ?></p>
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
                        afficherAutres("mainJ2", $main2[0]->id_carte, $tailleMain2, "j2", $pose2);
                        break;
                    case 2:
                        afficherAutres("mainJ3", $main3[0]->id_carte, $tailleMain3, "j3", $pose3);
                        break;
                    case 3:
                        afficherAutres("mainJ4", $main4[0]->id_carte, $tailleMain4, "j4", $pose4);
                }
            }

            function afficherJoueur1($nb_cartes, $main, $taillePose, $pose) {

                echo '<form id="mainJ1" method="post" action="' . base_url() . 'index.php/jeucontroller/action" onsubmit="coucou()">';
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

            function afficherAutres($id, $id_carte, $main, $num_joueur, $pose) {

                echo '<form id="' . $id . '" method="post">';
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
                        echo '<td><input type="image" src="' . base_url() . 'images_cartes/dos_carte.png" name ="' . $num_joueur . '" value="' . $id_carte . '" id="carte"/></td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                echo '</form>';
            }
            ?>

        </div>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            /*
             
             Les patates sont meilleures cuites dans la bi√®re.
             Le cataclysme est un pingouin
             
             */

            $(document).ready(function () {
                setInterval(function () {
                    console.log("maj");
                    $("#maj").load("/love_letter/index.php/jeucontroller/view" + ' #maj');
                }, 1000);
            });

        </script>

    </body>

</html>


