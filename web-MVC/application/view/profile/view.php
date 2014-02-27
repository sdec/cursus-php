<h1>Profiel</h1>
<table class="table table-hover table-striped table-vertical">
    <tr>
        <td>Gebruikersnaam</td>
        <td><?= $this->user['username']; ?></td>
    </tr>
    <tr>
        <td>Voornaam</td>
        <td><?= $this->user['firstname']; ?></td>
    </tr>
    <tr>
        <td>Familienaam</td>
        <td><?= $this->user['lastname']; ?></td>
    </tr>
    <tr>
        <td>Email adres</td>
        <td><a href="mailto:<?= $this->user['email']; ?>"><?= $this->user['email']; ?></a></td>
    </tr>
    <tr>
        <td>Type profiel</td>
        <td><?= accessLevelName($this->user['accesslevel']); ?></td>
    </tr>
</table>

<?php if ($this->user['accesslevel'] < userdata('accesslevel')) { ?>
    <?php if (userdata('accesslevel') >= ADVISOR) { ?>
        <hr />
        <a href="<?= base_url() ?>admin/act_as/<?= $user['username']; ?>" class="btn btn-primary">
            <span class="glyphicon glyphicon-user"></span> 
            Handel in naam van deze gebruiker
        </a>
        <?php if (userdata('accesslevel') >= ADMIN) { ?>

            <a href="<?= base_url() ?>admin/edituser/<?= $user['username']; ?>" class="btn btn-primary">
                <span class="glyphicon glyphicon-edit"></span> 
                Wijzig gebruiker
            </a> 
            <a href="<?= base_url() ?>admin/deleteuser/<?= $user['userid']; ?>" class="btn btn-danger">
                <span class="glyphicon glyphicon-remove-sign"></span> 
                Verwijder gebruiker
            </a>
        <?php } ?>
    <?php } ?>
<?php } ?>