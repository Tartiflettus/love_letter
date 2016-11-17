<?php
/**
 * Created by PhpStorm.
 * User: perso
 * Date: 12/11/2016
 * Time: 23:01
 */

class JeuModel extends CI_Model {
    function getTaillePioche(){
        $this->db->query("select count(*) from cartes where statut='pioche'");
    }

    function piocheEstVide(){
        return $this->getTaillePioche() == 0;
    }

    //piocher une carte dans la pioche
    function piocher(){
        $q = $this->db->query("select id from cartes where num_partie=?", Array($_SESSION["num_partie"]));
        $indice = rand(0, $q->num_rows());

        if($indice < $q->num_rows()) {
            $this->db->query("update cartes set statut='main' idMain=? where id=?",
                Array($_SESSION["id"], $q->row($indice)));
        }
    }

    function ajouterJoueur(){
        $q = $this->db->query("insert into joueurs values ('defaut', 0, 0)");
        $q = $this->db->query("select last_insert_id() as insert_id");
        return $q->row()->insert_id;
    }
}

    function enregistrer($nom){
        $q = $this->db->query("update joueurs set nom=$nom where id=".$_SESSION["id"]);
    }
}