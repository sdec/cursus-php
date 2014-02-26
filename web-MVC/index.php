<?php

define('BASE_URL', './');
require_once(BASE_URL . 'system/helpers/route_helper.php');

// constanten ivm de paths
define('APPLICATION_PATH', BASE_URL . 'application/');
define('SYSTEM_PATH', BASE_URL . 'system/');


// require before unserializing object from session
//require_once(SYSTEM_PATH . 'model/Message.php');
//require_once(SYSTEM_PATH . 'view/viewHelper.php');
require_once(SYSTEM_PATH . 'config/database.php');
require_once(SYSTEM_PATH . 'helpers/database_helper.php');

require_once(SYSTEM_PATH . 'model/Db.php');
require_once models_url() . 'UserMapper.php';
//require_once(SYSTEM_PATH . 'model/Mapper.php');
//require_once(SYSTEM_PATH . 'model/Identifiable.php');
//require_once(SYSTEM_PATH . 'model/Validator.php');
//require_once(SYSTEM_PATH . 'model/Auth.php');

require_once(SYSTEM_PATH . 'controller/Controller.php');
//require_once helpers_url()  . 'form_helper.php';

require_once(SYSTEM_PATH . 'controller/FrontController.php');
/*require_once(SYSTEM_PATH . 'controller/Loader.php');
require_once(SYSTEM_PATH . 'controller/Input.php');

require_once(SYSTEM_PATH . 'view/Template.php');
require_once(SYSTEM_PATH . 'view/viewHelpers.php');

require_once(APPLICATION_PATH . 'controller/AdminController.php');*/

session_start();

require_once SYSTEM_PATH . 'helpers/session_helper.php';
echo($_SERVER['HTTP_HOST']);
$frontController = new FrontController();
$frontController->run();

/*require_once(APPLICATION_PATH.'controller/ProfileController.php');

$login = new ProfileController();
$login->index();*/