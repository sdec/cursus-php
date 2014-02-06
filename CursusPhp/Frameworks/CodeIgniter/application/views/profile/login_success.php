<h1>Welkom, <?= $this->session->userdata('user')->firstname ?> 
        <?= $this->session->userdata('user')->lastname ?> 
        (<?= $this->session->userdata('user')->username ?>)</h1>
<p>U bent nu ingelogd.</p>
<p><a class="btn btn-primary" href="<?= base_url()?>">Ok</a></p>