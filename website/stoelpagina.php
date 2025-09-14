<?php
include 'includes/header.php';
?>

<div class="background">
    <div class="koptekst">TICKETS BESTELLEN</div>
    <br><br>
    <div class="dropdown-row">
        <select name="film" id="film" class="styled-select">
            <option selected>JURASSIC WORLD</option>
            <!-- Meer films -->
        </select>
        <select name="datum" id="datum" class="styled-select">
            <option selected>DATUM</option>
            <option value="2025-09-12">12 september 2025</option>
            <!-- Meer datums -->
        </select>
        <select name="tijd" id="tijd" class="styled-select">
            <option selected>TIJDSTIP</option>
            <option value="20:00">20:00</option>
            <!-- Meer tijdstippen -->
        </select>
    </div>
    <br>
    <div class="stap">
        <h2>STAP 1: KIES JE TICKET</h2>
        <table>
            <tr>
                <th>TYPE</th>
                <th>PRIJS</th>
                <th>AANTAL</th>
            </tr>
            <tr>
                <td>Normaal</td>
                <td>€9,00</td>
                <td><input type="number" min="0" value="0"></td>
            </tr>
            <tr>
                <td>Kind t/m 11 jaar</td>
                <td>€5,00</td>
                <td><input type="number" min="0" value="0"></td>
            </tr>
            <tr>
                <td>65 +</td>
                <td>€7,00</td>
                <td><input type="number" min="0" value="0"></td>
            </tr>
        </table>
        <input type="text" placeholder="VOUCHERCODE">
        <button type="button">TOEVOEGEN</button>
    </div>
    <br>
    <div class="stap">
        <h2>STAP 2: KIES JE STOEL</h2>
        <div class="stoelen">
            <!-- Stoelen layout hier -->
            <div>FILMDOEK</div>
            <?php
            // 8 rijen, 12 stoelen per rij
            for ($rij = 1; $rij <= 8; $rij++) {
                echo '<div class="stoel-rij">';
                for ($stoel = 1; $stoel <= 12; $stoel++) {
                    $id = "stoel_" . $rij . "_" . $stoel;
                    // Voorbeeld: rolstoelplaatsen op rij 8, stoel 1 en 2
                    $extraClass = '';
                    if ($rij == 8 && ($stoel == 1 || $stoel == 2)) {
                        $extraClass = ' rolstoel';
                    }
                    echo '<label class="stoel' . $extraClass . '">';
                    echo '<input type="checkbox" name="stoelen[]" value="' . $id . '" id="' . $id . '">';
                    echo '<span></span>';
                    echo '</label>';
                }
                echo '</div>';
            }
            ?>
        </div>
        <div>
            <button>VRIJ</button>
            <button>BEZET</button>
            <button>JOUW SELECTIE</button>
        </div>
    </div>
    <br>
    <div class="stap">
        <h2>STAP 3: CONTROLEER JE BESTELLING</h2>
        <div class="bestelling">
            <!-- Bestelling info hier -->
        </div>
    </div>
    <br>
    <div class="stap">
        <h2>STAP 4: VUL JE GEGEVENS IN</h2>
        <input type="text" placeholder="Voornaam">
        <input type="text" placeholder="Achternaam">
        <input type="email" placeholder="E-mailadres">
        <input type="email" placeholder="E-mailadres (herhalen)">
    </div>
    <br>
    <div class="stap">
        <h2>STAP 5: KIES JE BETAALWIJZE</h2>
        <div class="betaalwijzen">
            <!-- Betaalwijze iconen hier -->
        </div>
        <label>
            <input type="checkbox"> Ik ga akkoord met de algemene voorwaarden
        </label>
    </div>
    <br>
    <button class="afrekenen">AFREKENEN</button>
</div>