<div class="header-container">
    <div class="header" role="banner">
        <a href="index.php" class="logo" aria-label="AnnexBios Home">
            <img id="popcorn-img" src="Photos/popcorn.svg" alt="" aria-hidden="true">
            <div class="logo-content">
                <h1>AnnexBios | Maarssen</h1>
            </div>
            <img id="filmroll-img" src="Photos/filmroll_logo.svg" alt="" aria-hidden="true">
        </a>
        
        <nav class="main-nav" aria-label="Hoofdnavigatie">
            <ul>
                <li><a href="filmagenda.php">Film agenda</a></li>
                <li><a href="allevestingen.php">Alle vestigingen</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </div>    
<div class="nav2">
    <!-- Formulier om tickets te kopen -->
    <form action="action_page.php" method="get">
        <label for="browser">Koop je tickets</label>

        <select name="film_id" id="browser">
            <option value="" selected disabled>Kies je film</option>

            <?php
            // We lopen door dezelfde $films array als op index.php
            foreach ($films as $film): ?>
                <option value="<?php echo $film['id']; ?>">
                    <?php echo htmlspecialchars($film['movie']['title']); ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button class="big-white-button" type="submit">Bestel tickets</button>
    </form>
</div>