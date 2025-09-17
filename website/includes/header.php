    <div class="background">
    </div>
    <div class="container">
        <header class="header">
            <a href="index.php" class="logo">
                <img id="popcorn-img" src="Photos/popcorn.svg" alt="popcorn">
                <div class="logo-content">
                    <h1>AnnexBios | Maarssen</h1>
                </div>
                <img id="filmroll-img" src="Photos/filmroll_logo.svg" alt="">
            </a>
            <nav class="nav">
                <ul>
                    <li><a href="filmagenda.php">film agenda</a></li>
                    <li><a href="allevestingen.php">ALLE VESTINGEN</a></li>
                    <li><a href="contact.php">CONTACT</a></li>
                </ul>
            </nav>
            <div class="nav2">
                <form action="/action_page.php" method="get">
                    <label for="browser">Koop je tickets</label>
                    <select name="browser" id="browser" placeholder="Kies je film">
                        <option value="" selected disabled>Kies je film</option>
                        <option value="jasper">Jasper</option>
                        <option value="rody">Rody</option>
                        <option value="minions">Minions</option>
                        <option value="film">Film</option>
                        <option value="hendrik hogendijk">Hendrik Hogendijk</option>
                    </select>
                    <button class="big-white-button" type="submit">Bestel tickets</button>
                </form>
            </div>
        </header>
