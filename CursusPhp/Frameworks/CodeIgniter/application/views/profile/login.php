<h1>Log in</h1>
<div class="well">
    <form method="POST" action="<?= base_url() ?>profile/login" role="form" class="form-horizontal">
        <fieldset>
            <div class="form-group">
                <label for="username" class="col-lg-2 control-label">Gebruikersnaam</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="username" name="username" 
                           placeholder="Gebruikersnaam" maxlength="32" value="<?= set_value('username'); ?>" required>
                </div>
                <div class="col-lg-6">
                    <?= form_error('username', '<span class="text-danger">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="password" class="col-lg-2 control-label">Paswoord</label>
                <div class="col-lg-4">
                    <input type="password" class="form-control" id="password" name="password" 
                           placeholder="Paswoord" maxlength="128" value="<?= set_value('password'); ?>" required>
                </div>
                <div class="col-lg-6">
                    <?= form_error('password', '<span class="text-danger">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" class="btn btn-primary">Log in</button> 
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                
                </div>
            </div>
        </fieldset>
    </form>
</div>