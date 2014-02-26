<!DOCTYPE html>
<html>
    <head>
        <title>Registreren - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">

            <h1>Registratie compleet</h1>
            <p>U bent nu geregistreerd.</p>
            <p><a class="btn btn-primary" href="<?= external_url();?>">Ok</a></p>
            
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>