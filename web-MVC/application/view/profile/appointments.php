<h1>Mijn afspraken</h1>
<p>Afspraken waar u voor bent ingeschreven of waar u organisator van bent.</p>
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
        <?php if ($this->appointments) { ?>
            <?php foreach ($this->appointments as $appointment) { ?>
                <tr>
                    <td>
                        <a href="<?= RouteHelper::base_url() ?>appointments/detail/<?= $appointment->appointmentid ?>">
                            <span class="glyphicon glyphicon-eye-open"></span> 
                        </a>
                    </td>
                    <td><?= $appointment->date;?></td>
                    <td><?= $appointment->start;?></td>
                    <td><?= $appointment->end;?></td>
                    <td><?= $appointment->description;?></td>
                    <td><?= $appointment->location;?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="6">Er zijn geen afspraken om te tonen.</td></tr>
        <?php } ?>
    </tbody>
</table>

<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3">
        <?php if (SessionHelper::userdata('accesslevel') >= LECTURER) { ?>
            <p><a href="<?= RouteHelper::base_url() ?>appointments/create" class="btn btn-primary">Nieuwe afspraak</a></p>
        <?php } ?>
    </div>
    <div class="col-lg-9 col-md-9 col-sm-9">
        <form class="form-horizontal" method="post" action="<?= RouteHelper::base_url() ?>profile/appointments" role="form">
            <div class="form-group">
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <form class="form-horizontal" method="post" role="form">
                        <div class="form-group">
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="search" name="search" 
                                       placeholder="Zoek afspraken op beschrijving, organisator, locatie, vakken, start & einddata, studenten, ..."
                                       value="<?=$this->search;?>"/>
                            </div>
                            <div class="col-sm-2">
                                <input type="submit" class="form-control btn btn-primary" value="Zoek" />
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php if (strlen($this->search)) { ?>
            <hr />
            <p>Er werden <strong><?= $this->appointments == FALSE ? 0 : count((array) $this->appointments) ?></strong> afspraken gevonden die voldoen aan uw zoekterm "<?= $this->search ?>".</p>
            <a href="<?= RouteHelper::base_url() ?>profile/appointments" class="btn btn-default">Terug</a>
        <?php } ?>
    </div>
</div>
