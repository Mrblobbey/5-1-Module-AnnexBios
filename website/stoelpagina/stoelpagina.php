<?php
/*******************************************************
 * stoelpagina.php  (variant: tickets bevat row_label, seat_number, movie_screening_id)
 *******************************************************/

session_start();

// Databaseverbinding
require_once '../includes/db.php';
require_once '../includes/config.php';

$movie_screening_id = (int) ($_GET['id'] ?? 0);
if ($movie_screening_id < 1) {
    exit("Ongeldige filmvertoning.");
}

//  hier start hij de api aanvraag 1
$ch = curl_init($gluApiUrl . "/api/movie/{$movie_screening_id}");


// hier zet hij de api key in de http headers
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-API-KEY: " . $gluApikey,
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// hier kijk of de api goed aangevraagd is
$response = curl_exec($ch);

// hier checkt hij of er een error is anders stopt hij de code
if (curl_errno($ch)) {
    exit("Er is een fout opgetreden met de api.");
}
// hier maakt hij de terugkoppeling van de aanvraag in jason
$movieData = json_decode($response, true);

// hier checkt hij de database error en stopt de code bij error
if ($movieData['status'] !== 'success') {
    exit("Er is een fout opgetreden met de api.");
}
// hier pakt hij de film data als alles goed is
$film = $movieData['data'];

$movie_id = $film['cinema']['movie_id'];

// hier sluit hij de api aanvraag
curl_close($ch, );

//  hier start hij de api aanvraag 2
$ch2 = curl_init($gluApiUrl . "/api/movie/{$movie_id}/dates");

// hier zet hij de api key in de http headers
curl_setopt($ch2, CURLOPT_HTTPHEADER, [
    "X-API-KEY: " . $gluApikey,
    "Content-Type: application/json"
]);
curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch2, CURLOPT_FOLLOWLOCATION, true);

// hier kijk of de api goed aangevraagd is
$response2 = curl_exec($ch2);

// hier checkt hij of er een error is anders stopt hij de code
if (curl_errno($ch2)) {
    exit("Er is een fout opgetreden met de api.");
}
// hier maakt hij de terugkoppeling van de aanvraag in jason
$movieDatesData = json_decode($response2, true);

// hier checkt hij de database error en stopt de code bij error
if ($movieDatesData['status'] !== 'success') {
    exit("Er is een fout opgetreden met de api.");
}
// hier pakt hij de film data als alles goed is
$dates = $movieDatesData['data'];


// hier sluit hij de api aanvraag 
curl_close($ch2, );

// aanvraag tijden voor films
$chTimes = curl_init($gluApiUrl . "/api/movie/{$movie_id}/{$selectedDate}/times");
curl_setopt($chTimes, CURLOPT_HTTPHEADER, [
    "X-API-KEY: " . $gluApikey,
    "Content-Type: application/json"
]);
curl_setopt($chTimes, CURLOPT_RETURNTRANSFER, true);
$responseTimes = curl_exec($chTimes);
curl_close($chTimes);

$timesData = json_decode($responseTimes, true);

if ($timesData['status'] === 'success') {
    $times = $timesData['data']; // array van tijden voor die datum
}



/* =====================================================
   INSTELBARE WAARDEN
   ===================================================== */

// Simuleer dat je 1 voorstelling hebt gekozen (later dynamisch maken)
$movie_screening_id = (int) ($_GET['id'] ?? 0); // id van de filmvertoning

// Ticketprijzen
$PRIJS_NORMAAL = 9.00;
$PRIJS_KIND = 5.00;
$PRIJS_65 = 7.00;

/* =====================================================
   VERVANGT OUDE SESSIE-CODE: bezette stoelen laden
   ===================================================== */

