<?php

/**
 * Created by PhpStorm.
 * User: perso
 * Date: 12/11/2016
 * Time: 23:01
 */
session_start();

class JeuModel extends CI_Model {

    function getTaillePioche() {
        $this->db->query("select count(*) from carte where statut='pioche'");
    }

    function piocheEstVide() {
        return $this->getTaillePioche() == 0;
    }

    //piocher une carte dans la pioche
    function piocher() {
        $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
        $indice = rand(0, $q->num_rows() - 1);

        if ($indice < $q->num_rows()) {
            var_dump($this->db->query("update carte set statut='main', joueur=? where id_carte=?",
                Array($_SESSION["id"], $q->row($indice)->id_carte) ) );
        } else {
            http_response_code(500);
            exit();
        }
    }

    //renvoie le num�ro du joueur actuel entre 1 et 4
    function getNumJoueurActuel() {
        $q = $this->db->query("select joueur_actu from jeu where num_partie =?", Array($_SESSION["num_partie"]));
        return $q->row()->joueur_actu;
    }

    function passerJoueurSuivant() {
        $nbJ = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        $nb_joueurs = $nbJ->row()->nb_joueurs;
        $q = $this->db->query("select joueur_actu from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        $jA = $q->row()->joueur_actu;
        if ($jA >= $nb_joueurs) {
            $this->db->query("update jeu set joueur_actu=1 where num_partie=?", Array($_SESSION["num_partie"]));
        } else {
            $this->db->query("update jeu set joueur_actu=joueur_actu+1 where num_partie=?", Array($_SESSION["num_partie"]));
        }
    }

    function jouerCarte($id_carte) {
        $this->db->query("update carte set statut='pose', joueur=? where id_carte=?",
            Array($_SESSION["id"], $id_carte));
    }

    function ajouterJoueur() {
        //mettre à jour le nombre de joueurs du jeu
        $q = $this->db->query("update jeu set nb_joueurs=nb_joueurs+1 where num_partie=?", Array($_SESSION["num_partie"]));
        $q = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["num_partie"]));


        echo "num_partie : ".$_SESSION["num_partie"];
        $nb = $q->row()->nb_joueurs;
        $_SESSION["num_joueur"] = $nb;
        echo "<br/>num_joueur : ".$_SESSION["num_joueur"];


        //ajouter effectivement le joueur
        $q = $this->db->query("insert into joueurs (nom, points, elimine, num_partie, num_joueur) values ('defaut', 0, 0, ?, ?)", Array($_SESSION["num_partie"], $nb));
        $q = $this->db->query("select last_insert_id() as insert_id"); //récupérer son id
        $_SESSION["id"] = $q->row()->insert_id;
        return $_SESSION["id"];
    }

    function enregistrer($nom) {
        //return "<strong>enregistrement</strong>";
        $q = $this->db->query("update joueurs set nom=? where id=?", Array($nom, $_SESSION["id"]));
    }

    function getPartie() {
        $q = $this->db->query("select num_partie from jeu");
        $_SESSION["num_partie"] = $q->row()->num_partie;
        return $_SESSION["num_partie"];
    }

    function getNomJoueurActuel() {
        $num_joueur_actu = $this->getJoueurActuel();
        $join = $this->db->query("jeu join joueur using(joueur_1, joueur_2, joueur_3, joueur_4)");
        $q = $this->db->query("select nom from joueur where nb_joueur=? and num_partie=?", $num_joueur_actu, Array($_SESSION["num_partie"]));
        return $q->row()->nom;
    }

    function remplirJeuCarte() {
        $this->db->query("insert into carte (valeur, num_partie, image) values (8, " . $_SESSION['num_partie'] . ",'images_cartes/princess.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (7, " . $_SESSION['num_partie'] . ", 'images_cartes/countess.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (6, " . $_SESSION['num_partie'] . ", 'images_cartes/king.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (5, " . $_SESSION['num_partie'] . ", 'images_cartes/prince.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (5, " . $_SESSION['num_partie'] . ", 'images_cartes/prince.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (4, " . $_SESSION['num_partie'] . ", 'images_cartes/handmaid.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (4, " . $_SESSION['num_partie'] . ", 'images_cartes/handmaid.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (3, " . $_SESSION['num_partie'] . ", 'images_cartes/baron.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (3, " . $_SESSION['num_partie'] . ", 'images_cartes/baron.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (2, " . $_SESSION['num_partie'] . ", 'images_cartes/priest.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (2, " . $_SESSION['num_partie'] . ", 'images_cartes/priest.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, " . $_SESSION['num_partie'] . ", 'images_cartes/guard.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, " . $_SESSION['num_partie'] . ", 'images_cartes/guard.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, " . $_SESSION['num_partie'] . ", 'images_cartes/guard.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, " . $_SESSION['num_partie'] . ", 'images_cartes/guard.png')");
        $this->db->query("insert into carte (valeur, num_partie, image) values (1, " . $_SESSION['num_partie'] . ", 'images_cartes/guard.png')");
    }

    function deuxJoueurs() {
        for ($i = 0; $i <= 3; $i++) {
            $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
            $indice = rand(0, $q->num_rows());

            if ($indice < $q->num_rows()) {
                $this->db->query("update carte set statut='retire' where id=?", Array($q->row($indice)));
            } else {
                http_response_code(500);
                exit();
            }
        }
    }

    function nbJoueurs() {
        $q = $this->db->query("select count(*) as nb from joueurs join jeu using(num_partie) where num_partie=?", Array($_SESSION["num_partie"]));
        return $q->row()->nb;
    }

    function defausseCarte() {
        $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
        $indice = rand(0, $q->num_rows());

        if ($indice < $q->num_rows()) {
            $this->db->query("delete from carte where id_carte=?", Array($q->row($indice)->id_carte));
        } else {
            http_response_code(500);
            exit();
        }
    }

    function distribuerCartes() {
        $nb = $this->nbJoueurs();
        $q_joueurs = $this->db->query("select id from joueurs join jeu using(num_partie)");

        for($i = 1; $i <= $nb; $i++) {

            $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
            $indice = rand(0, $q->num_rows());

            if ($indice < $q->num_rows()) {
                $this->db->query("update carte set statut='main', joueur=? where id_carte=?",
                    Array($q_joueurs->row($i)->id, $q->row($indice)->id_carte));
            } else {
                http_response_code(500);
                exit();
            }

        }
    }

    function lancerJeu() {
        $this->remplirJeuCarte();
        //joueur actuel : default 1
        //manche : default 0
        if ($this->nbJoueurs() === 2) {
            $this->deuxJoueurs();
        }
        $this->defausseCarte();
        $this->distribuerCartes();
    }

}
