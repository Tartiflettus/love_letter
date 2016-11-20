<?php


class AccueilController extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('jeumodel');
        $this->load->database();
    }

    public function index(){
        $this->jeumodel->getPartie();
        $data["num_partie"] = $_SESSION["num_partie"];

        $this->jeumodel->ajouterJoueur();
        $data["id_joueur"] = $_SESSION["id"];

        $this->load->view("pages/index", $data);
    }

    public function enregistrer($nom){
        echo $this->jeumodel->enregistrer($nom);
        echo "success";
    }


}