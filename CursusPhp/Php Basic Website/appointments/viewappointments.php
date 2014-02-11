<?php
    require_once('../path_helper.php');
    require_once(includes_url() . 'defines.php');
    require_once(includes_url() . 'functions.php');
    require_once(queries_url() . 'DB_appointments.php');
    
    $title = "Php Basic - View appointments";
    
    DB_Connect();
    $appointments = loadall();
    $search = (isset($_POST['search'])) ? search($_POST['search']) : false;
    DB_Close();
?>
        <?php include_once(partials_url() . 'header.php'); ?>>
    </head>
    <body>
        <?php include_once(partials_url() . 'navbar.php'); ?>
        <div class="container"> <!-- page main-content -->
            <h1>Afspraken</h1>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td></td>
                        <td>Datum</td>
                        <td>Startuur</td>
                        <td>Einduur</td>
                        <td>Beschrijving</td>
                        <td>Locatie</td>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($appointments) { ?>
                        <?php foreach ($appointments as $appointment) { ?>
                            <tr>
                                <td>
                                    <a href="<?= base_url() ?>appointments/detail.php?id=<?= $appointment['appointmentid'] ?>">
                                        <span class="glyphicon glyphicon-eye-open"></span> 
                                    </a>
                                </td>
                                <td><?= $appointment['date'] ?></td>
                                <td><?= $appointment['start'] ?></td>
                                <td><?= $appointment['end'] ?></td>
                                <td><?= $appointment['description'] ?></td>
                                <td><?= $appointment['location'] ?></td>
                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr><td colspan="6">Er zijn geen afspraken om te tonen.</td></tr>
                    <?php } ?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-lg-3 col-md-3 col-sm-3">
                    <?php if ($_SESSION['user']['accesslevel'] >= LECTURER) { ?>
                        <p><a href="<?= base_url() ?>appointments/create.php" class="btn btn-primary">Nieuwe afspraak</a></p>
                    <?php } ?>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <form class="form-horizontal" method="get" action="<?= base_url() ?>appointments" role="form">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Zoek afspraken op beschrijving, organisator, locatie, vakken, start & einddata, studenten, ..." />
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
                        <p>Er werden <strong><?= $appointments == FALSE ? 0 : count((array) $appointments) ?></strong> afspraken gevonden die voldoen aan uw zoekterm "<?= $search ?>".</p>
                        <a href="<?= base_url() ?>appointments" class="btn btn-default">Terug</a>
                    <?php } ?>
                </div>
            </div>
        <?php include_once(partials_url() .'footer.php'); ?>
        </div>
    </body>
</html>
            