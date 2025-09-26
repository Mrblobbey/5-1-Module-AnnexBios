

<?php
if (!isset($_GET['id'])) {
    die("Film niet gevonden!");
}

$ch = curl_init("https://u240066.gluwebsite.nl/api/movie/" . $_GET['id']);
 
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "X-API-KEY: RzQPNjAVYzZRZspZsXrDjhsjFzG69KogrHB8Pkew",
    "Content-Type: application/json"
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
 
$response = curl_exec($ch);
 
if (curl_errno($ch)) {
    exit("Er is iets misgegaan met de API");
}
 
$data = json_decode($response, true);
 
if($data['status'] !== "success") {
    exit("Er is iets misgegaan met de API");
}
 
$movieData = $data['data'];
 
curl_close($ch);
            ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $movieData['movie']['title']; ?></title>
    </head>
    <body>
        <div class="background"></div>
<div class="container">
        <?php
            include '../includes/header.php';
        ?>
<div class="dettail_pagina_container">
<div class="filmtitle">
    <h2><?php echo $movieData['movie']['title'] ?></h2>
</div>

<div class="film_container">

        <img class="filmimage" src="https://image.tmdb.org/t/p/w500<?php echo $movieData['movie']['poster_path']; ?>" alt="<?php echo $movieData['movie']['title']; ?>">
    <div class="beschrijving">

        <div class="stars">
                <?php
                $rating = (float)explode('/', $movieData['movie']['vote_average']);
                $stars = round($rating / 2); // Convert to 1-5 scale
                            
                for ($i = 1; $i <= 5; $i++) {
                    if ($i <= $stars) {
                       echo '★';
                   } else {
                       echo '☆';
                    }
                    }
                    ?>
                </div>
 

        <div class="icons">



        </div>

        <div class="release-date">
            <h2><strong>Release Date:</strong> <?php echo $movieData['movie']['release_date']; ?></h2>
        </div>

        <p><?php echo $movieData['movie']['overview']; ?></p>

        <div class="filminfo">

            <p class="film-info-text">Genre: <?php echo $movieData['movie']['genres'][0]['name']; ?></p>
            <p class="film-info-text">Filmlengte: <?php echo $movieData['movie']['runtime']; ?> minuten</p>
            <p class="film-info-text">Land: <?php echo $movieData['movie']['production_countries'][0]['name']; ?></p>
            <p class="film-info-text">LMDB Score: <?php echo $movieData['movie']['vote_average']; ?></p>
            <p class="film-info-text">Regisseur: <?php echo $movieData['movie']['directors'][0]['name']; ?></p>
            <p class="film-info-text">Acteurs:

        </div>
        
<div class="cast-container">

    <?php 
    for ($i = 0; $i < count($movieData['movie']['actors']); $i++) {
        ?>
        <div class="column">
        <img src="https://image.tmdb.org/t/p/w500<?php echo $movieData['movie']['cast']['profile_path']; ?>">
        <p><?php echo $movieData['movie']['cast'][$i]['name']; ?></p>
        </div>
        <?php
    }
    ?>
</div>

        
    </div>
</div>

  

    <a href="../tickets/tickets.php?id=<?php echo $movieData['movie']['id']; ?>" class="koop_tickets">
        <p>Koop je Tickets</p>
    </a>
    

        <iframe class="video" src="<?php echo $movieData['movie']['trailer_url']; ?>"></iframe>

    </div>


    
    <?php
include '../includes/footer.php';
?>
</body>
</html>

