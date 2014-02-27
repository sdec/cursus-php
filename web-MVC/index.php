<?php

// Website name
define('SITE_NAME', 'Afspraken planner');

// Paths
define('BASE_URL', '/cursus-php/web-MVC/');
define('APPLICATION_PATH', 'application/');
define('SYSTEM_PATH', 'system/');

// System
require_once(SYSTEM_PATH . 'model/Db.php');

require_once(SYSTEM_PATH . 'controller/FrontController.php');
require_once(SYSTEM_PATH . 'controller/Controller.php');
require_once(SYSTEM_PATH . 'controller/Loader.php');
require_once(SYSTEM_PATH . 'controller/Input.php');

require_once(SYSTEM_PATH . 'view/Template.php');

// Config
require_once(APPLICATION_PATH . 'config/database.php');

// Helpers
require_once(APPLICATION_PATH . 'helpers/route_helper.php');
require_once(APPLICATION_PATH . 'helpers/session_helper.php');
require_once(APPLICATION_PATH . 'helpers/databank_helper.php');
require_once(APPLICATION_PATH . 'helpers/form_helper.php');

// Models
require_once(APPLICATION_PATH . 'model/UserMapper.php');
require_once(APPLICATION_PATH . 'model/AppointmentMapper.php');

$frontController = new FrontController();
$frontController->run();