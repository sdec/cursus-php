<!DOCTYPE html>
<html>
    <head>
        <title>Afspraak maken - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <h1>Tijdsloten toegevoegd</h1>
            <p>De tijdsloten werden toegevoegd voor de geselecteerde organisator.</p>
            <p><a href="<?= external_url() ?>appointments/detail/<?= $this->data['appointmentid']; ?>" class="btn btn-default">Terug</a></p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>
