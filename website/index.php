<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>AnnexBios - Home</title>
    <link rel="stylesheet" href="/5-1-Module-AnnexBios/website/css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
</head>
<body>
    <div class="background"></div>
    <div class="container">
    <?php
    require_once 'includes/header.php';
    require_once 'includes/film_array.php';
    ?>
    <main>
        <section class="welkom">
            <div class="inhoud-container">
                <h1>WELKOM BIJ ANNEXBIOS</h1>
                <p class="welcome-text">Geniet van de nieuwste films in onze gezellige bioscoop</p>
                <a href="films.php">BEKIJK DE DRAAIENDE FILMS</a>
            </div>
        </section>
    </main>

    <section class="location-section">
        <div class="inhoud-container">
            <div class="location-grid">
                <div class="map-container">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2465.390030230544!2d4.1302237771906105!3d51.83557227188992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c451c6f4434d53%3A0x20bb4b6bcdd57904!2sRijksstraatweg%2042%2C%203223%20KA%20Hellevoetsluis!5e0!3m2!1sen!2snl!4v1757508034573!5m2!1sen!2snl" 
                        width="100%" 
                        height="450" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        referrerpolicy="no-referrer-when-downgrade"
                        title="AnnexBios Location">
                    </iframe>
                </div>
                <div class="contact-info">
                    <h2>Bezoek Ons</h2>
                    <address class="address-info">
                        <p class="address-line">Rijksstraatweg 42</p>
                        <p class="address-line">3223 KA Hellevoetsluis</p>
                        <p class="phone"><a href="tel:02012345678">020-12345678</a></p>
                    </address>
                    
                    <div class="accessibility">
                        <h3>BEREIKBAARHEID</h3>
                        <p>Onze bioscoop is uitstekend bereikbaar met zowel het openbaar vervoer als met de auto. Er is voldoende parkeergelegenheid in de buurt.</p>
                    </div>
    
                    <img src="photos/film.png" alt="Filmicoon" class="img_film">
                </div>
            </div>
        </div>
    </section>
                
    <section class="filmagenda">
        <h2>FILM AGENDA</h2>

        <div class="filters">
    <!-- icon button -->
    <button class="icon-btn">
      <img src="img/agenda.png" alt="Agenda icoon">
    </button>

    <!-- regular buttons -->
    <button>FILMS</button>
    <button>DEZE WEEK</button>
    <button>VANDAAG</button>

      <!-- dropdown -->
        <select>
            <option value="" selected disabled>CATEGORIE</option>
            <option value="all">Alle films</option>
            <option value="new">Nieuwe films</option>
            <option value="soon">Binnenkort</option>
        </select>
        </div>
    </section>

<div class="film_container">
    <?php foreach ($films as $film): ?>
        <div class="film_card">
            <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>" class="film_afbeelding">
            <h3><?php echo $film['titel']; ?></h3>
            <p><?php echo $film['beschrijving']; ?></p>
            <p>Tijd: <?php echo $film['tijd']; ?></p>
            <div class="button">
            <a href="filmagenda.php">MEER INFO EN TICKETS</a>
            </div>
        </div><br>
        <?php endforeach; ?>
    </div>
    </div>
    </section>
    </div>
</main>
<?php require_once 'includes/footer.php'; ?> 