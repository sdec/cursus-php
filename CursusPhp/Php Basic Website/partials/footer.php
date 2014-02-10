<?php

?>              
        <div class="container">
            <hr />
            <span class="text-muted">Flawed design with a message</span>
        </div>
        
        <!-- Javascript files staan op het einde voor snellere laadtijden -->
        <script src="<?= assets_url(); ?>js/jquery-1.11.0.min.js"></script>
        <script src="<?= assets_url(); ?>bootstrap/js/bootstrap.min.js"></script>
<?php//Exit
    mysqli_close($MySQLDB);
?>