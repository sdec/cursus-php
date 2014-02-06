<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Beschikbaarheid - Cursus PHP Basiswebsite</title>

        <?php include_once('../Php Basic Website/partials/navbar.php'); ?>
            <h1>Beschikbaarheid</h1>
            <div class="row">
                <div class="col-lg-4">
                    <h3>Lectoren</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Voornaam</td>
                                <td>Achternaam</td>
                                <td>Gebruikersnaam</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Elke</td>
                                <td>Steegmans</td>
                                <td>Elste</td>
                            </tr>
                            <!-- etcetera ... -->
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h3>Vakken</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Vak</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>Dynamische Websites</td></tr>
                            <tr><td>Web Design</td></tr>
                            <tr><td>OO</td></tr>
                            <!-- etcetera ... -->
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-4">
                    <h3>Lokalen</h3>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <td>Lokaal</td>
                            </tr>
                        </thead>
                        <tbody>
                            <tr><td>318</td></tr>
                            <tr><td>319</td></tr>
                            <tr><td>320</td></tr>
                            <!-- etcetera ... -->
                        </tbody>
                    </table>
                </div>
            </div>
<?php include_once('../Php Basic Website/partials/footer.php'); ?>