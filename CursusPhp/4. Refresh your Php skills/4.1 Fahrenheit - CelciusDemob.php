<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Chapter IV - Refresh your PHP-skills!</title>

        <!-- Stylesheets: bootstrap, bootstrap theme & eigen stijlblad -->
        <link rel="stylesheet" type="text/css" href="../Basis website/assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../Basis website/assets/bootstrap/css/bootstrap.spacelab.min.css" />
        <link rel="stylesheet" type="text/css" href="../Basis website/assets/css/eigenstijl.css" />

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
                    <a class="navbar-brand" href="#">Cursussite</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="#">Refresh your Php skills!</a></li>
                        <li class="dropdown">
                            
                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Refresh <span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a tabindex="-1" href="appointments/viewappointments.php">Your Php</a></li>
                                <li><a tabindex="-1" href="appointments/createappointment.php">Skills!</a></li>
                            </ul>
                        </li>
                        <li><a href="availability.php">Your Php skills!</a></li>
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
                <h1>4.1 Celcius to Fahrenheit</h1>
                <p class="lead">
                    Om ons geheugen even op te frissen zullen we snel even en conversie functie schrijven om Celcius naar Fahrenheit om te zetten.
					Gebruik hiervoor de onderstaande formule : <br/>
					F =  C * 1.8 + 32
                </p>
				<p> <?php
					include('4.1 Fahrenheit - Celciusbs.php');
				?> <a href="4.1 Fahrenheit - Celciuss.php" class="btn btn-primary">Php-sample code</a> </p>
                
                <p>
                    <a href="#" class="btn btn-primary">Vorige Les</a>
					<a href="4.1 Fahrenheit - Celcius.php" class="btn btn-primary">Opgave</a> 
                    <a href="#" class="btn btn-primary">Wordsnake</a>
                </p>
            </div>
        </div>

        <!-- Javascript files staan op het einde voor snellere laadtijden -->
        <script src="assets/js/jquery-1.11.0.min.js"></script>
        <script src="assets/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>