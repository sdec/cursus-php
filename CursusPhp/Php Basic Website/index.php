<?php
//page config settings
$projectdir = "./";
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Basic Phpsite - Home</title>
        <?php include_once('../Php Basic Website/partials/navbar.php'); ?>
            <div class="jumbotron">
                <h1>Afsprakenplanner - BASIC</h1>
                <p class="lead">
                    Deze website is de Php BASIC versie van de afsprakenplanner die jullie doorheen de cursus zullen herbouwen/uitbreiden tot een OO-design.
                </p>
                <p>
                    <a href="appointments/viewappointments.php" class="btn btn-primary"><span class="glyphicon glyphicon-list"></span> Mijn afspraken</a> 
                    <a href="appointments/createappointment.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Maak een afspraak</a>
                </p>
            </div>
        <?php include_once('../Php Basic Website/partials/footer.php'); ?>