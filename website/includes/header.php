<?php
// zorgt er voor dat de path linkjes blijven werken dynamis zijn 
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
        <a href="<?php echo $mainPath ?>index.php" class="logo" aria-label="AnnexBios Home">
            <img id="popcorn-img" src="Photos/popcorn.svg" alt="" aria-hidden="true">
            <div class="logo-content">
                <h1>AnnexBios | Maarssen</h1>
            </div>
            <img id="filmroll-img" src="Photos/filmroll_logo.svg" alt="" aria-hidden="true">
        </a>
        <nav class="main-nav" aria-label="Hoofdnavigatie">
            <ul>
                <li><a href="<?php echo $mainPath ?>filmagenda/filmagenda.php">Film agenda</a></li>
                <li><a href="https://u240066.gluwebsite.nl">Alle vestigingen</a></li>
                <li><a href="<?php echo $mainPath ?>index.php#contact-info">Contact</a></li>
            </ul>
        </nav>
    </div>    
<div class="nav2">
 <!-- dit is de kies films tickts dropdown die verbonden is met knop -->
<form action="<?php echo $mainPath ?>stoelpagina/stoelpagina.php" method="get">
  <label for="browser">Koop je tickets</label>

  <!-- noem de naam 'id', want stoelpagina.php leest $_GET['id'] -->
  <select name="id" id="browser" required>
    <option value="" selected disabled>Kies je film</option>
    <?php foreach ($films as $film_item): ?>
      <option value="<?= htmlspecialchars($film_item['id'], ENT_QUOTES) ?>">
        <?= htmlspecialchars($film_item['movie']['title']) ?>
      </option>
    <?php endforeach; ?>
  </select>

  <button class="big-white-button" type="submit">Bestel tickets</button>
</form>
</div>