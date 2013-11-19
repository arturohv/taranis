<?php
    class Main extends CI_Controller {
        function index() {
            $this->load->view('principal/header.php');
            $this->load->view('principal/content.php');
            $this->load->view('principal/footer.php');
        }
    }

?>
