<h1>Welkom, <?= userdata('firstname') ?> 
    <?= userdata('lastname') ?> 
    (<?= userdata('username') ?>)</h1>
<p>U bent nu ingelogd.</p>
<p><a class="btn btn-primary" href="<?= base_url() ?>">Ok</a></p>