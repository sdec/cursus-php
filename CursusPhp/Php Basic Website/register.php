<?php
    include_once('path_helper.php');
    include_once(includes_url() . 'defines.php');
    include_once(includes_url() . 'functions.php');

if(isset($_SESSION['user']['username'])){
    //Redirect to the logout page, you can't register while logged in!
    header("Location: " . base_url() . "login.php");//, 303);
    die();
} else {
    $title = "Register - Cursus PHP Basiswebsite";
    $messages = array(
        "username" => array(
            "status" => "",
            "message" => ""),
        "password" => array(
            "status" => "",
            "message" => ""),
        "firstname" => array(
            "status" => "",
            "message" => ""),
        "lastname" => array(
            "status" => "",
            "message" => ""),
        "email" => array(
            "status" => "",
            "message" => "")
        );
    if(isset($_POST['inputUsername'])){
         //Check for length of the fields
         $messages['username'] = checkPostLength('inputUsername', "Je gebruikersnaam was te kort/lang! (>= 5 en <= 32)", 5, 32);
         $messages['password'] = checkPostLength('inputPassword', "Je password was te kort/lang! (>= 5 en <= 32)", 5, 32);
         $messages['firstname'] = checkPostLength('inputFirstname', "Je voornaam was te kort/lang! (>= 2 en <= 32)", 2, 32);
         $messages['lastname'] = checkPostLength('inputLastname', "Je naam was te kort/lang! (>= 2 en <= 32)", 2, 32);
         $messages['email'] = checkPostLength('inputEmail', "Je email was te kort/lang! (>= 5 en <= 32)", 5, 32);
        if($messages['username']['status'] == "" && $messages['password']['status'] == "" && $messages['firstname']['status'] == ""
            && $messages['lastname']['status'] == "" && $messages['email']['status'] == ""){
            $_SESSION['user'] = createUser($_POST['inputUsername'], $_POST['inputFirstname'], $_POST['inputLastname'], $_POST['inputPassword'], $_POST['inputEmail']);
        }
    }
}
?>
<?php include_once(partials_url() . 'header.php'); ?>
    </head>
    <body>
    <?php include_once(partials_url() . 'navbar.php'); ?>
    <div class="container"> <!-- page main-content -->
        <h1>Registreer</h1>
        <div class="well">
            <form method="POST" role="form" class="form-horizontal">
                <fieldset>
                    <div class="form-group <?= $messages['username']['status']; ?>">
                        <label for="inputUsername" class="col-lg-2 control-label">Gebruikersnaam(*)</label>
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
                        <label for="inputPassword" class="col-lg-2 control-label">Paswoord(*)</label>
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
                    <div class="form-group <?= @$messages['firstname']['status'] ?>">
                        <label for="inputFirstname" class="col-lg-2 control-label">Voornaam(*)</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="inputPassword" name="inputFirstname"
                                  placeholder="Bob" maxlength="128" value="<?= @$_POST['inputFirstname'] ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <span class="text-danger">
                            <?= @$messages["firstname"]["message"] ?>
                            </span>
                        </div>
                    </div>
                    <div class="form-group <?= @$messages['lastname']['status'] ?>">
                        <label for="inputLastname" class="col-lg-2 control-label">Achternaam(*)</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="inputLastname" name="inputLastname"
                                  placeholder="Robinson" maxlength="128" value="<?= @$_POST['inputLastname'] ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <span class="text-danger">
                            <?= @$messages["lastname"]["message"] ?>
                            </span>
                        </div>
                    </div>
                    <div class="form-group <?= @$messages['email']['status'] ?>">
                        <label for="inputEmail" class="col-lg-2 control-label">E-mail(*)</label>
                        <div class="col-lg-4">
                            <input type="text" class="form-control" id="inputPassword" name="inputEmail"
                                  placeholder="Bob.Robinson@student.khleuven.be" maxlength="128" value="<?= @$_POST['inputEmail'] ?>" required>
                        </div>
                        <div class="col-lg-6">
                            <span class="text-danger">
                            <?= @$messages["email"]["message"] ?>
                            </span>
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
    </div> <!-- end page main-content -->
    <?php include_once(partials_url().'footer.php'); ?>
    </body>
</html>