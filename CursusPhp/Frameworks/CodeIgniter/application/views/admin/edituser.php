<h1>Wijzig gebruiker</h1>
<div class="well">
    <form method="POST" action="<?= base_url() ?>admin/edituser/<?= $user->username ?>" role="form" class="form-horizontal">
        <div class="form-group">
            <label for="username" class="col-lg-2 control-label">Gebruikersnaam</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="username" name="username" 
                       placeholder="Gebruikersnaam" maxlength="32" value="<?= set_value('username', $user->username); ?>" required>
            </div>
            <div class="col-lg-6">
                <?= form_error('username', '<span class="text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="firstname" class="col-lg-2 control-label">Voornaam</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="firstname" name="firstname" 
                       placeholder="Voornaam" maxlength="32" value="<?= set_value('firstname', $user->firstname); ?>" required>
            </div>
            <div class="col-lg-6">
                <?= form_error('firstname', '<span class="text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="lastname" class="col-lg-2 control-label">Familienaam</label>
            <div class="col-lg-4">
                <input type="text" class="form-control" id="lastname" name="lastname" 
                       placeholder="Familienaam" maxlength="32" value="<?= set_value('lastname', $user->lastname); ?>" required>
            </div>
            <div class="col-lg-6">
                <?= form_error('lastname', '<span class="text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="form-group">
            <label for="email" class="col-lg-2 control-label">Email adres</label>
            <div class="col-lg-4">
                <input type="email" class="form-control" id="email" name="email" 
                       placeholder="Email adres" maxlength="128" value="<?= set_value('email', $user->email); ?>" required>
            </div>
            <div class="col-lg-6">
                <?= form_error('email', '<span class="text-danger">', '</span>'); ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-lg-10 col-lg-offset-2">
                <button type="submit" class="btn btn-primary">Wijzig gebruiker</button> 
                <a href="<?= base_url() ?>profile/view/<?= $user->username ?>" class="btn btn-default">Annuleer</a>
            </div>
        </div>
    </form>
</div>