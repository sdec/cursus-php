<?php
global $appointmentid;
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Ingeschreven voor afspraak</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <h1>Ingeschreven voor afspraak</h1>
            <p>U bent nu ingeschreven voor de afspraak op het gekozen tijdslot bij de gekozen organisator.</p>
            <p><a href="<?= base_url() ?>appointments/detail/<?= $appointmentid; ?>" class="btn btn-default">Terug</a></p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>