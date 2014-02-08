<h1>Afspraak aangemaakt</h1>
<p>Een afspraak met de volgende details werd aangemaakt.</p>

<table class="table table-hover table-striped table-vertical">
    <tr>
        <td>Startdatum</td>
        <td><?= $date ?></td>
    </tr>
    <tr>
        <td>Startuur</td>
        <td><?= $start ?></td>
    </tr>
    <tr>
        <td>Einduur</td>
        <td><?= $end ?></td>
    </tr>
    <tr>
        <td>Beschrijving</td>
        <td><?= $description ?></td>
    </tr>
    <tr>
        <td>Locatie</td>
        <td><?= $location ?></td>
    </tr>
</table>

<div class="alert alert-info">
    <p>
        Er werden nog geen organisatoren toegewezen aan deze afspraak (m.a.w. er is nog niemand waarbij studenten een afspraak kunnen maken voor deze afspraak). 
        Een afspraak is pas zichtbaar voor studenten wanneer er minstens 1 organisator aan toegewezen werd.
    </p>
    <p><a href="<?= base_url() ?>appointments/addlecturer">Wijs een organisator toe aan deze afspraak.</a></p>
</div>

<p><a href="<?= base_url() ?>" class="btn btn-default">Terug</a></p>