<?php


class AccueilController extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('jeumodel');
    }

    public function index(){
        $_SESSION["num_partie"] = $this->model->getPartie();
        $data["num_partie"] = $_SESSION["num_partie"];

        $this->load->view("pages/index", $data);
    }

    public function enregistrer($nom){
        $this->model->enregistrer($nom);
        echo "success";
    }


}