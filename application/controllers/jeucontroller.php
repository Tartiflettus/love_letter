<?php

class JeuController extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('jeumodel');
        $this->load->database();
    }

    public function view($page = 'jeu') {
        /* if ( ! file_exists(APPPATH.'views/pages/'.$page.'.php'))
          {
          // Whoops, we don't have a page for that!
          show_404();
          } */

        $data['title'] = "jeu";

        $this->load->view('pages/' . $page, $data);
    }

    public function test() {
        $this->jeumodel->getPartie(); //obtenir session de num_partie
        $this->jeumodel->ajouterJoueur();
        $this->jeumodel->enregistrer("patate");
        $this->jeumodel->lancerJeu();

        $this->testPioche();

        //sélectionner la carte à poser
        $q = $this->db->query("select id_carte from carte where main_joueur=?",
            Array($_SESSION["id"]));

        $this->jeumodel->jouerCarte($q->row()->id_carte);
        $this->jeumodel->passerJoueurSuivant();
    }


    public function testPioche(){
        if($this->jeumodel->getNumJoueurActuel() == $_SESSION["num_joueur"]){
            $this->jeumodel->piocher();
            echo "bien";
        }else{
            echo "pas bien";
        }
    }

}

