<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?= $title ?> - Afspraken planner</title>

        <!-- Stylesheets: bootstrap, bootstrap theme & eigen stijlblad -->
        <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>bootstrap/css/bootstrap.spacelab.min.css" />
        <link rel="stylesheet" type="text/css" href="<?= assets_url() ?>css/main.css" />

    </head>
    <body>

        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="#">Afsprakenplanner</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= base_url() ?>home">Home</a></li>
                        <li class="dropdown">
                            
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="<?= base_url() ?>home" id="themes">Afspraken <span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a tabindex="-1" href="<?= base_url() ?>appointments/view">Mijn afspraken</a></li>
                                <li><a tabindex="-1" href="<?= base_url() ?>appointments/create">Afspraak maken</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= base_url() ?>availability">Beschikbaarheid</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">
                                <span class="glyphicon glyphicon-user"></span> 
                                Profiel <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a href="#"><strong>Niet ingelogd</strong></a></li>
                                <li class="nav-divider"></li>
                                <li><a tabindex="-1" href="<?= base_url() ?>profile/register">Registreer</a></li>
                                <li><a tabindex="-1" href="<?= base_url() ?>profile/login">Log in</a></li>
                                <li><a tabindex="-1" href="<?= base_url() ?>profile/logout">Log uit</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
        
        <div class="container">
            <?= $content ?>
            
            <?php if(strlen($message) > 0) { ?>
            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                <?= $message ?>
            </div>
            <?php } ?>
            
        </div>
        
        <!-- Javascript files staan op het einde voor snellere laadtijden -->
        <script src="<?= assets_url() ?>js/jquery-1.11.0.min.js"></script>
        <script src="<?= assets_url() ?>bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>