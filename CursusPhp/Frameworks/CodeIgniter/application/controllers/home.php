<?php

class Home extends CI_Controller {
    
    public function index() {
        $this->template->write('title', 'Home');
        $this->template->write_view('content', 'home');
        $this->template->render();
    }
    
}