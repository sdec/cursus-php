<?php

class Controller
{
    protected $_template;
    protected $_loader;
    protected $_input;
    protected $_validator;
    protected $_auth;

    public function __construct()
    {
        // Loader initialiseren
        $this->_loader = Loader::getInstance();

        // input class initialiseren
        $this->_input = new Input();

        $this->_template = new Template();

        $this->_validator = new Validator();

        // authentication
        $this->_auth = Auth::getInstance();

        $menuMapper = $this->_loader->getModelMapper('menu');
        $this->_template->menuItems = $menuMapper->getMenuItems($this->_auth->getUserAccessLevel());

        $this->_template->setPartial('navbar');
        $this->_template->setPartial('headermeta');
        $this->_template->setPartial('statusMessage');
        $this->_template->setPartial('footer');

        $this->_template->setStyle('bootstrap.min.css');
        $this->_template->setStyle('eigenstijl.css');

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

    protected function _setStatusMessage($statusMessage, $resetStatusMessage = false)
    {
        // als reset: dan direct zetten en niet via sessie gaan
        if ($resetStatusMessage) {
            $this->_template->setStatusMessage($statusMessage);
        } else {
            $_SESSION['statusMessage'] = $statusMessage;
        }
    }

    protected function _setErrorMessages($message)
    {
        $statusMessage = new Message($message, false);
        $this->_setStatusMessage($statusMessage, true);
        $fieldMessages = $this->_validator->getFieldMessages();
        $this->_template->setFieldMessages($fieldMessages);
    }


    protected function _checkIfUserIsLoggedIn()
    {
        if ($this->_auth->getCurrentUser()) {
            return true;
        } else {
            $this->_setStatusMessage(new Message('Log in om deze pagina te bekijken.', false));
            redirect('home/login');
        }

        return false;
    }

    protected function _checkIfUserHasRequiredAccessLevel($requiredAccessLevel)
    {
        if ($this->_checkIfUserIsLoggedIn()) {
            if ($this->_auth->getUserAccessLevel() >= $requiredAccessLevel) {
                return true;
            } else {
                $this->_setStatusMessage(new Message('Je hebt niet het juiste gebruikersniveau om deze pagina te bekijken.', false));

                // todo: eventueel loggen van poging

                redirect('home/index');
            }
        }

        return false;
    }

}