<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Home - Cursus PHP Basiswebsite</title>

        <!-- Stylesheets: bootstrap, bootstrap theme & eigen stijlblad -->
        <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/bootstrap/css/bootstrap.spacelab.min.css" />
        <link rel="stylesheet" type="text/css" href="assets/css/eigenstijl.css" />

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
                        <li><a href="index.php">Home</a></li>
                        <li class="dropdown">
                            
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Afspraken <span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a tabindex="-1" href="appointments/viewappointments.php">Mijn afspraken</a></li>
                                <li><a tabindex="-1" href="appointments/createappointment.php">Afspraak maken</a></li>
                            </ul>
                        </li>
                        <li><a href="availability.php">Beschikbaarheid</a></li>
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
                                <li><a tabindex="-1" href="profile/register.php">Registreer</a></li>
                                <li><a tabindex="-1" href="profile/login.php">Log in</a></li>
                                <li><a tabindex="-1" href="profile/logout.php">Log uit</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="spacer"></div>
        
        <div class="container">
            <div class="jumbotron">
                <h1>Afsprakenplanner</h1>
                <p class="lead">
                    De afsprakenplanner laat u toe om afspraken te plannen bij lectoren voor een bepaald vak. 
                    Na dat de afspraak gepland is zal de lector een lokaal toewijzen aan de afspraak.
                </p>
                
                <p>
                    <a href="appointments/viewappointments.php" class="btn btn-primary">Mijn afspraken</a> 
                    <a href="appointments/createappointment.php" class="btn btn-primary">Maak een afspraak</a>
                </p>
            </div>
        </div>

        <!-- Javascript files staan op het einde voor snellere laadtijden -->
        <script src="assets/js/jquery-1.11.0.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>