
<h1>Gebruikers</h1>
<table class="table table-hover table-striped">
    <thead>
        <tr>
            <td></td>
            <td>Voornaam</td>
            <td>Familienaam</td>
            <td>Gebruikersnaam</td>
            <td>Email</td>
            <td>Type profiel</td>
        </tr>
    </thead>
    <tbody>
        <?php if ($this->users != FALSE) { ?>
            <?php foreach ($this->users as $user) { ?>
                <tr>
                    <td><a href="<?= base_url() ?>profile/view/<?= $user->username ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <td><?= ucfirst($user->firstname) ?></td>
                    <td><?= ucfirst($user->lastname) ?></td>
                    <td><?= $user->username ?></td>
                    <td><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></td>
                    <td><?= $user->accesslevelname ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="6">Er zijn momenteel geen afspraken beschikbaar.</td></tr>
        <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <form class="form-horizontal" method="POST" role="form">
            <div class="form-group">
                <div class="col-sm-8 col-sm-offset-2">
                    <input type="text" class="form-control" id="search" name="search" 
                           placeholder="Zoek gebruikers op voornaam, familienaam, gebruikersnaam of email" />
                </div>
                <div class="col-sm-2">
                    <input type="submit" class="form-control btn btn-primary" value="Zoek" />
                </div>
            </div>
        </form>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <?php if (strlen($this->search)) { ?>
            <hr />
            <p>Er werden <strong><?= $this->users == FALSE ? 0 : count((array) $this->users) ?></strong> gebruikers gevonden die voldoen aan uw zoekterm "<?= $this->search ?>".</p>
            <a href="<?= base_url() ?>admin/users" class="btn btn-default">Terug</a>
        <?php } ?>
    </div>
</div>