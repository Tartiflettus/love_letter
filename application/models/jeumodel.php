<?php

/**
 * Created by PhpStorm.
 * User: perso
 * Date: 12/11/2016
 * Time: 23:01
 */
session_start();
/* if (session_start()) {
  echo "<p>La session démarre</p>";
  } else {
  echo "<strong>Problème démarrage session</strong>";
  } */

class JeuModel extends CI_Model {

    function getTaillePioche() {
        $q = $this->db->query("select count(*) as cnt from carte where statut='pioche' and num_partie=?", Array($_SESSION["num_partie"]));

        return $q->row()->cnt;
    }

    function piocheEstVide() {
        return $this->getTaillePioche() == 0;
    }

    //piocher une carte dans la pioche
    function piocher($joueur = "session") {
        /*if($joueur != "session"){
            echo "<script>alert('pioche adverse !');</script>";
        }*/

        $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
        $indice = rand(0, $q->num_rows() - 1);

        if ($indice < $q->num_rows()) {
            if ($joueur == "session") {
                $this->db->query("update carte set statut='main', joueur=? where id_carte=?", Array($_SESSION["id"], $q->row($indice)->id_carte));
            } else {
                $this->db->query("update carte set statut='main', joueur=? where id_carte=?", Array($joueur, $q->row($indice)->id_carte));
            }
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
        if ($jA == $nb_joueurs - 1) {
            $this->db->query("update jeu set joueur_actu=0 where num_partie=?", Array($_SESSION["num_partie"]));
        } else {
            $this->db->query("update jeu set joueur_actu=joueur_actu+1 where num_partie=?", Array($_SESSION["num_partie"]));
        }
    }

    function jouerCarte($id_carte) {
        $this->db->query("update carte set statut='pose', joueur=? where id_carte=?", Array($_SESSION["id"], $id_carte));
    }

    function ajouterJoueur() {
        //mettre à jour le nombre de joueurs du jeu
        $q = $this->db->query("update jeu set nb_joueurs=nb_joueurs+1 where num_partie=?", Array($_SESSION["num_partie"]));
        $q = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["num_partie"]));


        //echo "num_partie : " . $_SESSION["num_partie"];
        $nb = $q->row()->nb_joueurs;
        $_SESSION["num_joueur"] = $nb - 1;
        //echo "<br/>num_joueur : " . $_SESSION["num_joueur"];


