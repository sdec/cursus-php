
<div class="row">
    <div class="col-lg-6">
        <h3>Wijzig afspraakdetails</h3>
        <div class="well">
            <form method="POST" role="form" class="form-horizontal">
                <div class="form-group">
                    <label for="date" class="col-lg-2 control-label">Datum</label>
                    <div class="col-lg-10">
                        <input type="date" class="form-control" id="date" name="date" 
                               placeholder="Datum afspraak" maxlength="32" value="<?= set_value('date'); ?>" required>
                    </div>
                    <div class="col-lg-6">
                        <?= form_error('date', '<span class="text-danger">', '</span>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="start" class="col-lg-2 control-label">Startuur</label>
                    <div class="col-lg-10">
                        <input type="time" class="form-control" id="start" name="start" 
                               placeholder="Startuur afspraak" maxlength="32" value="<?= set_value('start'); ?>" required>
                    </div>
                    <div class="col-lg-6">
                        <?= form_error('start', '<span class="text-danger">', '</span>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="end" class="col-lg-2 control-label">Einduur</label>
                    <div class="col-lg-10">
                        <input type="time" class="form-control" id="end" name="end" 
                               placeholder="Einduur afspraak" maxlength="32" value="<?= set_value('end'); ?>" required>
                    </div>
                    <div class="col-lg-6">
                        <?= form_error('end', '<span class="text-danger">', '</span>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="description" class="col-lg-2 control-label">Beschrijving</label>
                    <div class="col-lg-10">
                        <textarea class="form-control" id="description" name="description" 
                                  placeholder="Beschrijving afspraak" maxlength="128" required><?= set_value('description'); ?></textarea>
                    </div>
                    <div class="col-lg-6">
                        <?= form_error('description', '<span class="text-danger">', '</span>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <label for="location" class="col-lg-2 control-label">Locatie</label>
                    <div class="col-lg-10">
                        <input type="text" class="form-control" id="location" name="location" 
                               placeholder="Locatie afspraak" maxlength="32" value="<?= set_value('location'); ?>" required />
                    </div>
                    <div class="col-lg-6">
                        <?= form_error('location', '<span class="text-danger">', '</span>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <input type="checkbox" id="chronological" name="chronological" <?= $this->appointment->chronological ? 'checked="checked"' : '' ?>>
                        Verplicht inschrijvingen in chronologische volgorde
                    </div>
                    <div class="col-lg-6">
                        <?= form_error('chronological', '<span class="text-danger">', '</span>'); ?>
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-lg-10 col-lg-offset-2">
                        <button type="submit" name="submit" class="btn btn-primary">Wijzig afspraak</button> 
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="col-lg-6">
        <h3>Wijzig tijdsloten</h3>
        <?php if ($this->slots) { ?>
            <table class="table table-hover table-striped">
                <thead>
                    <tr>
                        <td><span class="glyphicon glyphicon-user"></span> Organisator</td>
                        <td><span class="glyphicon glyphicon-time"></span> Start/Einduur</td>
                        <td>Ingeschreven</td>
                        <td></td>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($this->slots as $slot) { ?>
                        <tr>
                            <td><?= $slot->lecturer ?></td>
                            <td><?= $slot->start ?> - <?= $slot->end ?></td>
                            <td><?= $slot->subscriber ?></td>
                            <td>
                                <a href="<?= base_url() ?>appointments/deletetimeslot/<?= $this->appointment->appointmentid ?>/<?= $slot->appointmentslotid ?>">
                                    <span class="glyphicon glyphicon-remove-sign"></span> Verwijder
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <p>Er werden nog geen tijdsloten toegewezen aan deze afspraak.</p>
        <?php } ?>
    </div>
</div>
<p><a href="<?= base_url() ?>appointments/detail/<?= $this->appointment->appointmentid ?>" class="btn btn-default">Terug</a></p>
