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
        $q = $this->db->query("select id_carte from cartes where num_partie=?", Array($_SESSION["num_partie"]));
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

    
    function getJoueurActuel(){
        $q = $this->db->query("select joueur_actu from jeu where num_partie = ".$_SESSION['num_partie']."");
        return $q->row()->JoueurActu;
    }
    
    function passerJoueurSuivant(){
        $nb_joueurs = $this->db->query("select nb_joueurs from jeu where num_partie=".$_SESSION['num_partie']."");
        $q = $this->db->query("select joueur_actu from jeu where num_partie=".$_SESSION['num_partie']."");
        if ($q >= $nb_joueurs - 1) {
            $this->db->query("update jeu set joueur_actu=0 where num_partie=".$_SESSION['num_partie'] . "");
        } else {
            $this->db->query("update jeu set joueur_actu=joueur_actu+1 where num_partie=".$_SESSION['num_partie'] . "");
        }
    }
    
    function jouerCarte($id_joueur, $id_carte){
       //a remplir avec r�gles
        passerJoueurSuivant();
    }

    function ajouterJoueur(){
        $q = $this->db->query("insert into joueurs values ('defaut', 0, 0)");
        $q = $this->db->query("select last_insert_id() as insert_id");
        return $q->row()->insert_id;
    }

    function enregistrer($nom){
        //return "<strong>enregistrement</strong>";
        $q = $this->db->query("update joueurs set nom=$nom where id_joueur=".$_SESSION["id"]);
    }

    function getPartie(){
        $q = $this->db->query("select num_partie from jeu");
        $_SESSION["num_partie"] =  $q->row()->num_partie;
        return $_SESSION["num_partie"];
    }
}

