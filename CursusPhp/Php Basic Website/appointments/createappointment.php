<?php
    include_once('../path_helper.php');
    include_once(includes_url() . 'defines.php');
    include_once(includes_url() . 'functions.php');
    
    if($_SESSION['user']['accesslevel'] < LECTURER){
        redirect('index.php', 'Je moet het toegangsniveau van minstens een ' . getRole(LECTURER) . ' hebben om deze pagina te bekijken...', "danger");
    }
    $title = "Afspraak maken - Php Basic";
?>
<?php include_once(partials_url() . 'header.php'); ?>
        <!-- jQuery datum & tijd picker -->
        <link rel="stylesheet" type="text/css" href="<?= assets_url(); ?>css/jquery.datetimepicker.css" />
    </head>
    <body>
        <?php include_once(partials_url() . 'navbar.php'); ?>
        <div class="container"> <!-- page main-content -->
            <h1>Afspraak aanmaken</h1>
            <p>Vul onderstaande gegevens in om een afspraakmoment te voorzien.</p>

            <div class="well">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="date" class="col-lg-2 control-label">Datum</label>
                            <div class="col-lg-4">
                                <input type="date" class="form-control" id="date" name="date" 
                                       placeholder="Datum afspraak" maxlength="32" value="<?= date("o-m-d") ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="start" class="col-lg-2 control-label">Startuur</label>
                            <div class="col-lg-4">
                                <input type="time" class="form-control" id="start" name="start" 
                                       placeholder="Startuur afspraak" maxlength="32" value="08:00" required>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="end" class="col-lg-2 control-label">Einduur</label>
                            <div class="col-lg-4">
                                <input type="time" class="form-control" id="end" name="end" 
                                       placeholder="Einduur afspraak" maxlength="32" value="16:00" required>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="description" class="col-lg-2 control-label">Beschrijving</label>
                            <div class="col-lg-4">
                                <textarea class="form-control" id="description" name="description" 
                                          placeholder="Beschrijving afspraak" maxlength="128" required></textarea>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="location" class="col-lg-2 control-label">Locatie</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="location" name="location" 
                                       placeholder="Lokaal 001" maxlength="32" value="" required></textarea>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"> </span>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Maak afspraak</button> 
                                <a href="<?= base_url(); ?>appointments/viewappointments.php" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php include_once(partials_url() .'footer.php'); ?>
        <!-- Configuratie van de datetimepicker -->
        <script src="<?= assets_url(); ?>js/jquery.datetimepicker.js"></script>
        <script type="text/javascript">
            var allowedTimes = [];
            for(var i = 8; i <= 17; i++) {
                for(var j = 0; j <= 50; j += 10) {
                    allowedTimes.push(('0' + i).slice(-2) + ':' + ('0' + j).slice(-2));
                }
            }
            $('#inputDateTime').datetimepicker({
                lang: 'nl',
                allowTimes: allowedTimes,
                format: 'd/m/Y H:i'
            });
        </script>