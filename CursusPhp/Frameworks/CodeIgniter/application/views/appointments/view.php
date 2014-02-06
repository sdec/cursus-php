<h1>Afspraken</h1>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <td>Datum</td>
            <td>Startuur</td>
            <td>Einduur</td>
            <td>Beschrijving</td>
            <td>Locatie</td>
            <td></td>
        </tr>
    </thead>
    <tbody>
        <?php if(count($appointments) > 0) { ?>
            <?php foreach($appointments as $appointment) { ?>
                <tr>
                    <td><?= $appointment->date ?></td>
                    <td><?= $appointment->start ?></td>
                    <td><?= $appointment->end ?></td>
                    <td><?= $appointment->description ?></td>
                    <td><?= $appointment->location ?></td>
                    <td><a href="<?= base_url() ?>appointments/detail/<?= $appointment->appointmentid ?>"><span class="glyphicon glyphicon-open"></span></a></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="6">Er zijn momenteel geen afspraken beschikbaar.</td></tr>
        <?php } ?>
    </tbody>
</table>