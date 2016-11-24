<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title><?php echo $title ?></title>
    <link rel="stylesheet" href="<?php echo base_url() ?>styles/jeu.css" />
</head>
<body>
    <h1>Jeu</h1>
    <?php
    
    $tailleMain = count($main);
    $taillePose = count($pose);
    $tailleMilieu = count($retires);
    
    ?>
    <div id="bas" border="1">
        <table>
            <tr>
                <?php
                if ($tailleMain != 0) {
                    for ($i = 0; $i < $tailleMain; $i++) {
                        echo '<td><img src="' . base_url($main[$i]->image) . '" name="' . $main[0]->id_carte . '" onclick="poserCarte()"/></td>';
                    }
                }
                ?>

            </tr>
            <tr>
                <?php
                if ($taillePose != 0) {
                    for ($i = 0; $i < $taillePose; $i++) {
                        echo '<td><img src="' . base_url($pose[$i]->image) . '" name="' . $pose[0]->id_carte . '"/></td>';
                    }
                }
                ?>
            </tr>
        </table>
    </div>
    
    <div id="milieu" border="1">
        <table>
            <tr>
                <?php
                if ($tailleMilieu != 0) {
                    for ($i = 0; $i < $tailleMain; $i++) {
                        echo '<td><img src="' . base_url($retires[$i]->image) . '" name="' . $retires[0]->id_carte . '"/></td>';
                    }
                }
                ?>

            </tr>
           </table>
    </div>
    
    <script>
        function poserCarte() {
            
        }
    </script>
</body>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>g

</html>


