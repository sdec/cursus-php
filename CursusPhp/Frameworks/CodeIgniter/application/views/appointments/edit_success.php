<h1>Afspraak gewijzigd</h1>
<p>De afspraak werd gewijzigd naar de volgende gegevens.</p>

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
    <tr>
        <td>Chronologie</td>
        <td>
            <?php if($chronological) { ?>
                Inschrijvingen verlopen verplicht in chronologische volgorde.
            <?php } else { ?>
                Inschrijvingen kunnen op elk tijdstip.
            <?php } ?>
        </td>
    </tr>
</table>

<p><a href="<?= base_url() ?>" class="btn btn-default">Terug</a></p>