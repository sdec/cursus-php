<?php
class Template
{
    protected $data = array();
    protected $content = array();
    protected $partials = array();
    protected $_auth;
    protected $layoutfile;
    private $_styles = array();
    private $pagetitle;
    private $statusMessage;
    private $fieldMessages = array();

    // on instantiation: check the layoutfile
    public function __construct($layout = 'default')
    {
        // Loader initialiseren
        $this->_loader = Loader::getInstance();
        $this->layoutfile = $this->_loader->getLayout($layout);

        $this->_auth = Auth::getInstance();
    }

    // render the main content of the site
    // while rendering the layout, render the partials as well
    public function render($template)
    {
        $this->content = $this->renderView($this->_loader->getView($template));
        $this->renderLayout();
    }

    // helper to display the content in the layout template
    public function getContent()
    {
        echo $this->content;
    }

    // first stap generate partial
    public function renderPartial($name)
    {
        if (array_key_exists($name, $this->partials)) {
            echo $this->renderView($this->partials[$name]);
        } else {
            error_log("partial not rendered: $name");
        }
    }

    // second step: generate the layout
    public function renderLayout()
    {
        include($this->layoutfile);
    }

    // helper to generate a partial
    public function setPartial($partialname, $partialfile = '')
    {
        // if $partialfile is not set, use the partialname as filename
        $partialfile = ($partialfile) ? $partialfile : $partialname;

        $this->partials[$partialname] = $this->_loader->getPartial($partialfile);

        return $this;
    }

    // render a view (partial or main content)
    private function renderView($view)
    {
        // we are cheating here, creating an output buffer to get a rendered partial and store its content in a var.
        ob_start();
        include($view);
        $data = ob_get_contents();
        ob_end_clean();

        return $data;
    }

    public function setPagetitle($title)
    {
        $this->pagetitle = $title;
    }

    public function getPagetitle()
    {
        return $this->pagetitle;
    }

    public function setStatusMessage($statusMessage)
    {
        $this->statusMessage = $statusMessage;
    }

    public function getStatusMessage()
    {
        return $this->statusMessage;
    }

    public function setFieldMessages($fieldMessages)
    {
        $this->fieldMessages = $fieldMessages;
    }

    public function getFieldStatus($key)
    {
        $status = '';
        if (isset($this->fieldMessages[$key])) {
            $status = ($this->fieldMessages[$key]->getStatus()) ? 'has-success' : 'has-error';
        }
        return $status;
    }

    public function getFieldMessage($key)
    {
        $status = '';
        if (isset($this->fieldMessages[$key])) {
            $status = $this->fieldMessages[$key]->getMessage();
        }
        return $status;
    }

    public function setStyle($style, $reset = false)
    {
        if ($reset) {
            $this->_styles = array();
        }

        $this->_styles[] = $style;
    }

    // automatic getter and setter, remapping every value to the protected attribute
    // read more about this on www.php.net/manual/en/language.oop5.overloading.php
    public function __set($name, $value)
    {
        $this->data[$name] = $value;
    }

    public function __get($name)
    {

        if (array_key_exists($name, $this->data)) {
            return $this->data[$name];
        }
        return false;
    }

    protected function _getCurrentUser()
    {
        return $this->_auth->getCurrentUser();
    }

    protected function _checkIfUserHasRequiredAccessLevel($requiredAccessLevel)
    {
        if ($this->_getCurrentUser()) {
            return ($this->_auth->getUserAccessLevel() >= $requiredAccessLevel);
        } else {
            return false;
        }
    }
}

