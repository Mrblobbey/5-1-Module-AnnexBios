<?php
include 'includes/header.php';
include 'includes/film_array.php';
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
include 'includes/footer.php';
?>