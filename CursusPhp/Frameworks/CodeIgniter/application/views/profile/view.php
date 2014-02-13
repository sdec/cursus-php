<h1>
    <?= $this->session->userdata('user')->userid == $user->userid ? 'Mijn profiel' : 'Profiel van ' . $user->firstname . ' ' . $user->lastname ?>
</h1>
<table class="table table-hover table-striped table-vertical">
    <tr>
        <td>Gebruikersnaam</td>
        <td><?= $user->username ?></td>
    </tr>
    <tr>
        <td>Voornaam</td>
        <td><?= $user->firstname ?></td>
    </tr>
    <tr>
        <td>Familienaam</td>
        <td><?= $user->lastname ?></td>
    </tr>
    <tr>
        <td>Email adres</td>
        <td><a href="mailto:<?= $user->email ?>"><?= $user->email ?></a></td>
    </tr>
    <tr>
        <td>Type profiel</td>
        <td><?= $this->UserModel->accessLevelName($user->accesslevel) ?></td>
    </tr>
</table>
<?php if ($user->accesslevel < $this->session->userdata('user')->accesslevel) { ?>
    <?php if ($this->session->userdata('user')->accesslevel >= ADVISOR) { ?>
        <hr />
        <a href="<?= base_url() ?>admin/act_as/<?= $user->username ?>" class="btn btn-primary">
            <span class="glyphicon glyphicon-user"></span> 
            Handel in naam van deze gebruiker
        </a>
        <?php if ($this->session->userdata('user')->accesslevel >= ADMIN) { ?>

            <a href="<?= base_url() ?>admin/edituser/<?= $user->username ?>" class="btn btn-primary">
                <span class="glyphicon glyphicon-edit"></span> 
                Wijzig gebruiker
            </a> 
            <a href="<?= base_url() ?>admin/deleteuser/<?= $user->username ?>" class="btn btn-danger">
                <span class="glyphicon glyphicon-remove-sign"></span> 
                Verwijder gebruiker
            </a>
        <?php } ?>
    <?php } ?>
<?php } ?>
