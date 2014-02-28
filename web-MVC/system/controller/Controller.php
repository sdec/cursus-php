<?php

class Controller
{
    protected $_template;
    protected $_loader;
    protected $_input;

    public function __construct()
    {
        // Loader initialiseren
        $this->_loader = Loader::getInstance();

        // input class initialiseren
        $this->_input = new Input();
        
        $this->_template = new Template();
        
        $this->_template->setPartial('header');
        $this->_template->setPartial('navigation');
        $this->_template->setPartial('message');
        $this->_template->setPartial('scripts');

        // haal de statusberichten uit een sessie, dus van een vorige pagina voor de redirect
        $this->_getStatusMessage();

    }

    private function _getStatusMessage()
    {
        if (isset($_SESSION['statusMessage'])) {
            $this->_template->setStatusMessage($_SESSION['statusMessage']);

            unset($_SESSION['statusMessage']);
        }
    }

}