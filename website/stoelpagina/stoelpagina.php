<?php
session_start();

// Simuleer bezette stoelen (in productie: haal uit database)
$bezetStoelen = isset($_SESSION['bezetStoelen']) ? $_SESSION['bezetStoelen'] : [];

// Verwerk POST (bestelling)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Veilig ophalen en filteren
    $voornaam = htmlspecialchars(trim($_POST['voornaam'] ?? ''));
    $achternaam = htmlspecialchars(trim($_POST['achternaam'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
    $gekozenStoelen = isset($_POST['stoelen']) && is_array($_POST['stoelen']) ? $_POST['stoelen'] : [];

    $aantal_normaal = isset($_POST['aantal_normaal']) ? max(0, min(10, intval($_POST['aantal_normaal']))) : 0;
    $aantal_kind = isset($_POST['aantal_kind']) ? max(0, min(10, intval($_POST['aantal_kind']))) : 0;
    $aantal_65 = isset($_POST['aantal_65']) ? max(0, min(10, intval($_POST['aantal_65']))) : 0;
    $vouchercode = isset($_POST['vouchercode']) ? htmlspecialchars(trim($_POST['vouchercode'])) : '';

    if (strlen($vouchercode) > 20 || !preg_match('/^[A-Za-z0-9\-]*$/', $vouchercode)) {
        $errors[] = "Ongeldige vouchercode.";
    }
    if ($aantal_normaal + $aantal_kind + $aantal_65 < 1) {
        $errors[] = "Selecteer minimaal 1 ticket.";
    }

    $errors = [];
    if (!$voornaam)
        $errors[] = "Voornaam is verplicht.";
    if (!$achternaam)
        $errors[] = "Achternaam is verplicht.";
    if (!$email)
        $errors[] = "Ongeldig e-mailadres.";
    if (count($gekozenStoelen) < 1)
        $errors[] = "Selecteer minimaal 1 stoel.";

    // Check of stoelen al bezet zijn
    foreach ($gekozenStoelen as $stoel) {
        if (in_array($stoel, $bezetStoelen)) {
            $errors[] = "Stoel $stoel is al bezet.";
        }
    }

    if (empty($errors)) {
        // Zet stoelen op bezet (in productie: sla op in database)
        $bezetStoelen = array_merge($bezetStoelen, $gekozenStoelen);
        $_SESSION['bezetStoelen'] = $bezetStoelen;
        $success = "Bestelling succesvol! Je stoelen zijn gereserveerd.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="css/style.css?v=<?php echo filemtime('css/style.css'); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>annexbios</title>
</head>
<?php include '../includes/header.php'; ?>

<body>
    <div class="backgroundform">
        <div class="koptekst">TICKETS BESTELLEN</div>
        <div class="dropdown-row">
            <select name="film" id="film" class="styled-select">
                <option selected>JURASSIC WORLD</option>
                <!-- Meer films (later via API) -->
            </select>
            <select name="datum" id="datum" class="styled-select">
                <option selected>DATUM</option>
                <option value="2025-09-12">12 september 2025</option>
                <!-- Meer datums (later via API) -->
            </select>
            <select name="tijd" id="tijd" class="styled-select">
                <option selected>TIJDSTIP</option>
                <option value="20:00">20:00</option>
                <!-- Meer tijdstippen (later via API)-->
            </select>
        </div>
        <?php
        if (!empty($errors)) {
            foreach ($errors as $error) {
                echo "<p style='color:red; margin-left:32px;'>" . htmlspecialchars($error) . "</p>";
            }
        }
        if (!empty($success)) {
            echo "<p style='color:green; margin-left:32px;'>" . htmlspecialchars($success) . "</p>";
        }
        ?>
        <form method="post" autocomplete="off">
            <div class="stap">
                <h2>STAP 1: KIES JE TICKET</h2>
                <table>
                    <tr>
                        <th>TYPE</th>
                        <th>PRIJS</th>
                        <th>AANTAL</th>
                    </tr>
                    <tr>
                        <td>Normaal</td>
                        <td>€9,00</td>
                        <td><input type="number" min="0" max="10" name="aantal_normaal" value="0" required></td>
                    </tr>
                    <tr>
                        <td>Kind t/m 11 jaar</td>
                        <td>€5,00</td>
                        <td><input type="number" min="0" max="10" name="aantal_kind" value="0" required></td>
                    </tr>
                    <tr>
                        <td>65 +</td>
                        <td>€7,00</td>
                        <td><input type="number" min="0" max="10" name="aantal_65" value="0" required></td>
                    </tr>
                </table>
                <input type="text" placeholder="VOUCHERCODE" name="vouchercode" maxlength="20" pattern="[A-Za-z0-9\-]*">
                <button type="button">TOEVOEGEN</button>
            </div>
            <div class="mini-filminfo">
                <p>Film: JURASSIC WORLD | Zaal 3 | 12 september 2025 | 20:00</p>
            </div>
            <div class="stap">
                <h2>STAP 2: KIES JE STOEL</h2>
                <div class="stoelen">
                    <div>FILMDOEK</div>
                    <?php
                    for ($rij = 1; $rij <= 8; $rij++) {
                        echo '<div class="stoel-rij">';
                        for ($stoel = 1; $stoel <= 12; $stoel++) {
                            $id = "stoel_" . $rij . "_" . $stoel;
                            $extraClass = '';
                            if ($rij == 8 && ($stoel == 1 || $stoel == 2)) {
                                $extraClass = ' rolstoel';
                            }
                            $disabled = in_array($id, $bezetStoelen) ? 'disabled' : '';
                            echo '<label class="stoel' . $extraClass . '">';
                            echo '<input type="checkbox" name="stoelen[]" value="' . $id . '" id="' . $id . '" ' . $disabled . '>';
                            echo '<span></span>';
                            echo '</label>';
                        }
                        echo '</div>';
                    }
                    ?>
                </div>
                <div class="stoel-legenda">
                    <button type="button" class="legend-btn vrij">VRIJ</button>
                    <button type="button" class="legend-btn jouw">JOUW SELECTIE</button>
                    <button type="button" class="legend-btn bezet">BEZET</button>
                </div>
            </div>
            <div class="stap">
                <h2>STAP 4: VUL JE GEGEVENS IN</h2>
                <input type="text" name="voornaam" placeholder="Voornaam" required>
                <input type="text" name="achternaam" placeholder="Achternaam" required>
                <input type="email" name="email" placeholder="E-mailadres" required>
            </div>
            <div class="stap">
                <h2>STAP 5: KIES JE BETAALWIJZE</h2>
                <div class="betaalwijzen">
                    <!-- Betaalwijze iconen hier -->
                </div>
                <label>
                    <input type="checkbox" name="voorwaarden" required> Ik ga akkoord met de algemene voorwaarden
                </label>
            </div>
            <button class="afrekenen" type="submit">AFREKENEN</button>
        </form>
    </div>
</body>
<?php include '../includes/footer.php'; ?>