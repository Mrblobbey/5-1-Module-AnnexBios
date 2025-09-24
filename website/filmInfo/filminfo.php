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
<br> <br> <br> <br>

<div class="filminfo_h2">

    <h1><?php echo $film['titel']; ?></h1>
    <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>" width="300">
    <p><strong>Tijd:</strong> <?php echo $film['tijd']; ?></p>
    <p><?php echo $film['beschrijving']; ?></p>

</div>


<div class="stap">
    
    
    </div><br><br><br><br><br><br>
    <div class="button">
        <a href="filmAgenda/filmagenda.php">BEKIJK ALLE FILMS</a>
<div class="film_container">
    <div class="filmimage">
    <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>">
    </div>
    <div class="filminfo">
        <p><?php echo $film['beschrijving']; ?></p>
        <p><strong>Tijd:</strong> <?php echo $film['tijd']; ?></p>
        <p><strong>Genre:</strong> <?php echo $film['genre']; ?></p>
        <p><strong>Filmlengte:</strong> <?php echo $film['filmlengte']; ?></p>
        <p><strong>Land:</strong> <?php echo $film['land']; ?></p>
        <p><strong>LMDB Score:</strong> <?php echo $film['lmdb score']; ?></p>
        <p><strong>Regisseur:</strong> <?php echo $film['regisseur']; ?></p>
        <p><strong>Acteurs:</strong> <?php echo $film['acteurs']; ?></p>
 
    </div>
    
    </div>
    <a href="../tickets/tickets.php?id=<?php echo $film['id']; ?>" class="koop_tickets">
        <p>Koop je Tickets</p>
    </a>

    <div class="video">
        <iframe width="560" height="315" src="<?php echo $film['video']; ?>"></iframe>
    </div>

    
    <?php
include '../includes/footer.php';
?>
</body>
</html>























