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
                        <td><?= $appointment->date ?></td>
                    </tr>
                    <tr>
                        <td>Startuur</td>
                        <td><?= $appointment->start ?></td>
                    </tr>
                    <tr>
                        <td>Einduur</td>
                        <td><?= $appointment->end ?></td>
                    </tr>
                    <tr>
                        <td>Beschrijving</td>
                        <td><?= $appointment->description ?></td>
                    </tr>
                    <tr>
                        <td>Locatie</td>
                        <td><?= $appointment->location ?></td>
                    </tr>
                    <tr>
                        <td>Organisatoren</td>
                        <td><?= $appointment->lecturercount ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-6 col-md-6 col-sm-6">
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Inschrijvingen</div>
            </div>
            <div class="panel-body">
                <?php if ($slots) { ?>
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

                            <?php foreach ($slots as $slot) { ?>
                                <tr>
                                    <td><?= $slot->lecturer ?></td>
                                    <td><?= $slot->start ?> - <?= $slot->end ?></td>
                                    <td>
                                        <?php if (!$slot->subscriberid) { ?>
                                            <?php if ($appointment->started == FALSE && $subscribtion['subscribed'] == FALSE) { ?>
                                                <a class="text-success" href="<?= base_url() ?>appointments/subscribe/<?= $appointment->appointmentid ?>/<?= $slot->appointmentslotid ?>">
                                                    <span class="glyphicon glyphicon-ok-sign"></span> Beschikbaar
                                                </a>
                                            <?php } else { ?>
                                                <span class="glyphicon glyphicon-ok-sign"></span> Beschikbaar
                                            <?php } ?>
                                        <?php } else { ?>
                                            <?php if ($slot->subscriberid == $this->session->userdata('user')->userid) { ?>
                                                <span class="text-success">
                                                    <span class="glyphicon glyphicon-ok-sign"></span> Ingeschreven
                                                </span>
                                            <?php } else { ?>
                                                <span class="glyphicon glyphicon-remove-sign text-danger"></span> 
                                                    <?= $slot->subscriber ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <p>Er werden nog geen organisatoren toegewezen aan deze afspraak. Een tijdslot reserveren is momenteel niet mogelijk.</p>
                <?php } ?>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Mijn inschrijving</div>
            </div>
            <div class="panel-body">
                <?php if ($subscribtion['subscribed']) { ?>

                    <p>U bent ingeschreven voor een afspraak bij <strong><?= $subscribtion['lecturer'] ?></strong> om <strong><?= $subscribtion['subscribestart'] ?></strong>.  
                        Deze afspraak duurt ongeveer tot <strong><?= $subscribtion['subscribeend'] ?></strong>.</p>
                    <p>
                        <a href="<?= base_url() ?>appointments/unsubscribe/<?= $appointment->appointmentid ?>/<?= $subscribtion['subscribeslotid'] ?>" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-remove-sign"></span> Uitschrijven
                        </a>
                    </p>
                <?php } else { ?>
                    <p>U bent niet ingeschreven voor deze afspraak. Kies een beschikbaar tijdslot bij de organisator van keuze om u in te schrijven.</p>
                <?php } ?>
                <?php if ($appointment->started) { ?>
                    <div class="alert alert-info">
                        <?php if ($appointment->ended) { ?>
                            Deze afspraak is verlopen. 
                        <?php } else { ?>
                            Deze afspraak is al begonnen. 
                        <?php } ?>
                        Inschrijvingen zijn niet meer mogelijk.
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?php if ($this->session->userdata('user')->accesslevel >= LECTURER) { ?>
            <p>
                <a href="<?= base_url() ?>appointments/addlecturer" class="btn btn-primary">
                    <span class="glyphicon glyphicon-plus-sign"></span> 
                    Voeg organisator toe
                </a> 
                <a href="<?= base_url() ?>appointments/edit/<?= $appointment->appointmentid ?>" class="btn btn-primary">
                    <span class="glyphicon glyphicon-edit"></span> 
                    Wijzig afspraak
                </a> 
                <a href="<?= base_url() ?>appointments/delete/<?= $appointment->appointmentid ?>" class="btn btn-danger">
                    <span class="glyphicon glyphicon-remove-sign"></span> 
                    Verwijder afspraak
                </a>
            </p>
        <?php } ?>
    </div>
</div>

