<?php
include 'includes/header.php';
?>
<br> <br> <br> <br> 

<div class="welkom">
<h2> WELKOM BIJ ANNEXBIOS 2</h2>
<p> Lorem ipsum dolor sit amet, consectetuer<br> 
    adipiscing elit.</p>
</div>

<div class="button_welkom">

<a href="films.php">BEKIJK DE DRAAIENDE FILMS</a>
</div>

<div class="info">
<div class="link_maps">
<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2465.390030230544!2d4.1302237771906105!3d51.83557227188992!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x47c451c6f4434d53%3A0x20bb4b6bcdd57904!2sRijksstraatweg%2042%2C%203223%20KA%20Hellevoetsluis!5e0!3m2!1sen!2snl!4v1757508034573!5m2!1sen!2snl" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
</div>
    Rijksstraatweg 42<br>
    3223 KA Hellevoetsluis<br>
    020-12345678<br>
    BEREIKBAARHEID<br>
    lorem ipsum dolor sit amet, consectetuer
    adipiscing elit. Aenean commodo ligula eget dolor. <br>
    Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes<br>
    
    <img src="img/film.png" alt="" class="img_film">
</div>

<div class="filmagenda"> 
        <h2>FILMAGENDA</h2>
    <div class="categorieen">
        <img src="img/agenda.png" alt="" class="img_agenda">
        <input type="radio" id="start" name="trip-start">FILMS
        <input type="radio" id="start" name="trip-start">DEZE WEEK
        <input type="radio" id="start" name="trip-start">VANDAAG
        <input type="radio" id="start" name="trip-start" placeholder="Zoeken">

            <select name="browser" id="browser">
                <option value="" selected disabled>categorie</option>
                <option value="jasper">Jasper</option>
                <option value="rody">Rody</option>
                <option value="minions">Minions</option>
                <option value="film">Film</option>
                <option value="hendrik hogendijk">Hendrik Hogendijk</option>
            </select>
    </div>
</div>


<div>
    
</div>

<br><br><br><br><br><br><br><br><br><br><br><br>
<?php
$films = [
    [
        'titel' => 'Inception',
        'beschrijving' => 'Een dief die dromen steelt krijgt een laatste kans op verlossing.',
        'tijd' => '19:30',
        'afbeelding' => 'https://m.media-amazon.com/images/M/MV5BMjAxMzY3NjcxNF5BMl5BanBnXkFtZTcwNTI5OTM0Mw@@._V1_FMjpg_UX1000_.jpg',
    ],
    [
        'titel' => 'The Lion King',
        'beschrijving' => 'Het verhaal van Simba, de leeuwenkoning.',
        'tijd' => '17:00',
        'afbeelding' => 'https://play-lh.googleusercontent.com/E4YJiRnNiYlM-PbjVrE2Zdr2d73SWbBTzarMIurgNNdr6c_Bh9IX05-ba6vdNR822EyG',
    ],
    [
        'titel' => 'Avengers: Endgame',
        'beschrijving' => 'De Avengers nemen het op tegen Thanos in een episch slotstuk.',
        'tijd' => '21:00',
        'afbeelding' => 'https://m.media-amazon.com/images/I/81ExhpBEbHL._AC_SY679_.jpg',
    ],
];
?>
<div class="film_container">
    <?php foreach ($films as $film): ?>
        <div class="film_card">
            <img src="<?php echo $film['afbeelding']; ?>" alt="<?php echo $film['titel']; ?>" class="film_afbeelding">
            <h3><?php echo $film['titel']; ?></h3>
            <p><?php echo $film['beschrijving']; ?></p>
            <p>Tijd: <?php echo $film['tijd']; ?></p>
            <button class="button">Koop Tickets</button>
        </div>
        <?php endforeach; ?>
    </div>
    <div class="button">
    <a href="filmagenda.php">BEKIJK ALLE FILMS</a>
    </div>
    <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br> <br>
    <?php
include 'includes/footer.php';
?>