<?php if (isset($_SESSION['message'])) { ?>
    <?php foreach($_SESSION['message'] as $message) { ?>
        <div class="alert alert-<?= $message['class'] ?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= $message['text'] ?>
        </div>
    <?php } ?>
    <?php unset($_SESSION['message']) ?>
<?php } ?>