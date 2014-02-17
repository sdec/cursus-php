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
        <?php if($users != FALSE) { ?>
            <?php foreach($users as $user) { ?>
                <tr>
                    <td><a href="<?= base_url() ?>profile/view/<?= $user->username ?>"><span class="glyphicon glyphicon-eye-open"></span></a></td>
                    <td><?= ucfirst($user->firstname) ?></td>
                    <td><?= ucfirst($user->lastname) ?></td>
                    <td><?= $user->username ?></td>
                    <td><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></td>
                    <td><?= $this->UserModel->accessLevelName($user->accesslevel) ?></td>
                </tr>
            <?php } ?>
        <?php } else { ?>
            <tr><td colspan="6">Er zijn momenteel geen afspraken beschikbaar.</td></tr>
        <?php } ?>
    </tbody>
</table>
<div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12">
        <form class="form-horizontal" method="get" action="<?= base_url() ?>admin/users" role="form">
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
        <?php if (strlen($search)) { ?>
            <hr />
            <p>Er werden <strong><?= $users == FALSE ? 0 : count((array) $users) ?></strong> gebruikers gevonden die voldoen aan uw zoekterm "<?= $search ?>".</p>
            <a href="<?= base_url() ?>admin/users" class="btn btn-default">Terug</a>
        <?php } ?>
    </div>
</div>