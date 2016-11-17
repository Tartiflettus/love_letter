<?php


class AccueilController extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('jeumodel');
    }

    public function index(){

        //page d'authentification
        $this->load->view("pages/index");
    }

    public function enregistrer($nom){
        $this->jeumodel->enregistrer($nom);
        echo "success";
    }

    public function

}