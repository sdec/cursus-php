<h1>Registreren</h1>
<div class="well">
    <form method="POST" role="form" class="form-horizontal">
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
                <label for="firstname" class="col-lg-2 control-label">Voornaam</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="firstname" name="firstname" 
                           placeholder="Voornaam" maxlength="32" value="<?= set_value('firstname'); ?>" required>
                </div>
                <div class="col-lg-6">
                    <?= form_error('firstname', '<span class="text-danger">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="lastname" class="col-lg-2 control-label">Familienaam</label>
                <div class="col-lg-4">
                    <input type="text" class="form-control" id="lastname" name="lastname" 
                           placeholder="Familienaam" maxlength="32" value="<?= set_value('lastname'); ?>" required>
                </div>
                <div class="col-lg-6">
                    <?= form_error('lastname', '<span class="text-danger">', '</span>'); ?>
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
                <label for="passwordConfirm" class="col-lg-2 control-label">Herhaal paswoord</label>
                <div class="col-lg-4">
                    <input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" 
                           placeholder="Herhaal paswoord" maxlength="128" value="<?= set_value('passwordConfirm'); ?>" required>
                </div>
                <div class="col-lg-6">
                    <?= form_error('passwordConfirm', '<span class="text-danger">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group">
                <label for="email" class="col-lg-2 control-label">Email adres</label>
                <div class="col-lg-4">
                    <input type="email" class="form-control" id="email" name="email" 
                           placeholder="Email adres" maxlength="128" value="<?= set_value('email'); ?>" required>
                </div>
                <div class="col-lg-6">
                    <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
                </div>
            </div>
            <div class="form-group">
                <div class="col-lg-10 col-lg-offset-2">
                    <button type="submit" name="submit" class="btn btn-primary">Registreren</button> 
                </div>
            </div>
        </fieldset>
    </form>
</div>