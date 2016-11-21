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
    
    //renvoie le num�ro du joueur actuel entre 1 et 4
    function getNumJoueurActuel(){
        $q = $this->db->query("select joueur_actu from jeu where num_partie =?", Array($_SESSION["num_partie"]));
        return $q->row()->JoueurActu;
    }
    
    function passerJoueurSuivant(){
        $nb_joueurs = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        $q = $this->db->query("select joueur_actu from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        if ($q >= $nb_joueurs) {
            $this->db->query("update jeu set joueur_actu=1 where num_partie=?", Array($_SESSION["num_partie"]));
        } else {
            $this->db->query("update jeu set joueur_actu=joueur_actu+1 where num_partie=?", Array($_SESSION["num_partie"]));
        }
    }
    
    function jouerCarte($id_joueur, $id_carte){
       //a remplir avec r�gles
       $this->db->query("update carte set statut='pose' where pose_joueur=? and id_carte=?", $id_joueur, $id_carte);
       passerJoueurSuivant();
    }

    function ajouterJoueur(){
        //mettre à jour le nombre de joueurs du jeu
        $q = $this->db->query("update jeu set nb_joueurs=nb_joueurs+1 where num_partie=?", Array($_SESSION["num_partie"]));
        $q = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["id"]));

        $nb = $q->row()->nb_joueurs;

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
        for ($i=0; $i<=3; $i++){
            $q = $this->db->query("select id_carte from cartes where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
            $indice = rand(0, $q->num_rows());

            if($indice < $q->num_rows()) {
                $this->db->query("update cartes set statut='retire' where id=?",
                                    Array($q->row($indice)));
            }
            else{
                http_response_code(500);
                exit();
            }
        }
    }


    function nbJoueurs(){
        $q = $this->db->query("select count(*) as nb from joueurs join jeu using(num_partie) where num_partie=?",
            Array($_SESSION["num_partie"]));
        return $q->row()->nb;
    }
        
    function defausseCarte(){
        $q = $this->db->query("select id_carte from cartes where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
            $indice = rand(0, $q->num_rows());

            if($indice < $q->num_rows()) {
                $this->db->query("delete from carte where id=?",
                                    Array($q->row($indice)));
            }
            else{
                http_response_code(500);
                exit();
            }
    }
    
    function distribuerCartes(){
            $q = $this->db->query("select id_carte from cartes where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
            $indice = rand(0, $q->num_rows());

            if($indice < $q->num_rows()) {
                $this->db->query("update cartes set statut='main' main_joueur=? where id=?",
                                  Array($_SESSION["id"]), Array($q->row($indice)));
            }
            else{
                http_response_code(500);
                exit();
            }
    }
    
    function lancerJeu(){
        remplirCarte();
        //joueur actuel : default 1
        //manche : default 0
        if(nbJoueurs() === 2){
            deuxJoueurs();
        }
        carteDefausse();
    }
}

