<?php
    define('BASE_URL', '../');
    require_once(BASE_URL . 'includes/config/routes.php');
    require_once(config_url() . 'functions.php');
    require_once(config_url() . 'form_helper.php');
    require_once(queries_url() . 'DB_userprofile.php');

if(isset($_POST['inputLogout']) && isset($_SESSION['user']['username'])){
    unset($_SESSION['user']);
    redirect("profile/login.php", "U bent uitgelogt.", "success");
}
if(isset($_SESSION['user']['username'])){
    $title = "Logout";
} else {
    $title = "Log in - Cursus PHP Basiswebsite";
    $messages = initializeMessages(array("username", "password"));
    
    if(isset($_POST['inputUsername'])){
        $messages['username'] = checkPostLength('inputUsername', "Je gebruikersnaam was te kort/lang! (>= 5 en <= 32)", 5, 32);
        $messages['password'] = checkPostLength('inputPassword', "Je password was te kort/lang! (>= 5 en <= 32)", 5, 32);
        
        if($messages['username']['status'] == "" && $messages['password']['status'] == ""){ //If no form errors
            DB_Connect();
            if(login($_POST['inputUsername'], $_POST['inputPassword'])['username']){ //vb : login("r0426942", "paswoord");
                $_SESSION['user'] = login($_POST['inputUsername'], $_POST['inputPassword']);
                redirect("index.php", "Welkom terug, " . $_SESSION['user']['firstname'] . "!", "success");
            } else { 
                flashmessage("Sorry, je gegevens waren niet correct, probeer het nog eens...", "danger");
            }
            DB_Close();
        }
    }
}
?>
<!DOCTYPE html>
<html>
    <head>
        <?php include_once(partials_url() . 'header.php'); ?>
    </head>
    <body>
        <?php include_once(partials_url() . 'navigation.php'); ?>
            <div class="container"> <!-- page main-content -->
            <?php if(isset($_SESSION['user']['username'])): ?>
                <h1>Bent u zeker dat u wilt uit loggen?</h1>
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
                                    <button type="submit" class="btn btn-primary">Log uit (<?= $_SESSION['user']['username']; ?>)</button> 
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
        <?php include_once partials_url() . 'message.php' ?>
    </div> <!-- end page main-content -->
    <?php include_once(partials_url().'footer.php'); ?>
    </body>
    <?php include_once partials_url() . 'scripts.php' ?>
</html>