<!DOCTYPE html>
<html>
    <head>
        <title>Afspraak bekijken - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Informatie</div>
                        </div>
                        <div class="panel-body">
                            <p>Algemene informatie over deze afspraak.</p>
                            <table class="table table-hover table-striped table-vertical">
                                <tr>
                                    <td>Startdatum</td>
                                    <td><?= $this->data['appointment']['date'] ?></td>
                                </tr>
                                <tr>
                                    <td>Startuur</td>
                                    <td><?= $this->data['appointment']['start'] ?></td>
                                </tr>
                                <tr>
                                    <td>Einduur</td>
                                    <td><?= $this->data['appointment']['end'] ?></td>
                                </tr>
                                <tr>
                                    <td>Beschrijving</td>
                                    <td><?= $this->data['appointment']['description'] ?></td>
                                </tr>
                                <tr>
                                    <td>Locatie</td>
                                    <td><?= $this->data['appointment']['location'] ?></td>
                                </tr>
                                <tr>
                                    <td>Organisatoren</td>
                                    <td><?= $this->data['appointment']['lecturercount'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Mijn inschrijving</div>
                        </div>
                        <div class="panel-body">
                            <?php if ($this->data['subscription']['subscribed']) { ?>
                                <?php if ($this->data['subscription']['lecturerid'] == userdata('userid')) { ?>
                                    <p>
                                        U heeft aangegeven pauze te nemen van <strong><?= $this->data['subscription']['subscribestart'] ?></strong> 
                                        tot ongeveer <strong><?= $this->data['subscription']['subscribeend'] ?></strong>.
                                    </p>
                                <?php } else { ?>
                                    <p>U bent ingeschreven voor een afspraak bij <strong><?= $this->data['subscription']['lecturer'] ?></strong> om <strong><?= $data['subscription']['subscribestart'] ?></strong>.  
                                        Deze afspraak duurt ongeveer tot <strong><?= $this->data['subscription']['subscribeend'] ?></strong>.</p>
                                <?php } ?>
                                <?php if(!$this->data['appointment']['started']) { ?>
                                <p>
                                    <a href="<?= external_url() ?>appointments/unsubscribe/<?= $this->data['appointment']['appointmentid'] ?>/<?= $data['subscription']['subscribeslotid'] ?>" class="btn btn-default btn-sm">
                                        <span class="glyphicon glyphicon-remove-sign"></span> Uitschrijven
                                    </a>
                                </p>
                                <?php } ?>
                            <?php } else { ?>
                                <p>U bent niet ingeschreven voor deze afspraak. Kies een beschikbaar tijdslot bij de organisator van keuze om u in te schrijven.</p>
                            <?php } ?>
                            <?php if ($this->data['appointment']['started']) { ?>
                                <div class="alert alert-info">
                                    <?php if ($this->data['appointment']['ended']) { ?>
                                        Deze afspraak is verlopen. 
                                    <?php } else { ?>
                                        Deze afspraak is al begonnen. 
                                    <?php } ?>
                                    Inschrijvingen zijn niet meer mogelijk.
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <?php if (userdata('accesslevel') >= LECTURER) { ?>
                        <p>
                            <a href="<?= external_url() ?>appointments/addtimeslots/<?= $this->data['appointment']['appointmentid'] ?>" class="btn btn-primary">
                                <span class="glyphicon glyphicon-plus-sign"></span> 
                                Voeg tijdsloten toe
                            </a> 
                            <a href="<?= external_url() ?>appointments/edit/<?= $this->data['appointment']['appointmentid'] ?>" class="btn btn-primary">
                                <span class="glyphicon glyphicon-edit"></span> 
                                Wijzig afspraak
                            </a> 
                            <a href="<?= external_url() ?>appointments/delete/<?= $this->data['appointment']['appointmentid'] ?>" class="btn btn-danger">
                                <span class="glyphicon glyphicon-remove-sign"></span> 
                                Verwijder afspraak
                            </a>
                        </p>
                    <?php } ?>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="panel-title">Inschrijvingen</div>
                        </div>
                        <div class="panel-body">
                            <?php if ($this->data['slots']) { ?>
                                <p>Selecteer een beschikbaar tijdslot om u in te schrijven.</p>
                                <table class="table table-hover table-striped">
                                    <thead>
                                        <tr>
                                            <td><span class="glyphicon glyphicon-user"></span> Organisator</td>
                                            <td><span class="glyphicon glyphicon-time"></span> Start/Einduur</td>
                                            <td>Beschikbaarheid</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $slotIndex = 0; ?>
                                        <?php foreach ($this->data['slots'] as $slot) { ?>
                                            <tr>
                                                <td><?= $slot['lecturer'] ?></td>
                                                <td><?= $slot['start'] ?> - <?= $slot['end'] ?></td>
                                                <td>
                                                    <?php if (!$slot['subscriberid']) { ?>
                                                        <?php if ($this->data['appointment']['started'] == FALSE && $this->data['subscription']['subscribed'] == FALSE) { ?>
                                                            <?php if (isset($slot['available']) && $slot['available'] == TRUE || $slot['lecturerid'] == userdata('userid')) { ?>
                                                                <a class="text-success" href="<?= external_url() ?>appointments/subscribe/
                                                                    <?= $this->data['appointment']['appointmentid'] ?>/<?= $slot['appointmentslotid'] ?>">
                                                                    <span class="glyphicon glyphicon-ok-sign"></span> Beschikbaar
                                                                </a>
                                                            <?php } else { ?>
                                                                <span class="glyphicon glyphicon-remove-sign"></span> Niet beschikbaar
                                                            <?php } ?>
                                                        <?php } ?>
                                                    <?php } else { ?>
                                                        <?php if ($slot['subscriberid'] == $slot['lecturerid']) { ?>
                                                            <span class="text-info">
                                                                <span class="glyphicon glyphicon-pause"></span> Pauze
                                                            </span>
                                                        <?php } else if ($slot['subscriberid'] == userdata('userid')) { ?>
                                                            <span class="text-success">
                                                                <span class="glyphicon glyphicon-ok-sign"></span> Ingeschreven
                                                            </span>
                                                        <?php } else { ?>
                                                            <span class="glyphicon glyphicon-remove-sign text-danger"></span> 
                                                            <?= $slot['subscriber'] ?>
                                                        <?php } ?>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php $slotIndex++; ?>
                                        <?php } ?>
                                    </tbody>
                                </table>
                            <?php } else { ?>
                                <p>Er werden nog geen tijdsloten toegewezen aan deze afspraak. Een tijdslot reserveren is momenteel niet mogelijk.</p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>