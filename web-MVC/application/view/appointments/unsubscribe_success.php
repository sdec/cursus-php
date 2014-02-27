<?php
global $appointmentid;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Uitgeschreven voor afspraak</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <h1>Uitgeschreven voor afspraak</h1>
            <p>U bent nu uitgeschreven voor de afspraak.</p>
            <p><a href="<?= base_url() ?>appointments/detail/<?= $appointmentid; ?>" class="btn btn-default">Terug</a></p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>