        //ajouter effectivement le joueur
        $q = $this->db->query("insert into joueurs (nom, points, elimine, num_partie, num_joueur) values ('defaut', 0, 0, ?, ?)", Array($_SESSION["num_partie"], $nb - 1));
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
        $join = $this->db->query("jeu join joueurs using(joueur_1, joueur_2, joueur_3, joueur_4)");
        $q = $this->db->query("select nom from joueurs where nb_joueur=? and num_partie=?", $num_joueur_actu, Array($_SESSION["num_partie"]));
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
        for ($i = 0; $i < 3; $i++) {
            $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
            $indice = rand(0, $q->num_rows() - 1);

            if ($indice < $q->num_rows()) {
                $this->db->query("update carte set statut='retire' where id_carte=?", Array($q->row($indice)->id_carte));
            } else {
                http_response_code(500);
                exit();
            }
        }
    }

    function nbJoueurs() {
        $q = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        return $q->row()->nb_joueurs;
    }

    function defausseCarte() {
        $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
        $indice = rand(0, $q->num_rows() - 1);

        if ($indice < $q->num_rows()) {
            $this->db->query("delete from carte where id_carte=?", Array($q->row($indice)->id_carte));
        } else {
            http_response_code(500);
            exit();
        }
    }

    //a tester
    function defausserCarteMain($id_carte) {
        //cas o� princesse d�fauss�e
        $carte = $this->getValeur($id_carte);
        if ($carte == 8) {
            $q = $this->db->query("select id from carte join joueurs using(num_partie) where id_carte = ?", Array($id_carte));
            $id_joueur = $q->row()->id;
            $this->db->query("update joueurs set elimine=1 where id=?", Array($id_joueur));
        }
        //regarder carte selec pour suppression 
        $this->db->query("update carte set statut='defausse' where id_carte=?", Array($id_carte));
    }

    function distribuerCartes() {
        $nb = $this->nbJoueurs();
        $q_joueurs = $this->db->query("select id from joueurs join jeu using(num_partie) where num_partie=?", Array($_SESSION["num_partie"]));

        for ($i = 1; $i <= $nb; $i++) {

            $q = $this->db->query("select id_carte from carte where num_partie=? and statut = 'pioche'", Array($_SESSION["num_partie"]));
            $indice = rand(0, $q->num_rows() - 1);

            if ($indice < $q->num_rows()) {
                $this->db->query("update carte set statut='main', joueur=? where id_carte=?", Array($q_joueurs->row($i - 1)->id, $q->row($indice)->id_carte));
                //echo "bon nombre aléatoire";
            } else {
                //echo "mauvais nombre aléatoire";
                http_response_code(500);
                exit();
            }
        }
    }

    function lancerJeu() {
        $this->remplirJeuCarte();
        //joueur actuel : default 1
        //manche : default 0
        if ($this->nbJoueurs() <= 2) {
            $this->deuxJoueurs();
            //echo "mode 2 joueurs séléctionné";
        }
        $this->defausseCarte();
        $this->distribuerCartes();
    }

    function getMain() {
        $q = $this->db->query("select id_carte, image, valeur from joueurs join carte on(carte.joueur=joueurs.id) where id=? and statut='main'", Array($_SESSION["id"]));
        return $q->result();
    }

    function getPose() {
        $q = $this->db->query("select id_carte, image from joueurs join carte on(carte.joueur=joueurs.id) where id=? and statut='pose'", Array($_SESSION["id"]));
        return $q->result();
    }

    //helper pour getMainautres et getPoseAutres
    private function getXAutres($numJoueur, $statut) {
        //il faut le nombre de joueurs
        $q = $this->db->query("select nb_joueurs from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        $nb = $q->row()->nb_joueurs;

        //on cherche l'id du joueur à $numJoueur de distance de nous
        $q = $this->db->query("select id from joueurs join jeu using(num_partie) where num_joueur=?", Array(($_SESSION["num_joueur"] + $numJoueur) % $nb));
        $idCible = $q->row()->id;

        $q = $this->db->query("select id_carte, image from carte join joueurs on(carte.joueur=joueurs.id) where statut=? and id=?", Array($statut, $idCible));

        return $q->result();
    }

    //récupère le nombre de cartes dans la main du joueur sépéré par $numJoueur de vous
    function getMainAutres($numJoueur) {
        return $this->getXAutres($numJoueur, "main");
    }

    function getPoseAutres($numJoueur) {
        return $this->getXAutres($numJoueur, "pose");
    }

    function getRetires() {
        $q = $this->db->query("select id_carte, image from carte where statut='retire' and num_partie=?", Array($_SESSION["num_partie"]));
        return $q->result();
    }

    function getNbCartesPioche() {
        $q = $this->db->query("select count(*) as cnt from carte where statut='pioche' and num_partie=?", Array($_SESSION["num_partie"]));
        return $q->row()->cnt;
    }

    function poser($idCarte) {
        $this->db->query("update carte set statut='pose' where id_carte=?", Array($idCarte));
        //$this->passerJoueurSuivant();
    }

    //fonction principale, dont le comportement dépends de l'état du jeu
    //arg1 id carte pour poser

    function action($arg1) {
        $q = $this->db->query("select etat, joueur_actu from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        $etat = $q->row()->etat;
        $actu = $q->row()->joueur_actu;

        //ne rien faire si ce n'est pas notre tour
        if ($actu != $_SESSION["num_joueur"]) {
            echo 'Tricheur';
            return;
        }
        switch ($etat) {
            case "pioche":
                $this->piocher();
                $this->countess();
                break;
            case "pose":
                $tmp = isset($_POST["c0"]) ? $_POST["c0"] : $_POST["c1"];
                $this->poser($tmp);
                $this->regle($tmp);
                break;
            case "choix":
                $this->application_regles($_POST["j2"]);
                break;
            case "supposition":
                $this->supposition($_POST["supposition"]);
                break;
            default:
                return;
        }
    }

    function countess() {
        $main = $this->getMain();
        $countess = -1;
        $prince = -1;
        $king = -1;
        for ($i = 0; $i < count($main); $i++) {
            switch ($main[$i]->valeur) {
                case 7:
                    $countess = $main[$i]->id_carte;
                    break;
                case 6:
                    $king = $main[$i]->id_carte;
                    break;
                case 5:
                    $prince = $main[$i]->id_carte;
                    break;
            }
        }
        if ($countess != -1) {
            if ($king != -1 || $prince != -1) {
                echo '<script>alert("Countess!!!");</script>';
                $this->defausserCarteMain($countess);
                $this->setEtat("pioche");
                $this->passerJoueurSuivant();
                return;
            }
        }
        $this->setEtat("pose");
    }

    function getValeur($id_carte) {
        $q_carte = $this->db->query("select valeur from carte where id_carte=?", Array($id_carte));
        return $q_carte->row()->valeur;
    }

    //@brief règle lorsque l'on pose la carte
    function regle($id_carte) {
        $q_carte = $this->db->query("select valeur from carte where id_carte=?", Array($id_carte));
        $carte = $q_carte->row()->valeur;
        switch ($carte) {
            case 1:
                $this->selectionner($id_carte);
                $this->setEtat("choix");
                break;
            case 3:
                $this->selectionner($id_carte);
                $this->setEtat("choix");
                break;
            case 6:
                $this->selectionner($id_carte);
                $this->setEtat("choix");
                break;
            case 5:
                $this->selectionner($id_carte);
                $this->setEtat("choix");
                break;
            case 8:
                $this->princesse();
                $this->setEtat("pioche");
                $this->passerJoueurSuivant();
                break;
            default:
                $this->setEtat("pioche");
                $this->passerJoueurSuivant();
                break;
        }
    }

    function setEtat($etat) {
        $this->db->query("update jeu set etat=? where num_partie=?", Array($etat, $_SESSION["num_partie"]));
    }

    function getNomJoueurActu() {
        $q = $this->db->query("select nom from joueurs join jeu using(num_partie)"
                . "where num_partie=? and joueurs.num_joueur=jeu.joueur_actu", Array($_SESSION["num_partie"]));

        assert($q->num_rows() == 1);
        return $q->row()->nom;
    }

    function getActionActu() {
        $q = $this->db->query("select etat from jeu where num_partie=?", Array($_SESSION["num_partie"]));

        return $q->row()->etat;
    }

    function getNomJoueur() {
        $q = $this->db->query("select nom from joueurs where id=?", Array($_SESSION["id"]));
        return $q->row()->nom;
    }

    function getNoms() {
        $q = $this->db->query("select nom from joueurs where num_partie=?", Array($_SESSION["num_partie"]));
        return $q->result();
    }

    function connaitPartie() {
        return isset($_SESSION["num_partie"]);
    }

    function connaitId() {
        return isset($_SESSION["id"]);
    }

    function connaitNumJoueur() {
        return isset($_SESSION["num_joueur"]);
    }

    function jeuEstLance() {
        return !$this->piocheEstVide();
    }

    function selectionner($idCarte) {
        $this->db->query("update jeu set carte_selec=$idCarte where num_partie=?", Array($_SESSION["num_partie"]));
    }

    function getSelectionner() {
        $q = $this->db->query("select carte_selec from jeu where num_partie=?", Array($_SESSION["num_partie"]));
        return $q->row()->carte_selec;
    }

    //@brief application de l'action après le choix
    function application_regles($id_carte_choisie) {
        $id_carte_selec = $this->getSelectionner();

        switch ($this->getValeur($id_carte_selec)) {
            case 1:
                $_SESSION["choisi"] = $id_carte_choisie;
                $this->setEtat("supposition");
                break;

            case 5:
                $joueur = $this->getPossesseurCarte($id_carte_choisie);
                //echo $joueur;
                //echo"coucou";
                $this->db->query("update carte set statut='defausse' where joueur=? and statut='main'", Array($joueur));
                $this->piocher($joueur);
                $this->setEtat("pioche");
                $this->passerJoueurSuivant();
                break;
            case 3:
                $this->baron($id_carte_choisie);
                $this->setEtat("pioche");
                $this->passerJoueurSuivant();
                break;
            case 6:
                //var_dump($id_carte_choisie);
                $this->echangerCartesAvec($this->getPossesseurCarte($id_carte_choisie));
                $this->setEtat("pioche");
                $this->passerJoueurSuivant();
                break;
            default:
                $this->setEtat("pioche");
                $this->passerJoueurSuivant();
                break;
        }
    }

    //retourne le joueur poss�dant la carte d'id $id_carte
    function getPossesseurCarte($id_carte) {
        $q = $this->db->query("select joueur from carte where id_carte=?", Array($id_carte));
        return $q->row()->joueur;
    }

    function elimine($id_joueur) {
        $this->db->query("update joueurs set elimine = '1' where id=?", Array($id_joueur));
    }

    function supposition($choix) {
        //echo 'CHOIX : ' . $choix;
        $valeurChoix = -1;
        $cartes = array('case_fictive', 'case_fictive', 'pretre', 'baron', 'servante', 'prince', 'roi', 'comtesse', 'princesse');
        for ($i = 0; $i < count($cartes); $i++) {
            if ($cartes[$i] == $choix) {
                $valeurChoix = $i;
                break;
            }
        }
        if ($valeurChoix != -1) {
            $valeurMain = $this->getValeur($_SESSION["choisi"]);
            if ($valeurMain == $valeurChoix) {
                $joueur = $this->getPossesseurCarte($_SESSION["choisi"]);
                $this->defausserCarteMain($_SESSION["choisi"]);
                $this->elimine($joueur);

                echo '<script>alert("Bien jou�");</script>';
            }
            $this->setEtat("pioche");
            $this->passerJoueurSuivant();
        } else {
            echo '<script>alert("entr�e incorrecte, recommence ");</script>';
        }
    }

    function reset() {
        $this->db->query("TRUNCATE `carte`");
        $this->db->query("TRUNCATE `jeu`");
        $this->db->query("TRUNCATE `joueurs`");
        $this->db->query("insert into Jeu (manche) values (0);");
    }

    function echangerCartesAvec($idJoueur) {
        //echo "<script>alert('id joueur à échanger : '+$idJoueur);</script>";
        //var_dump($idJoueur);
        $q_autre = $this->db->query("select id_carte from carte where joueur=? and statut='main'", Array($idJoueur));
        $this->db->query("update carte set joueur=? where joueur=?", Array($idJoueur, $_SESSION["id"]));

        foreach ($q_autre->result() as $row) {
            $this->db->query("update carte set joueur=? where id_carte=?", Array($_SESSION["id"], $row->id_carte));
        }
    }

    function baron($idCarteAutre) {
        $q = $this->db->query("select valeur from carte where id_carte=?", Array($idCarteAutre));
        $valAutre = $q->row()->valeur;

        if ($valAutre > 3) {
            $this->elimine($_SESSION["id"]);
        } else {
            $this->elimine($this->getPossesseurCarte($idCarteAutre));
        }
    }


    function princesse(){
        $this->elimine($_SESSION["id"]);
    }

}
