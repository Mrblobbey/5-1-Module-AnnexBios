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
<br><br>
<div class="filmtitle">
    <h2><?php echo $film['titel'] ?></h2>
</div>
<div class="film_container">
    <div class="filmimage">
    <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>">
    </div>
    <div class="filminfo">
        <p><?php echo $film['beschrijving']; ?></p>
        <!-- <p><strong>Tijd:</strong> <?php echo $film['tijd']; ?></p> -->
    
    </div>
    
    </div><br><br><br><br><br><br>

    
    
    
    
    
    
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
include '../includes/footer.php';
?>
</body>
</html>























<!-- <?php

foreach ($films as $index => $film) {
    echo "<h2>{$film['titel']}</h2>";
    echo "<a href='details.php?id={$index}'>Bekijk details</a><br><br>";
}

?> -->




<!-- <?php foreach ($films as $film): ?>
<div class="film_card">
        <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>" class="film_afbeelding">
        <h3><?php echo $film['titel']; ?></h3>
        <p><?php echo $film['beschrijving']; ?></p>
        <p>Tijd: <?php echo $film['tijd']; ?></p>
        <div class="button">
        <a href="stoelenpagina.php">MEER INFO EN TICKETS</a>
        </div>
    </div><br>
<?php endforeach; ?> -->