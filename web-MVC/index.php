<?php
// constanten ivm de paths
define('APPLICATION_PATH', 'afsprakenplanner/');
define('SYSTEM_PATH', 'includes/');
require_once(SYSTEM_PATH . 'config/routes.php');

// require before unserializing object from session
//require_once(SYSTEM_PATH . 'model/Message.php');
//require_once(SYSTEM_PATH . 'view/viewHelper.php');
require_once(SYSTEM_PATH . 'config/database.php');

require_once(SYSTEM_PATH . 'model/Db.php');
require_once models_url() . 'UserModel.php';
//require_once(SYSTEM_PATH . 'model/Mapper.php');
//require_once(SYSTEM_PATH . 'model/Identifiable.php');
//require_once(SYSTEM_PATH . 'model/Validator.php');
//require_once(SYSTEM_PATH . 'model/Auth.php');

require_once(SYSTEM_PATH . 'controller/Controller.php');
require_once helpers_url()  . 'form_helper.php';

/*require_once(SYSTEM_PATH . 'controller/FrontController.php');
require_once(SYSTEM_PATH . 'controller/Loader.php');
require_once(SYSTEM_PATH . 'controller/Input.php');
require_once(SYSTEM_PATH . 'controller/routeHelpers.php');

require_once(SYSTEM_PATH . 'view/Template.php');
require_once(SYSTEM_PATH . 'view/viewHelpers.php');

require_once(APPLICATION_PATH . 'controller/AdminController.php');*/

session_start();

require_once SYSTEM_PATH . 'config/sessions.php';

/*$frontController = new FrontController();
$frontController->run();*/

require_once(APPLICATION_PATH.'controller/ProfileController.php');

$login = new ProfileController();
$login->index();

echo(getCurrentPath());