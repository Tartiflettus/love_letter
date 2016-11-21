<?php
/**
 * Created by PhpStorm.
 * User: perso
 * Date: 12/11/2016
 * Time: 23:01
 */

session_start();


class JeuModel extends CI_Model {
    function getTaillePioche(){
        $this->db->query("select count(*) from cartes where statut='pioche'");
    }

    function piocheEstVide(){
        return $this->getTaillePioche() == 0;
    }

    function carteAleatoire(){
        //retourne carte al�atoire
    }
    
    function carteDefausseVisible(){
        //mets en place la carte � dafausser visible
    }
    
    //piocher une carte dans la pioche
    function piocher(){
        $q = $this->db->query("select id_carte from cartes where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
        $indice = rand(0, $q->num_rows());

        if($indice < $q->num_rows()) {
            $this->db->query("update cartes set statut='main' idMain=? where id=?",
                Array($_SESSION["id"], $q->row($indice)));
        }
        else{
            http_response_code(500);
            exit();
        }
    }

    
    function getNumJoueurActuel(){
        $q = $this->db->query("select joueur_actu from jeu where num_partie = ".$_SESSION['num_partie']."");
        return $q->row()->JoueurActu;
    }
    
    function passerJoueurSuivant(){
        $nb_joueurs = $this->db->query("select nb_joueurs from jeu where num_partie=".$_SESSION['num_partie']."");
        $q = $this->db->query("select joueur_actu from jeu where num_partie=".$_SESSION['num_partie']."");
        if ($q >= $nb_joueurs) {
            $this->db->query("update jeu set joueur_actu=1 where num_partie=".$_SESSION['num_partie'] . "");
        } else {
            $this->db->query("update jeu set joueur_actu=joueur_actu+1 where num_partie=".$_SESSION['num_partie'] . "");
        }
    }
    
    function jouerCarte($id_joueur, $id_carte){
       //a remplir avec r�gles
       passerJoueurSuivant();
    }

    function ajouterJoueur(){
        //mettre à jour le nombre de joueurs du jeu
        $q = $this->db->query("update jeu set nb_joueurs=nb_joueurs+1 where num_partie=?", Array($_SESSION["num_partie"]));
        $q = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["id"]));

        $nb = $q->row()->nb_joueurs - 1;

        //ajouter effectivement le joueur
        $q = $this->db->query("insert into joueurs (nom, points, elimine, num_partie, num_joueur) values ('defaut', 0, 0, ?, ?)",
            Array($_SESSION["num_partie"], $nb));
        $q = $this->db->query("select last_insert_id() as insert_id"); //récupérer son id
        $_SESSION["id"] = $q->row()->insert_id;
        return $_SESSION["id"];
    }

    function enregistrer($nom){
        //return "<strong>enregistrement</strong>";
        $q = $this->db->query("update joueurs set nom=? where id=?", Array($nom, $_SESSION["id"]));
    }

    function getPartie(){
        $q = $this->db->query("select num_partie from jeu");
        $_SESSION["num_partie"] =  $q->row()->num_partie;
        return $_SESSION["num_partie"];
    }
    
    function getNomJoueurActuel(){
        $num_joueur_actu = getJoueurActuel();
        $join = $this->db->query("jeu join joueur using(joueur_1, joueur_2, joueur_3, joueur_4)");
        $q = $this->db->query("select nom from joueur where nb_joueur=? and num_partie=?", $num_joueur_actu, Array($_SESSION["num_partie"]));
        return $q->row()->nom;
    }
    
    function remplirJeuCarte(){
        $this->db->query("insert into carte (valeur, num_partie, image) values (8, ".$_SESSION['num_partie'].")", 'images_cartes/princess.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (7, ".$_SESSION['num_partie'].")", 'images_cartes/countess.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (6, ".$_SESSION['num_partie'].")", 'images_cartes/king.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (5, ".$_SESSION['num_partie'].")", 'images_cartes/prince.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (5, ".$_SESSION['num_partie'].")", 'images_cartes/prince.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (4, ".$_SESSION['num_partie'].")", 'images_cartes/handmaid.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (4, ".$_SESSION['num_partie'].")", 'images_cartes/handmaid.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (3, ".$_SESSION['num_partie'].")", 'images_cartes/baron.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (3, ".$_SESSION['num_partie'].")", 'images_cartes/baron.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (2, ".$_SESSION['num_partie'].")", 'images_cartes/priest.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (2, ".$_SESSION['num_partie'].")", 'images_cartes/priest.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, ".$_SESSION['num_partie'].")", 'images_cartes/guard.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, ".$_SESSION['num_partie'].")", 'images_cartes/guard.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, ".$_SESSION['num_partie'].")", 'images_cartes/guard.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, ".$_SESSION['num_partie'].")", 'images_cartes/guard.png');
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, ".$_SESSION['num_partie'].")", 'images_cartes/guard.png');     
    }
    
    function deuxJoueurs(){
        //defausser 3 cartes
    }
    
    function jeu(){
        echo '--------Ajout de joueurs--------\n\n';
        
        $this->db->query("insert into joueurs (nom) values ('dark21')");
        $j1_id = $this->db->query("select last_insert_id()");
        $j1_nom = $this->db->query("select nom from joueur where id=$j1_id");
        $this->db->query("insert into joueurs (nom) values ('tartiflotte56')");
        $j2_id = $this->db->query("select last_insert_id()");
        $j2_nom = $this->db->query("select nom from joueur where id=$j2_id");
        
        echo 'Joueur 1 : id : $j1_id | nom : $j1_nom,_n\n';
        echo 'Joueur 2 : id : $j2_id | nom : $j2_nom\n';
        
        echo '--------Cr�ation d une partie--------\n\n';
        //defausser une carte visible 
        $this->db->query("insert into jeu (joueur_1, joueur_2) values ($j1,$j2)");
        $num_partie = $this->db->query("select last_insert_id()");
        $manche = $this->db->query("select manche from jeu where num_partie = $num_partie");
        $joueurActu = getNomJoueurActuel();        
        
        echo 'Num Partie : $num_partie\n';
        echo 'Num Manche : $manche\n';
        echo 'Joueur Actuel : $joueurActu\n';   
        
        echo '--------Passage au joueur suivant--------\n\n';
        
        passerJoueurSuivant();
        
        $joueurActu = getNomJoueurActuel();
        
        echo 'Joueur Actuel : $joueurActu\n';   
    }
}

