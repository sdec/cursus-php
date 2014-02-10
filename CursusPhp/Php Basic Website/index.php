<?php
    include_once('path_helper.php');
    include_once(includes_url() . 'defines.php');
    include_once(includes_url() . 'functions.php');
    $title = "Basic Phpsite - Home";
    
?>
        <?php include_once(partials_url() . 'header.php'); ?>
    </head>
    <body>
        <?php include_once(partials_url() . 'navbar.php'); ?>
        <div class="container"> <!-- page main-content -->
            <div class="jumbotron">
                <h1>Afsprakenplanner - BASIC</h1>
                <p class="lead">
                    Deze website is de Php BASIC versie van de afsprakenplanner die jullie doorheen de cursus zullen herbouwen/uitbreiden tot een OO-design.
                </p>
                <p>
                    <a href="<?=base_url(); ?>appointments/viewappointments.php" class="btn btn-primary"><span class="glyphicon glyphicon-list"></span> Mijn afspraken</a> 
                    <a href="<?=base_url(); ?>appointments/createappointment.php" class="btn btn-primary"><span class="glyphicon glyphicon-plus-sign"></span> Maak een afspraak</a>
                </p>
            </div>
        </div> <!-- end page main-content -->
        <?php include_once(partials_url().'footer.php'); ?>
    </body>
</html> 
