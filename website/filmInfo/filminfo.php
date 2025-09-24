

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

            <?php for ($i = 1; $i <= 5; $i++): ?>
                <span class="star" <?php echo ($i <= $film['rating']) ? 'filled' : ''; ?>">&#9733;</span>
            <?php endfor; ?>
       
        </div>

        <div class="icons">

            <?php for ($i = 1; $i <= $film['rating']; $i++): ?>
                <span class="icon"><?php echo $film['icon']; ?></span>
            <?php endfor; ?>

        </div>

        <div class="release-date">
            <p><strong>Release Date:</strong> <?php echo $film['release-date']; ?></p>
        </div>

        <p><?php echo $film['beschrijving']; ?></p>

        <div class="filminfo">

            <h3><strong>Genre:</strong> <?php echo $film['genre']; ?></h3>
            <p><strong>Tijd:</strong> <?php echo $film['tijd']; ?></p>
            <p><strong>Filmlengte:</strong> <?php echo $film['filmlengte']; ?></p>
            <p><strong>Land:</strong> <?php echo $film['land']; ?></p>
            <p><strong>LMDB Score:</strong> <?php echo $film['lmdb score']; ?></p>
            <p><strong>Regisseur:</strong> <?php echo $film['regisseur']; ?></p>
            <p><strong>Acteurs:</strong> <?php echo $film['acteurs']; ?></p>
 
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























