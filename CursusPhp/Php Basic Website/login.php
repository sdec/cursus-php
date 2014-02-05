<?php

if(isset($_SESSION['user']['username'])){
    $title = "Logout";
    echo "logged in user : " . $_SESSION['user']['username'];
    if($_POST['inputLogout'] === 'true'){
        session_destroy();
        echo "Logout sucessful!";
    }
} else {
    $title = "Log in - Cursus PHP Basiswebsite";
    $messages = array(
        "username" => array(
            "status" => "",
            "message" => ""),
        "password" => array(
            "status" => "",
            "message" => "")
        );
    if(isset($_POST['inputUsername'])){
        if(strlen($_POST['inputUsername']) > 5 && strlen($_POST['inputUsername']) <= 32){
         } else {
            $messages["username"]["message"] = "Je gebruikersnaam was te kort/lang! (>= 5 en <= 32)";
            $messages["username"]["status"] = "has-error";
         }
         if(isset($_POST['inputPassword'])){
                if(strlen($_POST['inputPassword']) > 5 && strlen($_POST['inputPassword']) <= 32){
                    session_start();
                    $_SESSION['user'] = array("username" => $_POST['inputUsername'],
                                              "role" => "admin");
                } else {
                    $messages["password"]["message"] = "Je password was te kort/lang! (>= 5 en <= 32)";
                    $messages["password"]["status"] = "has-error";
                }
            } else {
                //$messages["password"]["message"] = "Gelieve een passwoord in te geven";
            }
    } else {
        //$messages["username"]["message"] = "Gelieve een gebruikersnaam in te vullen";
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?php echo $title;?></title>
        <script type="text/javascript">
            function testAlert(){
                alert("Javascript is enabled!");
            }
        </script>
        <?php include_once('../Php Basic Website/partials/navbar.php'); ?>
        <?php if(isset($_SESSION['user']['username'])): ?>
            <h1>Log out</h1>
            <div class="well">
                <form class="form-horizontal" method="POST">
                    <fieldset>
                        <div class="form-group">
                            <div class="col-lg-10">
                                <input type="hidden" class="form-control" id="inputUsername" name="inputLogout" placeholder="true" value="true">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-lg-10 col-lg-offset-2">
                                <button type="submit" class="btn btn-primary">Log out</button> 
                            </div>
                        </div>
                    </fieldset>
                </form>
            </div>
        <?php else: ?>
            <h1>Log in</h1>
            <div class="well">
                <form class="form-horizontal" onsubmit="return testAlert()" method="POST">
                    <fieldset>
                        <div class="form-group <?php echo $messages['username']['status']; ?>">
                            <label for="inputUsername" class="col-lg-2 control-label">Gebruikersnaam</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" id="inputUsername" name="inputUsername" placeholder="Gebruikersnaam" value="<?php if(isset($_POST['inputUsername'])){ echo $_POST['inputUsername'];} ?>" required>
                                <label for="inputUsername" class="control-label"><?php echo $messages["username"]["message"]; ?></label>
                            </div>
                        </div>
                        <div class="form-group <?php echo $messages['password']['status']; ?>">
                            <label for="inputPassword" class="col-lg-2 control-label">Paswoord</label>
                            <div class="col-lg-10">
                                <input type="password" class="form-control" id="inputPassword" name="inputPassword" placeholder="Paswoord" required>
                                <label for="inputPassword" class="control-label"><?php echo $messages["password"]["message"]; ?></label>
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
            <?php endif; ?>
        <?php include_once('../Php Basic Website/partials/footer.php'); ?>