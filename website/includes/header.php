<?php

$mainPath = isset($mainPath) ? $mainPath : '../';
require $mainPath . 'includes/config.php';

//  hier start hij de api aanvraag 
$ch = curl_init($gluApiUrl . "/api/movies");

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
$films = $movieData['data'];

// hier sluit hij de api aanvraag 
curl_close($ch);
?>

<div class="header-container">
    <div class="header" role="banner">
        <a href="index.php" class="logo" aria-label="AnnexBios Home">
            <img id="popcorn-img" src="Photos/popcorn.svg" alt="" aria-hidden="true">
            <div class="logo-content">
                <h1>AnnexBios | Maarssen</h1>
            </div>
            <img id="filmroll-img" src="Photos/filmroll_logo.svg" alt="" aria-hidden="true">
        </a>
        
        <nav class="main-nav" aria-label="Hoofdnavigatie">
            <ul>
                <li><a href="filmagenda.php">Film agenda</a></li>
                <li><a href="allevestingen.php">Alle vestigingen</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>    
<div class="nav2">
    <!-- Formulier om tickets te kopen -->
    <form action="action_page.php" method="get">
        <label for="browser">Koop je tickets</label>

        <select name="film_id" id="browser">
            <option value="" selected disabled>Kies je film</option>

            <?php
            // We lopen door dezelfde $films array als op index.php
            foreach ($films as $film_item): ?>
                <option value="<?php echo $film_item['id']; ?>">
                    <?php echo htmlspecialchars($film_item['movie']['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="big-white-button" type="submit">Bestel tickets</button>
    </form>
</div>