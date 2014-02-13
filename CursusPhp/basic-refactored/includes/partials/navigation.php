<?php require_once models_url() . 'UserModel.php'; ?>
<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?= base_url() ?>">Afsprakenplanner</a>
        </div>
        <div class="collapse navbar-collapse">
            <?php if (loggedin()) { ?>
                <?php if (userdata('accesslevel') >= LECTURER) { ?>
                    <ul class="nav navbar-nav">
                        <li><a href="<?= base_url() ?>admin/users.php">Gebruikers</a></li>
                    </ul>
                <?php } ?>
            <?php } ?>
            <ul class="nav navbar-nav navbar-right">
                <li>
                    <?php if (loggedin()) { ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">
                            <span class="glyphicon glyphicon-user"></span> 
                            <?= userdata('username') ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="themes">
                            <li><a tabindex="-1" href="<?= base_url() ?>profile/view.php">Mijn profiel</a></li>
                            <li><a tabindex="-1" href="<?= base_url() ?>profile/appointments.php">Mijn afspraken</a></li>
                            <li><a tabindex="-1" href="<?= base_url() ?>profile/logout.php">Log uit</a></li>
                        </ul>
                    <?php } else { ?>
                        <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">
                            <span class="glyphicon glyphicon-user"></span> 
                            Profiel <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="themes">
                            <li><a tabindex="-1" href="<?= base_url() ?>profile/register.php">Registreren</a></li>
                            <li><a tabindex="-1" href="<?= base_url() ?>profile/login.php">Log in</a></li>
                        </ul>
                    <?php } ?>
                </li>
            </ul>
        </div>
    </div>
</div>
<div class="spacer"></div>