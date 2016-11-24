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
    $tailleMain1 = count($main1);
    
    ?>
    <div id="bas" border="1">
        <table>
            <tr>
                <?php
                if ($tailleMain != 0) {
                    for ($i = 0; $i < $tailleMain; $i++) {
                        echo '<td><img src="' . base_url($main[$i]->image) . '" name="' . $main[0]->id_carte . '" id="plop" /></td>';
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
        
    <div id="haut" border="1">
        <table>
            <tr>
                <?php
                if ($tailleMain1 != 0) {
                    for ($i = 0; $i < $tailleMain1; $i++) {
                        echo '<td><img src="' . base_url($main1[$i]->image) . '" name="' . $main1[0]->id_carte . '"/></td>';
                    }
                }
                ?>

            </tr>
        </table>
    </div>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        
        $(document).ready(function(){
            $("#plop").click(function(){
                $.ajax({
                    url : <?php echo base_url() ?>+"jeucontroller.php/testAjax", 
                    success : function(data){
                        console.log(data);
                    }
                });
            });
        });
        
        console.log(<?php echo base_url() ?>+"jeucontroller.php/testAjax");
        function poserCarte() {
            $.ajax({
                url : <?php echo base_url() ?>+"jeucontroller.php/testAjax", 
                success : function(data){
                    console.log(data);
                }
            });
        }
    </script>
</body>

</html>


