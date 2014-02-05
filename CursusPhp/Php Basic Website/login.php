<?php


var_dump($_POST);
if(isset($_POST['gebruikersnaam'])){
    if(isset($_POST[''])){
        
    }
}


?>

<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Log in - Cursus PHP Basiswebsite</title>
        <script type="text/javascript">
            function testAlert(){
                alert("Javascript is enabled!");
            }
        </script>
        <?php include_once('navbar.php'); ?>
            <h1>Log in</h1>
            <div class="well">
                <form class="form-horizontal" onsubmit="return testAlert()" method="POST">
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
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Log in</button> 
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php include_once('footer.php'); ?>