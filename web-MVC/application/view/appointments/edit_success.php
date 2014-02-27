<!DOCTYPE html>
<html>
    <head>
        <title>Afspraak wijzigen - Afspraken planner</title>
        <?php include_once partials_url() . 'header.php' ?>
    </head>
    <body>
        <?php include_once partials_url() . 'navigation.php' ?>
        <div class="container">
            <h1>Afspraak gewijzigd</h1>
            <p>De afspraak werd gewijzigd naar de volgende gegevens.</p>

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
                        <?php if($this->data['appointment']['chronological']) { ?>
                            Inschrijvingen verlopen verplicht in chronologische volgorde.
                        <?php } else { ?>
                            Inschrijvingen kunnen op elk tijdstip.
                        <?php } ?>
                    </td>
                </tr>
            </table>

            <p><a href="<?= external_url() ?>appointments/detail/<?= $this->data['appointment']['appointmentid'] ?>" class="btn btn-default">Terug</a></p>
            <?php include_once partials_url() . 'message.php' ?>
        </div>
        <?php include_once partials_url() . 'scripts.php' ?>
    </body>
</html>
