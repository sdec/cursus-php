<?php define('BASE_URL', '../');
require_once BASE_URL . 'includes/helpers/routes_helper.php';
require_once helpers_url() . 'sessions_helper.php';
require_once config_url() . 'database.php';
require_once helpers_url() . 'database_helper.php';
require_once models_url() . 'UserModel.php';
require_once helpers_url() . 'form_helper.php';

if(!isset($_GET['userid']))
    redirect('');

if (!loggedin())
    redirect('profile/login.php');

if (userdata('accesslevel') < ADMIN){
    message("Enkel admins mogen gebruikers deleten!", "info");
    redirect('');
}

$user = deleteUser($_GET['userid']);
if($user == FALSE){
    message("Onze excuses, er is *iets* mis gegaan met het deleten van user met id ".$_GET['$user']."!", "danger");
} else {
    message("De user werd succesvol gedelete!");
}
redirect('admin/users.php');

?>