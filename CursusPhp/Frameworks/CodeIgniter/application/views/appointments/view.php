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
        <?php if (count($appointments) > 0) { ?>
            <?php foreach ($appointments as $appointment) { ?>
                <tr>
                    <td><?= $appointment->date ?></td>
                    <td><?= $appointment->start ?></td>
                    <td><?= $appointment->end ?></td>
                    <td><?= $appointment->description ?></td>
                    <td><?= $appointment->location ?></td>
                    <td><a href="<?= base_url() ?>appointments/detail/<?= $appointment->appointmentid ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="6">Er zijn momenteel geen afspraken beschikbaar.</td></tr>
        <?php } ?>
    </tbody>
</table>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?php if ($this->session->userdata('user')->accesslevel >= LECTURER) { ?>
            <p><a href="<?= base_url() ?>appointments/create" class="btn btn-primary">Nieuwe afspraak</a></p>
        <?php } ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <form class="form-horizontal" method="get" action="<?= base_url() ?>appointments/index" role="form">
            <div class="form-group">
                <div class="col-sm-10">
                    <input type="email" class="form-control" id="inputEmail3" placeholder="Zoek afspraken op omschrijving, organisator, locatie, vakken, ..." />
                </div>
                <div class="col-sm-2">
                    <input type="submit" class="form-control btn btn-primary" placeholder="Email" value="Zoek" />
                </div>
            </div>
        </form>
    </div>
</div>