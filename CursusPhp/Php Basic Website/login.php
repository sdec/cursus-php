<?php
include_once('system/path_helper.php');

if(isset($_POST['inputLogout']) && isset($_SESSION['user']['username'])){
    session_destroy();
    echo "Logout sucessful!";
}
if(isset($_SESSION['user']['username'])){
    $title = "Logout";
    echo "logged in user : " . $_SESSION['user']['username'];
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
        if(strlen($_POST['inputUsername']) >= 5 && strlen($_POST['inputUsername']) <= 32){
         } else {
            $messages["username"]["message"] = "Je gebruikersnaam was te kort/lang! (>= 5 en <= 32)";
            $messages["username"]["status"] = "has-error";
         }
         if(isset($_POST['inputPassword'])){
                if(strlen($_POST['inputPassword']) >= 5 && strlen($_POST['inputPassword']) <= 32){
                    if(login($_POST['inputUsername'], $_POST['inputPassword'])['username']){ //vb : login("r0426942", "paswoord");
                        $_SESSION['user'] = login($_POST['inputUsername'], $_POST['inputPassword']);
                        var_dump($_SESSION['user']);
                    } else { 
                        $messages["password"]["message"] = "Je username/wachtwoord was niet correct, probeer het nog eens!";
                        $messages["password"]["status"] = "has-error";
                    }
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
    <?php include_once(partials_url() . 'header.php'); ?>
        <script type="text/javascript">
            function testAlert(){
                alert("Javascript is enabled!");
            }
        </script>
        </head>
    <body>
        <?php include_once(partials_url() . 'navbar.php'); ?>
            <div class="container"> <!-- page main-content -->
            <?php if(isset($_SESSION['user']['username'])): ?>
                <h1>Are you sure you wish to logout?</h1>
                <div class="well">
                    <form class="form-horizontal" method="POST">
                        <fieldset>
                            <div class="form-group">
                                <div class="col-lg-10">
                                    <input type="hidden" class="form-control" id="inputUsername" name="inputLogout" placeholder="true" value="t">
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-10 col-lg-offset-2">
                                    <button type="submit" class="btn btn-primary">Log out (<?= $_SESSION['user']['username']; ?>)</button> 
                                </div>
                            </div>
                        </fieldset>
                    </form>
                </div>
            <?php else: ?>
    <h1>Log in</h1>
    <div class="well">
        <form method="POST" role="form" class="form-horizontal">
            <fieldset>
                <div class="form-group <?= $messages['username']['status']; ?>">
                    <label for="inputUsername" class="col-lg-2 control-label">Gebruikersnaam</label>
                    <div class="col-lg-4">
                        <input type="text" class="form-control" id="inputUsername" name="inputUsername"
                              placeholder="Gebruikersnaam" maxlength="32" value="<?= @$_POST['inputUsername'] ?>" required>
                    </div>
                    <div class="col-lg-6">
                        <span class="text-danger">
                        <?= @$messages["username"]["message"] ?>
                        </span>
                    </div>
                </div>
                <div class="form-group <?= @$messages['password']['status'] ?>">
                    <label for="inputPassword" class="col-lg-2 control-label">Paswoord</label>
                    <div class="col-lg-4">
                        <input type="password" class="form-control" id="inputPassword" name="inputPassword"
                              placeholder="Paswoord" maxlength="128" value="<?= @$_POST['inputPassword'] ?>" required>
                    </div>
                    <div class="col-lg-6">
                        <span class="text-danger">
                        <?= @$messages["password"]["message"] ?>
                        </span>
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
    </div> <!-- end page main-content -->
    <?php include_once(partials_url().'footer.php'); ?>
    </body>
</html>