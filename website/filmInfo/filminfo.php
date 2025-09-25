

<?php
include '../includes/film_array.php';
        
        // check of er een id is meegegeven
        if (isset($_GET['id']) && isset($films[$_GET['id']])) {
            $film = $films[$_GET['id']];
        } else {
            die("Film niet gevonden!");
        }
            ?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <link rel="stylesheet" href="css/style.css">
        <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $film['titel']; ?></title>
    </head>
    <body>
        <div class="background"></div>
<div class="container">
        <?php
            include '../includes/header.php';
        ?>
<div class="dettail_pagina_container">
<div class="filmtitle">
    <h2><?php echo $film['titel'] ?></h2>
</div>

<div class="film_container">

        <img class="filmimage" src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>">
    <div class="beschrijving">

        <div class="stars">
                <?php
                $rating = (float)explode('/', $film['rating'])[0];
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
            <p><strong>Release Date:</strong> <?php echo $film['release-date']; ?></p>
        </div>

        <p><?php echo $film['beschrijving']; ?></p>

        <div class="filminfo">

            <h3 class="film-info-text">Genre: <?php echo $film['genre']; ?></h3>
            <p class="film-info-text">Filmlengte: <?php echo $film['filmlengte']; ?></p>
            <p class="film-info-text">Land: <?php echo $film['land']; ?></p>
            <p class="film-info-text">LMDB Score: <?php echo $film['lmdb score']; ?></p>
            <p class="film-info-text">Regisseur: <?php echo $film['regisseur']; ?></p>
            <p class="film-info-text">Acteurs: 

        </div>
        
<div class="cast-image">

    <?php 
    for ($i = 0; $i < count($film['cast']); $i++) {
        ?>
        <img src="<?php echo $film['cast'][$i]; ?>" class="cast-image">
        <p class="actor-name"><?php echo $film['acteurs'][$i]; ?></p>
        <?php
    }
    ?>
</div>

        <div class="cast-container">
            
            <img src="https://picsum.photos/200/150?random=2" alt="Random image 2">
            <p>Some text under image 2</p>

        </div>
    </div>
</div>

  

    <a href="../tickets/tickets.php?id=<?php echo $film['id']; ?>" class="koop_tickets">
        <p>Koop je Tickets</p>
    </a>
    

        <iframe class="video" src="<?php echo $film['video']; ?>"></iframe>

    </div>


    
    <?php
include '../includes/footer.php';
?>
</body>
</html>

