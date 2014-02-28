<h1>Welkom, <?= SessionHelper::userdata('firstname') ?> 
    <?= SessionHelper::userdata('lastname') ?> 
    (<?= SessionHelper::userdata('username') ?>)</h1>
<p>U bent nu ingelogd.</p>
<p><a class="btn btn-primary" href="<?= base_url() ?>">Ok</a></p>