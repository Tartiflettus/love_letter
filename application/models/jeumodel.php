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
    function piocher($nomJoueur){
        assert(isset($idJoueur) && is_numeric($idJoueur) && 0 <= $idJoueur && $idJoueur <= 4);

        $q = $this->db->query("select id from cartes");
        $indice = rand(0, $q->num_rows());
        $i = 0;
        foreach($q->result() as $row){
            if($i == $indice){
                $this->db->query("update cartes set statut='main' idMain=$idJoueur");
                break;
            }
            $i++;
        }
    }

    function enregistrer($nom){
        $q = $this->db->query("insert into joueurs values ($nom, '0.0.0.0 ', 0, 0, 0)");

    }
}