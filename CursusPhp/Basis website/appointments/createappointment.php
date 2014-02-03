<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Afspraak maken - Cursus PHP Basiswebsite</title>

        <!-- Stylesheets: bootstrap, bootstrap theme & eigen stijlblad -->
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/bootstrap/css/bootstrap.spacelab.min.css" />
        <link rel="stylesheet" type="text/css" href="../assets/css/eigenstijl.css" />
        
        <!-- jQuery datum & tijd picker -->
        <link rel="stylesheet" type="text/css" href="../assets/css/jquery.datetimepicker.css" />
        
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
                                <li><a tabindex="-1" href="../profile/register.php">Registreer</a></li>
                                <li><a tabindex="-1" href="../profile/login.php">Log in</a></li>
                                <li><a tabindex="-1" href="../profile/logout.php">Log uit</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="spacer"></div>

        <div class="container">
            <h1>Afspraak aanmaken</h1>
            <p>Vul onderstaande gegevens in om een afspraak te maken.</p>

            <div class="well">
                <form class="form-horizontal">
                    <fieldset>
                        <div class="form-group">
                            <label for="inputDescription" class="col-lg-2 control-label">Beschrijving</label>
                            <div class="col-lg-10">
                                <textarea maxlength="256" name="inputDescription" id="inputDescription" placeholder="Beschrijf hier de reden voor de afspraak (max 256 karakters)" required></textarea>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputCourse" class="col-lg-2 control-label">Vak</label>
                            <div class="col-lg-10">
                                <select name="inputCourse" id="inputCourse">
                                    <option value="1">Dynamische Websites</option>
                                    <option value="2">Web Design</option>
                                    <option value="3">OO</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputLecturer" class="col-lg-2 control-label">Lector</label>
                            <div class="col-lg-10">
                                <select name="inputLecturer" id="inputLecturer">
                                    <option value="1">Steegmans, Elke</option>
                                    <option value="2">Fox, Patrick</option>
                                    <option value="3">Barrezeele, Griet</option>
                                    <option value="4">Van Hee, Jan</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputDateTime" class="col-lg-2 control-label">Datum & tijd</label>
                            <div class="col-lg-10">
                                <input name="inputDateTime" id="inputDateTime" type="text" required/>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Maak afspraak</button> 
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>

        <!-- Javascript files staan op het einde voor snellere laadtijden -->
        <script src="../assets/js/jquery-1.11.0.min.js"></script>
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        
        <!-- Configuratie van de datetimepicker -->
        <script src="../assets/js/jquery.datetimepicker.js"></script>
        <script type="text/javascript">
            var allowedTimes = [];
            for(var i = 8; i <= 17; i++) {
                for(var j = 0; j <= 50; j += 10) {
                    allowedTimes.push(('0' + i).slice(-2) + ':' + ('0' + j).slice(-2));
                }
            }
            $('#inputDateTime').datetimepicker({
                lang: 'nl',
                allowTimes: allowedTimes,
                format: 'd/m/Y H:i'
            });
        </script>
    </body>
</html>