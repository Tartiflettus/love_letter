<?php


class AccueilController extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('jeumodel');
        $this->load->database();
    }

    public function index(){
        $_SESSION["num_partie"] = $this->jeumodel->getPartie();
        $data["num_partie"] = $_SESSION["num_partie"];

        $this->load->view("pages/index", $data);
    }

    public function enregistrer($nom){
        $this->jeumodel->enregistrer($nom);
        echo "success";
    }


}