// HIER komt jouw $stmt = $pdo->prepare(...) blok
try {
    $stmt = $conn->prepare("
      SELECT tc.row_number, tc.seat_number
      FROM tickets AS tc JOIN orders AS od ON tc.order_id = od.order_id
      WHERE tc.movie_screening_id = :msid AND tc.status = 'valid';
    ");
    $stmt->execute([':msid' => $movie_screening_id]);

    $bezetStoelen = [];
    foreach ($stmt->fetchAll() as $row) {
        $bezetStoelen[] = 'stoel_' . $row['row_number'] . '_' . $row['seat_number'];
    }

} catch (Throwable $e) {
    die('Kon bezette stoelen niet laden: ' . htmlspecialchars($e->getMessage()));
}

/* =====================================================
   FORM VERWERKING (POST)
   ===================================================== */

$errors = [];
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voornaam = htmlspecialchars(trim($_POST['voornaam'] ?? ''));
    $achternaam = htmlspecialchars(trim($_POST['achternaam'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);

    $gekozenStoelen = isset($_POST['stoelen']) && is_array($_POST['stoelen']) ? $_POST['stoelen'] : [];

    $aantal_normaal = max(0, min(10, (int) ($_POST['aantal_normaal'] ?? 0)));
    $aantal_kind = max(0, min(10, (int) ($_POST['aantal_kind'] ?? 0)));
    $aantal_65 = max(0, min(10, (int) ($_POST['aantal_65'] ?? 0)));

    if (($aantal_normaal + $aantal_kind + $aantal_65) < 1) {
        $errors[] = "Selecteer minimaal 1 ticket.";
    }
    if (!$voornaam)
        $errors[] = "Voornaam is verplicht.";
    if (!$achternaam)
        $errors[] = "Achternaam is verplicht.";
    if (!$email)
        $errors[] = "Ongeldig e-mailadres.";
    if (count($gekozenStoelen) < 1)
        $errors[] = "Selecteer minimaal 1 stoel.";

    foreach ($gekozenStoelen as $uiId) {
        if (in_array($uiId, $bezetStoelen, true)) {
            $errors[] = "Stoel $uiId is al bezet.";
        }
    }

    if (empty($errors)) {
        $totaal = $aantal_normaal * $PRIJS_NORMAAL
            + $aantal_kind * $PRIJS_KIND
            + $aantal_65 * $PRIJS_65;

        try {
            $conn->beginTransaction();

            // Customer opslaan/zoeken
            $q = $conn->prepare("SELECT customer_id FROM customers WHERE email = :e LIMIT 1");
            $q->execute([':e' => $email]);
            $row = $q->fetch();
            if ($row) {
                $customer_id = (int) $row['customer_id'];
            } else {
                $ins = $conn->prepare("INSERT INTO customers (email, first_name, last_name) VALUES (:e,:f,:l)");
                $ins->execute([':e' => $email, ':f' => $voornaam, ':l' => $achternaam]);

                $customer_id = (int) $conn->lastInsertId();
            }

            // Order maken
            $o = $conn->prepare("
                INSERT INTO orders (customer_id, total_amount, status)
                VALUES (:cid, :tot, 'paid')
            ");
            $o->execute([
                ':cid' => $customer_id,
                ':tot' => $totaal
            ]);
            $order_id = (int) $conn->lastInsertId();

            // Tickets maken (let op: we slaan row_label en seat_number direct op in tickets)
            foreach ($gekozenStoelen as $uiId) {
                [$prefix, $rowLabel, $seatNumber] = explode('_', $uiId);

                $prijs = $PRIJS_NORMAAL;

                $checkIfSeatIsAvailable = $conn->prepare("
                    SELECT COUNT(*) AS cnt, movie_screening_id FROM tickets AS tc
                    JOIN orders AS od ON tc.order_id = od.order_id
                    WHERE tc.movie_screening_id = :msid
                      AND tc.row_number = :r AND tc.seat_number = :n
                      AND tc.status = 'valid'
                ");
                $checkIfSeatIsAvailable->execute([
                    ':msid' => $movie_screening_id,
                    ':r' => $rowLabel,
                    ':n' => $seatNumber
                ]);
                $countRow = $checkIfSeatIsAvailable->fetch();

                if ($countRow && $countRow['cnt'] > 0) {
                    exit("Een stoel die je koos is net bezet geraakt. Probeer het opnieuw.");
                }

                $t = $conn->prepare("
                    INSERT INTO tickets (order_id, row_number, seat_number, price, status, auditorium_number, movie_screening_id)
                    VALUES (:od, :row, :num, :pr, 'valid',1,1 )
                ");
                $t->execute([
                    ':od' => $order_id,
                    ':row' => $rowLabel,
                    ':num' => $seatNumber,
                    ':pr' => $prijs
                ]);
            }

            $conn->commit();
            $success = "Bestelling succesvol! Order #$order_id is aangemaakt.";
            header("Location: " . $_SERVER['REQUEST_URI']);
            exit;

        } catch (Throwable $t) {
            // $conn->rollBack();
            $errors[] = "Er ging iets mis: " . htmlspecialchars($t->getMessage());
        }
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
    <div class="ticket-container">

        <div class="top-bars">
            <p><?php echo htmlspecialchars($film['movie']['title']); ?></p>
            <select name="dates" id="movieDates">
                <?php foreach ($dates as $date): ?>
                    <option value="<?php echo htmlspecialchars($date['date']); ?>">
                        <?php echo htmlspecialchars($date['date']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <select name="times" id="movieTimes">
                <option value="">Kies een tijd</option>
            </select>
        </div>



        <div class="backgroundform">
            <div class="koptekst">TICKETS BESTELLEN</div>

            <?php foreach ($errors as $e): ?>
                <p style="color:red; margin-left:32px;"><?php echo htmlspecialchars($e); ?></p>
            <?php endforeach; ?>
            <?php if ($success): ?>
                <p style="color:green; margin-left:32px;"><?php echo htmlspecialchars($success); ?></p>
            <?php endif; ?>

            <form method="post">
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
                            <td><input type="number" name="aantal_normaal" min="0" max="10"
                                    value="<?php echo isset($aantal_normaal) ? (int) $aantal_normaal : 0; ?>"></td>
                        </tr>
                        <tr>
                            <td>Kind</td>
                            <td>€5,00</td>
                            <td><input type="number" name="aantal_kind" min="0" max="10"
                                    value="<?php echo isset($aantal_kind) ? (int) $aantal_kind : 0; ?>">
                            </td>
                        </tr>
                        <tr>
                            <td>65+</td>
                            <td>€7,00</td>
                            <td><input type="number" name="aantal_65" min="0" max="10"
                                    value="<?php echo isset($aantal_65) ? (int) $aantal_65 : 0; ?>"></td>
                        </tr>
                        <tr>
                            <td colspan="3" style="text-align:left; padding-top:12px;">
                                <label for="voucher">Vouchercode:</label>
                                <input type="text" name="voucher" id="voucher" maxlength="32" autocomplete="off">
                                <button type="submit" name="voucher_toevoegen" value="1" style="margin-left:8px;">Voeg
                                    toe</button>
                            </td>
                        </tr>
                    </table>
                </div>

                <div class="stap">
                    <h2>STAP 2: KIES JE STOEL</h2>
                    <div class="stoelen">
                        <div>FILMDOEK</div>
                        <?php
                        for ($rij = 1; $rij <= 8; $rij++) {
                            echo '<div class="stoel-rij">';
                            for ($stoel = 1; $stoel <= 12; $stoel++) {
                                $id = "stoel_{$rij}_{$stoel}";
                                $disabled = in_array($id, $bezetStoelen) ? 'disabled' : '';
                                echo '<label class="stoel">';
                                echo "<input type='checkbox' name='stoelen[]' value='$id' $disabled>";
                                echo '<span></span>';
                                echo '</label>';
                            }
                            echo '</div>';
                        }
                        ?>
                    </div>
                </div>

                <div class="stap">
                    <h2>STAP 3: CONTROLEER JE BESTELLING</h2>
                    <div class="bestelling-overzicht">
                        <div class="bestelling-poster">
                            <img src="https://image.tmdb.org/t/p/w500<?php echo $film['movie']['poster_path']; ?>"
                                alt="Poster">
                        </div>

                        <div class="bestelling-info">
                            <h3><?php echo $film['movie']['title']; ?></h3>

                            <div class="bestelling-icons">
                                <!-- hier komen jouw icoontjes dynamisch -->
                                <img src="icons/12.png" alt="Leeftijd 12+">
                                <img src="icons/action.png" alt="Actie">
                                <img src="icons/adventure.png" alt="Avontuur">
                            </div>

                            <p>Bioscoop: Hellevoetsluit (Zaal <?php echo $film['cinema']['auditorium_number']; ?>)</p>
                            <p>Wanneer: <?php echo $film['cinema']['start_time']; ?></p>

                            <?php if ($totaalAantal > 0): ?>
                                <p>Tickets:
                                    <?php echo $aantal_normaal . "x normaal, " . $aantal_kind . "x kind, " . $aantal_65 . "x 65+"; ?>
                                </p>
                                <p class="bestelling-totaal">Totaal <?php echo $totaalAantal; ?> ticket(s):
                                    €<?php echo number_format($totaal, 2, ',', '.'); ?></p>
                            <?php else: ?>
                                <p>Nog geen kaartjes</p>
                            <?php endif; ?>
                        </div>
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
                    <label><input type="radio" name="betaalwijze" value="ideal" required><img
                            src="photos/ideal.png"></label><br>
                    <label><input type="radio" name="betaalwijze" value="meastro"><img
                            src="photos/maestro.png"></label><br>
                    <label><input type="radio" name="betaalwijze" value="biosbon"><img src="photos/nbb.png"></label><br>
                </div>

                <div class="stap">
                    <label>
                        <input type="checkbox" name="akkoord" required>
                        Ik ga akkoord met de <a href="/algemene-voorwaarden.pdf" target="_blank">algemene
                            voorwaarden</a>
                    </label>
                </div>
                <button class="afrekenen" type="submit">AFREKENEN</button>
            </form>
        </div>

        <div class="Mini-sideposter">
            <img src="https://image.tmdb.org/t/p/w500<?php echo $film['movie']['poster_path']; ?>" alt="Poster">
            <p><?php echo $film['movie']['title']; ?></p>
            //rating//
            <p><?php echo $film['movie']['release_date']; ?></p>
            <p><?php echo $film['movie']['overview']; ?></p>
        </div>
    </div>
</body>

<?php include '../includes/footer.php'; ?>