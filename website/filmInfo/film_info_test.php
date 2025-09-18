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
        <?php
            include '../includes/header.php';
            ?>
<br> <br> <br> <br>

<div class="filminfo_h2">

    <h1><?php echo $film['titel']; ?></h1>
    <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>" width="300">
    <p><strong>Tijd:</strong> <?php echo $film['tijd']; ?></p>
    <p><?php echo $film['beschrijving']; ?></p>

</div>


<div class="film_container">
    
    
    </div><br><br><br><br><br><br>
    <div class="button">
        <a href="filmAgenda/filmagenda.php">BEKIJK ALLE FILMS</a>
    </div>
    
    
    
    
    
    
    <br><br><br><br><br><br><br><br><br><br><br><br>
    <?php
include '../includes/footer.php';
?>
</body>
</html>