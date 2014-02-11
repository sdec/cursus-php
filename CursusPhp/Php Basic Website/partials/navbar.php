<?php
?>
        <div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <a class="navbar-brand" href="<?= base_url(); ?>index.php">Php basic</a>
                </div>
                <div class="collapse navbar-collapse">
                    <ul class="nav navbar-nav">
                        <li><a href="<?= base_url(); ?>index.php">Index.php</a></li>
                        <li class="dropdown">
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">Database interactions <span class="caret"></span></a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><a href="<?= base_url(); ?>appointments/viewappointments.php">viewDB.php</a></li>
                                <li><a href="<?= base_url(); ?>appointments/createappointment.php">add.php</a></li>
                            </ul>
                        </li>
                        <li><a href="<?= base_url(); ?>availability.php">queries.php</a></li>
                    </ul>
                    <ul class="nav navbar-nav navbar-right">
                        <li>
                            <a class="dropdown-toggle" data-toggle="dropdown" href="#" id="themes">
                                <span class="glyphicon glyphicon-user"></span> 
                                <?php 
                                if(isset($_SESSION['user']['username'])){
                                    echo $_SESSION['user']['username'] . '(' . getRole($_SESSION['user']['accesslevel']) . ')';
                                } else {
                                    echo"Profile actions";
                                }?> <span class="caret"></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="themes">
                                <li><strong><?php if(!isset($_SESSION['user']['username'])){ echo "Niet ingelogd"; } else { echo "Ingelogd";}?></strong></li>
                                <li class="nav-divider"></li>
                                <?php if(isset($_SESSION['user']['username'])): ?>
                                <li><a href="<?= base_url(); ?>login.php">logout(login.php)</a></li>
                                <?php else: ?>
                                    <li><a href="<?= base_url(); ?>login.php">login.php</a></li>
                                    <li><a href="<?= base_url(); ?>register.php">registreer.php</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    <?php if(isset($_SESSION['flashmessages'])):
    foreach($_SESSION['flashmessages'] as $msg ): ?>
        <div class="alert alert-dismissable alert-<?= $msg['id']; ?>"><?= $msg['message']; ?></div>
    <?php endforeach; endif;
    $_SESSION['flashmessages'] = array();?>
        <!--<div class="spacer"/>-->