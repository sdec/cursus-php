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
                        <?php if ($slots) { ?>
                            <?php foreach ($slots as $slot) { ?>
                                <tr>
                                    <td><?= $slot->firstname ?> <?= $slot->lastname ?></td>
                                    <td><?= $slot->start ?> - <?= $slot->end ?></td>
                                    <td>
                                        <?php if ($slot->available == TRUE) { ?>
                                            <a class="text-success" href="<?= base_url() ?>appointments/subscribe/<?= $appointment->appointmentid ?>/<?= $slot->appointmentslotid ?>">
                                                <span class="glyphicon glyphicon-ok-sign"></span> Inschrijven
                                            </a>
                                        <?php } else { ?>
                                            <span class="glyphicon glyphicon-remove-sign text-danger"></span> 
                                            <?php if ($slot->subscriberid == $this->session->userdata('user')->userid) { ?>
                                                <strong><?= $slot->subscriber ?></strong>
                                            <?php } else { ?>
                                                <?= $slot->subscriber ?>
                                            <?php } ?>
                                        <?php } ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr>
                                <td colspan="5">Er werden nog geen personeelsleden toegewezen aan deze afspraak. Een tijdslot reserveren is nog niet mogelijk.</td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="panel-title">Mijn inschrijving</div>
            </div>
            <?php if ($appointment->subscribed) { ?>
                <div class="panel-body alert-success">
                    U bent ingeschreven voor een afspraak bij <strong><?= $appointment->lecturer ?></strong> om <strong><?= $appointment->subscribestart ?></strong>.  
                    Deze afspraak duurt ongeveer tot <strong><?= $appointment->subscribeend ?></strong>.
            <?php } else { ?>
                <div class="panel-body">
                    U bent niet ingeschreven voor deze afspraak. Kies een beschikbaar tijdslot bij de organisator van keuze om u in te schrijven.
            <?php } ?>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?php if ($this->session->userdata('user')->accesslevel >= LECTURER) { ?>
            <p>
                <a href="<?= base_url() ?>appointments/edit/<?= $appointment->appointmentid ?>" class="btn btn-primary">Wijzig afspraak</a> 
                <a href="<?= base_url() ?>appointments/delete/<?= $appointment->appointmentid ?>" class="btn btn-danger">Verwijder afspraak</a>
            </p>
        <?php } ?>
    </div>
</div>

