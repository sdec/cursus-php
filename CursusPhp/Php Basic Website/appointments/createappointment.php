<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Afspraak maken - Cursus PHP Basiswebsite</title>
        
        <!-- jQuery datum & tijd picker -->
        <link rel="stylesheet" type="text/css" href="../assets/css/jquery.datetimepicker.css" />
        <?php include_once('../../Php Basic Website/partials/navbar.php'); ?>
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
                                <button type="submit" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Maak afspraak</button> 
                                <a href="../appointments/viewappointments.php" class="btn btn-default">Cancel</a>
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php include_once('../../Php Basic Website/partials/footer.php'); ?>
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