<h1>Tijdsloten toevoegen</h1>
<div class="well">
    <form method="POST" role="form" class="form-horizontal">
        <div class="form-group">
            <label for="lecturerid" class="col-lg-2 control-label">Organisator</label>
            <div class="col-lg-4">
                <select class="form-control" id="lecturerid" name="lecturerid" required>
                    <?php foreach ($this->data['lecturers'] as $lecturer) { ?>
                        <option value="<?= $lecturer['userid']; ?>">
                            <?= $lecturer['firstname']; ?> <?= $lecturer['lastname']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
        </div>
        <div class="form-group">
            <label for="start" class="col-lg-2 control-label">Startuur</label>
            <div class="col-lg-4">
                <input type="time" class="form-control" id="start" name="start" 
                       placeholder="Startuur tijdsloten" maxlength="5" value="<?= set_value('start'); ?>" required>
            </div>
            <div class="col-lg-6">
                <?= form_error('start', '<span class="text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="end" class="col-lg-2 control-label">Einduur</label>
            <div class="col-lg-4">
                <input type="time" class="form-control" id="end" name="end" 
                       placeholder="Einduur tijdsloten" maxlength="5" value="<?= set_value('end'); ?>" required>
            </div>
            <div class="col-lg-6">
                <?= form_error('end', '<span class="text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="interval" class="col-lg-2 control-label">Lengte tijdsloten</label>
            <div class="col-lg-4">
                <input type="time" class="form-control" id="interval" name="interval" 
                       placeholder="Lengte tijdsloten (bv 15 minuten)" maxlength="5" value="<?= set_value('interval'); ?>" required>
            </div>
            <div class="col-lg-6">
                <?= form_error('interval', '<span class="text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" name="submit" class="btn btn-primary">Voeg tijdsloten toe</button> 
                <a href="<?= base_url() ?>appointments/detail/<?= $this->data['appointment']['appointmentid']; ?>" class="btn btn-default">Annuleer</a>
            </div>
        </div>
    </form>
</div>