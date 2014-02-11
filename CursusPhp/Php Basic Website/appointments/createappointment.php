<?php
    require_once('../path_helper.php');
    require_once(includes_url() . 'defines.php');
    require_once(includes_url() . 'functions.php');
    require_once(queries_url() . 'DB_appointments.php');
    
    if($_SESSION['user']['accesslevel'] < LECTURER){
        redirect('index.php', 'Je moet het toegangsniveau van minstens een ' . getRole(LECTURER) . ' hebben om deze pagina te bekijken...', "danger");
    }
    $title = "Afspraak maken - Php Basic";
    $messages = initializeMessages(array("date", "start", "end", "description", "location", "chronological"));
    if(isset($_POST['description'])){
         //Check for length of the fields
         //$messages['date'] = checkPostLength('date', "Je gebruikersnaam was te kort/lang! (>= 5 en <= 32)", 5, 32);
         //$messages['start'] = checkPostLength('start', "Je password was te kort/lang! (>= 5 en <= 32)", 5, 32);
         //$messages['end'] = checkPostLength('end', "Je voornaam was te kort/lang! (>= 2 en <= 32)", 2, 32);
         $messages['description'] = checkPostLength('description', "Je beschrijving was te kort/lang! (>= 2 en <= 32)", 2, 32);
         $messages['location'] = checkPostLength('location', "Je locatie was te kort/lang! (>= 3 en <= 32)", 3, 32);
         $chronological = (isset($_POST['chronological'])) ?  true : false;
         $noError = true;
         foreach($messages as $message){
             if($message['status'] != ''){ $noError = false;}
         }
         if($noError){
            DB_Connect();
            $id = createAppointment($_POST['date'].' '.$_POST['start'], $_POST['date'].' '.$_POST['end'], $_POST['description'], $_POST['location'], $_POST['description'], $chronological);
            redirect("appointments/viewappointments.php", "Nieuwe afspraak succesvol aangemaakt met id $id!");
            DB_Close();
         }
    } else { flashmessage("Gelieve het formulier in te vullen", "info"); }
    
    //Pre-set the values for the fields
    if(!isset($_POST['date'])){
        $_POST['date'] = date("o-m-d");
    }
    if(!isset($_POST['start'])){ $_POST['start'] = '08:00'; }
    $_POST['start'] = (isset($_POST['start'])) ?  $_POST['start'] : '08:00';
    $_POST['end'] = (isset($_POST['end'])) ?  $_POST['end'] : '16:00';
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
                <form class="form-horizontal" method="POST">
                    <fieldset>
                        <div class="form-group <?=$messages['date']['status']; ?>">
                            <label for="date" class="col-lg-2 control-label">Datum(*)</label>
                            <div class="col-lg-4">
                                <input type="date" class="form-control" id="date" name="date" 
                                       placeholder="Datum afspraak" maxlength="32" value="<?= $_POST['date']; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"><?=$messages['date']['message']; ?></span>
                            </div>
                        </div>
                        <div class="form-group <?=$messages['start']['status']; ?>">
                            <label for="start" class="col-lg-2 control-label">Startuur(*)</label>
                            <div class="col-lg-4">
                                <input type="time" class="form-control" id="start" name="start" 
                                       placeholder="Startuur afspraak" maxlength="32" value="<?= $_POST['start']; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"><?=$messages['start']['message']; ?></span>
                            </div>
                        </div>
                        <div class="form-group <?=$messages['end']['status']; ?>">
                            <label for="end" class="col-lg-2 control-label">Einduur(*)</label>
                            <div class="col-lg-4">
                                <input type="time" class="form-control" id="end" name="end" 
                                       placeholder="Einduur afspraak" maxlength="32" value="<?= $_POST['end']; ?>" required>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"><?=$messages['end']['message']; ?></span>
                            </div>
                        </div>
                        <div class="form-group" <?=$messages['description']['status']; ?>>
                            <label for="description" class="col-lg-2 control-label">Beschrijving(*)</label>
                            <div class="col-lg-4">
                                <textarea class="form-control" id="description" name="description" 
                                          placeholder="Beschrijving afspraak" maxlength="128" required><?=@$_POST['description']?></textarea>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"><?=$messages['description']['message']; ?></span>
                            </div>
                        </div>
                        <div class="form-group <?=$messages['location']['status']; ?>">
                            <label for="location" class="col-lg-2 control-label">Locatie(*)</label>
                            <div class="col-lg-4">
                                <input type="text" class="form-control" id="location" name="location" 
                                       placeholder="Lokaal 001" maxlength="32" value="<?=@$_POST['location']?>" required></textarea>
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"><?=$messages['location']['message']; ?></span>
                            </div>
                        </div>
                        <div class="form-group <?=$messages['chronological']['status']; ?>">
                            <div class="col-lg-6 col-lg-offset-2">
                                <input type="checkbox" id="chronological" name="chronological" 
                                       <?php if (isset($_POST['chronological'])):?>
                                        <?='checked="true"'?>
                                       <?php endif; ?>>
                                Verplicht inschrijvingen in chronologische volgorde
                            </div>
                            <div class="col-lg-6">
                                <span class="text-danger"><?=$messages['chronological']['message']; ?></span>
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
        </div>
    </body>
</html>