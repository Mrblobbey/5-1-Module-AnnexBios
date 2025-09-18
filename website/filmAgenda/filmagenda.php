<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="../css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="background"></div>
<div class="container">
<?php
    require_once '../includes/header.php';
    require_once '../includes/film_array.php';
    ?>

<section class="filmagenda">
        <h2>FILM AGENDA</h2>

        <div class="filters">
    <!-- icon button -->
    <button class="icon-btn">
      <img src="../photos/agenda.png" alt="Agenda icoon">
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
<?php require_once '../includes/footer.php'; ?> 

</body>
</html>