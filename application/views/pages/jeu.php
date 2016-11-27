<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title><?php echo $title ?></title>
        <link rel="stylesheet" href="<?php echo base_url() ?>styles/jeu.css" />
    </head>
    <body>

        <h1>Jeu</h1>
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
                    afficherJoueur1($tailleMain1, $main1);
                    break;
                case 1:
                    afficherAutres("mainJ2", $main2[0]->id_carte, $tailleMain2, "j2");
                    break;
                case 2:
                    afficherAutres("mainJ3", $main3[0]->id_carte, $tailleMain3, "j3");
                    break;
                case 3:
                    afficherAutres("mainJ4", $main4[0]->id_carte, $tailleMain4, "j4");
            }
        }

        function afficherJoueur1($nb_cartes, $main) {
            if ($nb_cartes != 0) {
                echo '<form id="mainJ1" method="post">';
                for ($i = 0; $i < $nb_cartes; $i++) {
                    echo '<input type="image" src="' . base_url($main[$i]->image) . '" name="j1" value="' . $main[$i]->id_carte . '" id="carte"/></td>';
                }
                echo '</form>';
            }
        }

        function afficherAutres($id, $id_carte, $main, $num_joueur) {
            if ($main != 0) {
                echo '<form id="' . $id . '" method="post">';
                for ($i = 0; $i < $main; $i++) {
                    echo '<input type="image" src="' . base_url() . 'images_cartes/dos_carte.png" name ="' . $num_joueur . '" value="' . $id_carte . '" id="carte"/>';
                }
                echo '</form>';
            }
        }
        ?>

        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
        <script>
            /*
     
             Le web est un MERDE CORDIALEMENT.
             Les types qui ont décidé de normaliser (on peut vraiment appeler cette merde une norme ?)
             ... le web ainsi sont des CONNARDS DE SERVICE.
     
             */

            $(document).ready(function () {
                setInterval(function () {
                    console.log("coucou");
                    $("#maj").load("localhost/index.php/jeucontroller/view" + ' #maj');
                }, 1000);
            });

        </script>

    </body>

</html>


