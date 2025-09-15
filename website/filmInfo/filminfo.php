<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<?php
include '../includes/header.php';
include '../includes/film_array.php';
?>

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
</div><br>
    <div class="button">
    <a href="filmagenda.php">BEKIJK ALLE FILMS</a>
    </div>






<br><br><br><br><br><br><br><br><br><br><br><br>
<?php
include '../includes/footer.php';
?>
</body>
</html>