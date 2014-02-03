<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Registreren - Cursus PHP Basiswebsite</title>

        <!-- Stylesheets: bootstrap, bootstrap theme & eigen stijlblad -->
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.spacelab.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/eigenstijl.css" />

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
                        <li><a href="../index.php">Home</a></li>
                        <li class="dropdown">

                        </li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Afspraken <span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a tabindex="-1" href="../appointments/viewappointments.php">Mijn afspraken</a></li>
                                <li><a tabindex="-1" href="../appointments/createappointment.php">Afspraak maken</a></li>
                            </ul>
                        </li>
                        <li><a href="../availability.php">Beschikbaarheid</a></li>
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
                                <li><a tabindex="-1" href="register.php">Registreer</a></li>
                                <li><a tabindex="-1" href="login.php">Log in</a></li>
                                <li><a tabindex="-1" href="logout.php">Log uit</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="spacer"></div>

        <div class="container">
            <h1>Registreer een profiel</h1>
            <div class="well">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputUsername" class="col-lg-2 control-label">Gebruikersnaam</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="Gebruikersnaam" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPassword" class="col-lg-2 control-label">Paswoord</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Paswoord" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputPasswordConfirm" class="col-lg-2 control-label">Bevestig paswoord</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="inputPasswordConfirm" name="inputPasswordConfirm" placeholder="Paswoord" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail" class="col-lg-2 control-label">Email</label>
                            <div class="col-lg-10">
                                <input type="email" class="form-control" id="inputEmail" name="inputEmail" placeholder="Email" required>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Registreer</button> 
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

        <!-- Javascript files staan op het einde voor snellere laadtijden -->
        <script src="../assets/js/jquery-1.11.0.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>

    </body>
</html>