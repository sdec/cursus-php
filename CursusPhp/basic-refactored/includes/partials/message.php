<?php if (isset($_SESSION['message'])) { ?>
    <div class="alert alert-$_SESSION['message']['class']">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <?= $_SESSION['message']['text'] ?>
    </div>
    <?php unset($_SESSION['message']) ?>
<?php } ?>