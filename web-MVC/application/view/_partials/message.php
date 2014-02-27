<?php if (isset($_SESSION['message'])) { ?>
    <?php foreach ($_SESSION['message'] as $message) { ?>
        <div class="alert alert-<?= $message['class'] ?>">
            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
            <?= $message['text'] ?>
        </div>
    <?php } ?>
    <?php unset($_SESSION['message']) ?>
<?php } ?>

<?php if (isset($_SESSION['act'])) { ?>
    <hr />
    <p>
        U handelt momenteel in naam van 
        <strong><?= userdata('firstname') ?> 
            <?= userdata('lastname') ?> (<?= userdata('username') ?>)</strong>.
    </p>
    <p><a class="btn btn-default" href="<?= base_url() ?>admin/stopact_as">Terug naar eigen profiel</a></p>
<?php } ?>