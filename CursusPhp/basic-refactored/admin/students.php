<?php
define('BASE_URL', '../');
require_once BASE_URL . 'includes/config/routes.php';
require_once config_url()   . 'sessions.php';
require_once config_url() . 'database.php';
require_once models_url() . 'UserModel.php';

if(!loggedin())
    redirect('profile/login.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';

if(userdata('accesslevel') >= ADMIN){
    //display all users
    $users = strlen($search)
        ? searchUsers($search)
        : users();
} else { //otherwise display students only
    $users = strlen($search) 
        ? searchStudents($search) 
        : students();
}

$data['users'] = $users;
$data['search'] = $search;

function getRole($index){
    switch ($index) {
        case STUDENT:
            return "Student";
            break;
        CASE LECTURER:
            return "Lector";
            break;
        CASE ADVISOR:
            return "Studieadviseur";
            break;
        CASE ADMIN:
            return "Admin";
            break;
        default:
            return "Error";
            break;
    }
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Beheer - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            
            <h1>Gebruikers</h1>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td>Naam</td>
                        <?php if(userdata('accesslevel') >= ADMIN): ?>
                            <td>Username</td>
                        <?php else: ?>
                            <td>StudNr</td>
                        <?php endif; ?>
                        <td>Email</td>
                        <td>Type profiel</td>
                        <!--<?php //if(userdata('accesslevel') >= ADMIN): ?>
                            <td>Ken rechten toe</td>
                            <td>Vertegenwoordig</td>
                        <?php //elseif(userdata('accesslevel') >= ADVISOR): ?>
                            <td>Vertegenwoordig</td>
                        <?php //endif; ?>-->
                    </tr>
                </thead>
                <tbody>
                    <?php if ($users) { ?>
                        <?php foreach ($users as $user) { ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url() ?>profile/view.php?userid=<?= $user['userid'] ?>">
                                        <span class="glyphicon glyphicon-eye-open"></span> 
                                    </a>
                                </td>
                                <td><?= $user['firstname'].' '.$user['lastname']; ?></td>
                                <td><?= $user['username']; ?></td>
                                <td>
                                    <a href="<?= 'mailto:'.$user['email'] ;?>"><?= $user['email'] ;?></a>
                                </td>
                                <td><?= getRole($user['accesslevel']); ?> </td>
                                <!--<?php// if(userdata('accesslevel') >= ADMIN): ?>
                                    <td>
                                        <a href="<?= base_url() ?>admin/edit.php?userid=<?= $user['userid'] ?>">
                                            <span class="glyphicon glyphicon-edit"></span> 
                                        </a>
                                    </td>
                                    <td>
                                        <a href="<?= base_url() ?>admin/act_as.php?userid=<?= $user['userid'] ?>">
                                            <span class="glyphicon glyphicon-briefcase"></span> 
                                        </a>
                                    </td>
                                <?php //elseif(userdata('accesslevel') >= ADVISOR): ?>
                                    <td>
                                        <a href="<?= base_url() ?>admin/act_as.php?userid=<?= $user['userid'] ?>">
                                            <span class="glyphicon glyphicon-briefcase"></span> 
                                        </a>
                                    </td>
                                <?php //endif; ?> -->
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="6">Er zijn geen personen om te tonen.</td></tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="row">
                <!--<div class="col-lg-3 col-md-3 col-sm-3">
                    <?php //if (userdata('accesslevel') >= LECTURER) { ?>
                        <p><a href="<?= base_url() . 'admin/students.php' ?>appointments/create.php" class="btn btn-primary">Nieuwe afspraak</a></p>
                    <?php //} ?>
                </div>-->
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <form class="form-horizontal" method="get" action="<?= base_url() . 'admin/students.php' ?>" role="form">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Zoek gebruikers op voornaam, familienaam, gebruikersnaam of email." value="<?= @$_GET['search']; ?>" />
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" class="form-control btn btn-primary" value="Zoek" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?php if (strlen($search)) { ?>
                        <hr />
                        <p>Er werden <strong><?= $users == FALSE ? 0 : count((array) $users) ?></strong> gebruikers gevonden die voldoen aan uw zoekterm "<?= $search ?>".</p>
                        <a href="<?= base_url() ?>" class="btn btn-default">Terug</a>
                    <?php } ?>
                </div>
            </div>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>