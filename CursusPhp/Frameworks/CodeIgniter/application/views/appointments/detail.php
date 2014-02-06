<h1>Bekijk afspraak</h1>

<p>Algemene informatie</p>
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
</table>

<hr />
<p>Beschikbare lectoren & studieadviseurs voor deze afspraak</p>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <td>Naam</td>
            <td>Startuur</td>
            <td>Einduur</td>
            <td>Lengte tijdslot</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php if (count($lecturers) > 0) { ?>
            <?php foreach ($lecturers as $lecturer) { ?>
                <tr>
                    <td><?= $lecturer->firstname ?> <?= $lecturer->lastname ?></td>
                    <td><?= $lecturer->start ?></td>
                    <td><?= $lecturer->end ?></td>
                    <td><?= $lecturer->interval ?></td>
                    <td>
                        <a href="<?= base_url() ?>appointments/subscribe/<?= $appointment->appointmentid ?>/<?= $lecturer->lecturerid ?>">
                            <span class="glyphicon glyphicon-edit"></span> Inschrijven
                        </a> 
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

<?php if ($this->session->userdata('user')->accesslevel >= LECTURER) { ?>
    <p>
        <a href="<?= base_url() ?>appointments/edit/<?= $appointment->appointmentid ?>" class="btn btn-primary">Wijzig afspraak</a> 
        <a href="<?= base_url() ?>appointments/delete/<?= $appointment->appointmentid ?>" class="btn btn-danger">Verwijder afspraak</a>
    </p>
<?php } ?>