<h1>Mijn profiel</h1>
<table class="table table-hover table-striped table-vertical">
    <tr>
        <td>Gebruikersnaam</td>
        <td><?= $username ?></td>
    </tr>
    <tr>
        <td>Voornaam</td>
        <td><?= $firstname ?></td>
    </tr>
    <tr>
        <td>Familienaam</td>
        <td><?= $lastname ?></td>
    </tr>
    <tr>
        <td>Email adres</td>
        <td><a href="mailto:<?= $email ?>"><?= $email ?></a></td>
    </tr>
    <tr>
        <td>Laatste activiteit</td>
        <td><?= $lastActivity ?></td>
    </tr>
    <tr>
        <td>Type profiel</td>
        <td><?= $accessLevelName ?></td>
    </tr>
</table>