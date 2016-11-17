$(document).ready(function(){
    $("#btnConfirmerNom").click(function(){
        $nom = this.value;
        $.ajax({
            url: "localhost/love_letter/index.php/accueilcontroller/enregistrer/" + $nom,
            fail: function(){
                $("#msgErreur").html("Nom incorrect");
            },
            success: function(){
                $("#msgErreur").html("");
            }
        })
    });
});
