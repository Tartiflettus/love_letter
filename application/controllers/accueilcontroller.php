<?php


class AccueilController extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('jeumodel');
        $this->load->database();
        $this->load->controller('jeucontroller');
    }

    public function index(){
        $this->load->view("pages/index");
    }

    public function enregistrer(){
        $nom = $_POST["nom"];
        $this->jeumodel->enregistrer($nom);

        $this->jeucontroller->view();
    }


}