
<h1>Afspraak aangemaakt</h1>
<p>Een afspraak met de volgende details werd aangemaakt.</p>

<table class="table table-hover table-striped table-vertical">
    <tr>
        <td>Startdatum</td>
        <td><?= $this->data['appointment']['date'] ?></td>
    </tr>
    <tr>
        <td>Startuur</td>
        <td><?= $this->data['appointment']['start'] ?></td>
    </tr>
    <tr>
        <td>Einduur</td>
        <td><?= $this->data['appointment']['end'] ?></td>
    </tr>
    <tr>
        <td>Beschrijving</td>
        <td><?= $this->data['appointment']['description'] ?></td>
    </tr>
    <tr>
        <td>Locatie</td>
        <td><?= $this->data['appointment']['location'] ?></td>
    </tr>
    <tr>
        <td>Chronologie</td>
        <td>
            <?php if ($this->data['appointment']['chronological']) { ?>
                Inschrijvingen verlopen verplicht in chronologische volgorde.
            <?php } else { ?>
                Inschrijvingen kunnen op elk tijdstip.
            <?php } ?>
        </td>
    </tr>
</table>

<div class="alert alert-info">
    <p>
        Er werden nog geen organisatoren toegewezen aan deze afspraak (m.a.w. er is nog niemand waarbij studenten een afspraak kunnen maken). 
        Open de detailweergave van een afspraak en klik op "Voeg organisator toe" om iemand toe te voegen aan deze afspraak.
    </p>
</div>

<p><a href="<?= base_url() ?>" class="btn btn-default">Terug</a></p>