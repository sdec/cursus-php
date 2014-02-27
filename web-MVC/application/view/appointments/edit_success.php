
<h1>Afspraak gewijzigd</h1>
<p>De afspraak werd gewijzigd naar de volgende gegevens.</p>

<table class="table table-hover table-striped table-vertical">
    <tr>
        <td>Startdatum</td>
        <td><?= $this->appointment['date'] ?></td>
    </tr>
    <tr>
        <td>Startuur</td>
        <td><?= $this->appointment['start'] ?></td>
    </tr>
    <tr>
        <td>Einduur</td>
        <td><?= $this->appointment['end'] ?></td>
    </tr>
    <tr>
        <td>Beschrijving</td>
        <td><?= $this->appointment['description'] ?></td>
    </tr>
    <tr>
        <td>Locatie</td>
        <td><?= $this->appointment['location'] ?></td>
    </tr>
    <tr>
        <td>Chronologie</td>
        <td>
            <?php if ($this->appointment['chronological']) { ?>
                Inschrijvingen verlopen verplicht in chronologische volgorde.
            <?php } else { ?>
                Inschrijvingen kunnen op elk tijdstip.
            <?php } ?>
        </td>
    </tr>
</table>

<p><a href="<?= base_url() ?>appointments/detail/<?= $this->appointment['appointmentid'] ?>" class="btn btn-default">Terug</a></p>
