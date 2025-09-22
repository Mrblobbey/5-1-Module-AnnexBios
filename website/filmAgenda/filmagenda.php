<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="./css/style.css">
    <link rel="stylesheet" href="./css/footer.css">
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700;900&display=swap" rel="stylesheet">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Film Agenda - Annex Bioscopen</title>
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
        <button class="filter-icon" aria-label="Filters openen">
            <img src="./photos/filtericon.svg" alt="">
        </button>

        <div class="tabs">
            <button class="active">FILMS</button>
            <button>DEZE WEEK</button>
            <button>VANDAAG</button>
        </div>

        <select>
            <option value="" selected disabled>CATEGORIE</option>
            <option value="all">Alle films</option>
            <option value="new">Nieuwe films</option>
            <option value="soon">Binnenkort</option>
        </select>
    </div>
</section>
<section class="film_container">
        <?php foreach ($films as $film): ?>
            <div class="film_card">
                <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>" class="film_afbeelding">
                <h3><?php echo $film['titel']; ?></h3>
                <p><?php echo $film['beschrijving']; ?></p>
                <p class="tijd">Tijd: <?php echo $film['tijd']; ?></p>
                <div class="button">
                    <a href="#">MEER INFO EN TICKETS</a>
                </div>
            </div>
        <?php endforeach; ?>
</section>

</div>

<?php require_once '../includes/footer.php'; ?>

</body>
</html>