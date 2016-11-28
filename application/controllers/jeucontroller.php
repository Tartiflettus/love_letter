<?php

class JeuController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('jeumodel');
        $this->load->database();
    }

    public function view() {

        $data["nomJoueurActu"] = $this->jeumodel->getNomJoueurActu();
        $data["actionActu"] = $this->jeumodel->getActionActu();

        $data["main1"] = $this->jeumodel->getMain();
        $data["main2"] = $this->jeumodel->getMainAutres(1);
        $data["main3"] = $this->jeumodel->getMainAutres(2);
        $data["main4"] = $this->jeumodel->getMainAutres(3);

        $data['title'] = "jeu";

        $data["pose1"] = $this->jeumodel->getPose();
        $data["pose2"] = $this->jeumodel->getPoseAutres(1);
        $data["pose3"] = $this->jeumodel->getPoseAutres(2);
        $data["pose4"] = $this->jeumodel->getPoseAutres(3);

        $data["retires"] = $this->jeumodel->getRetires();

        $data["nbjoueurs"] = $this->jeumodel->nbJoueurs();

        $this->load->view('pages/jeu.php', $data);
    }

    public function test() {
        $this->jeumodel->getPartie(); //obtenir session de num_partie
        //premier joueur
        $this->jeumodel->ajouterJoueur();
        $this->jeumodel->enregistrer("patate");

        //second joueur
        $q = $this->db->query("insert into joueurs (nom, points, elimine, num_partie, num_joueur) values ('reblochon', 0, 0, ?, ?)", Array($_SESSION["num_partie"], 1));
        $this->db->query("update jeu set nb_joueurs=nb_joueurs+1 where num_partie=?", Array($_SESSION["num_partie"]));

        $this->jeumodel->lancerJeu();

        $this->testPioche();

        //sélectionner la carte à poser
        $q = $this->db->query("select id_carte from carte where joueur=?", Array($_SESSION["id"]));

        $this->jeumodel->jouerCarte($q->row()->id_carte);
        $this->jeumodel->passerJoueurSuivant();
        var_dump($this->jeumodel->getMainAutres(1));
        var_dump($this->jeumodel->getPoseAutres(0));
        var_dump($this->jeumodel->getRetires());
        var_dump($this->jeumodel->getNbCartesPioche());
    }

    public function testPioche() {
        if ($this->jeumodel->getNumJoueurActuel() == $_SESSION["num_joueur"]) {
            $this->jeumodel->piocher();
            echo "bien";
        } else {
            echo "pas bien";
        }
    }

    public function action($arg1 = "rien") {
        if ($this->jeumodel->getEtat() === "pose") {
            echo isset($_POST["c0"]);
            echo isset($_POST["c1"]);
            if (isset($_POST["c0"])) {
                $this->jeumodel->action($_POST["c0"]);
            } else if (isset($_POST["c1"])) {
                $this->jeumodel->action($_POST["c1"]);
            }
        } else {
            $this->jeumodel->action($arg1);
        }

        //echo "Location : ".base_url()."index.php/jeucontroller/view";
        //header("Location : ".base_url()."index.php/jeucontroller/view");
        //exit();
        $this->view();
    }

    public function initJ2() {
        $_SESSION["id"] = 2;
        $_SESSION["num_joueur"] = 1;
        $_SESSION["num_partie"] = 1;
        echo "j2 initialisé";
    }

}
