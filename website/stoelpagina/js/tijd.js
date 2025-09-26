const selector = document.getElementById("movieDates");
selector.addEventListener("input", (e) => {
    let url = window.location.href;
    if (url.indexOf('?') === -1) {
        url += '&date=' + e.target.value;
    } else if (url.indexOf('date') !== -1) {
        url = url.replace(/(date=)[^\&]+/, '$1' + e.target.value);
    } else {
        url += '&date=' + e.target.value;
    }
    window.location.href = url;
});

document.addEventListener("DOMContentLoaded", () => {
    const PRIJS_NORMAAL = 9.00;
    const PRIJS_KIND = 5.00;
    const PRIJS_65 = 7.00;

    const inputNormaal = document.querySelector("input[name='aantal_normaal']");
    const inputKind = document.querySelector("input[name='aantal_kind']");
    const input65 = document.querySelector("input[name='aantal_65']");
    const ticketsOverzicht = document.getElementById("tickets-overzicht");
    const totaalOverzicht = document.getElementById("totaal-overzicht");

    const dateSelect = document.getElementById("movieDates");
    const timeSelect = document.getElementById("movieTimes");
    const tijdOverzicht = document.getElementById("overzicht-tijd");

    function updateOverzicht() {
        const normaal = parseInt(inputNormaal.value) || 0;
        const kind = parseInt(inputKind.value) || 0;
        const senior = parseInt(input65.value) || 0;

        const totaalAantal = normaal + kind + senior;
        const totaal = (normaal * PRIJS_NORMAAL) + (kind * PRIJS_KIND) + (senior * PRIJS_65);

        if (totaalAantal > 0) {
            ticketsOverzicht.textContent = `${normaal}x normaal, ${kind}x kind, ${senior}x 65+`;
            totaalOverzicht.textContent = `Totaal ${totaalAantal} ticket(s): €${totaal.toFixed(2).replace('.', ',')}`;
        } else {
            ticketsOverzicht.textContent = "Nog geen kaartjes";
            totaalOverzicht.textContent = "";
        }
    }

    // Event listeners
    [inputNormaal, inputKind, input65].forEach(inp => {
        inp.addEventListener("input", updateOverzicht);
    });

    dateSelect.addEventListener("change", () => {
        // Je zou hier ook AJAX kunnen doen om nieuwe tijden op te halen
        updateOverzicht();
    });

    timeSelect.addEventListener("change", () => {
        tijdOverzicht.textContent = timeSelect.value;
    });

    // Initieel invullen
    updateOverzicht();
});

const seatInputs = document.querySelectorAll("input[name='stoelen[]']");
seatInputs.forEach(chk => {
    chk.addEventListener("change", () => {
        const geselecteerd = [...seatInputs].filter(c => c.checked).length;
        // Bijvoorbeeld tonen in het overzicht:
        if (geselecteerd > 0) {
            ticketsOverzicht.textContent += ` (Stoelen: ${geselecteerd})`;
        }
    });
});

document.addEventListener("DOMContentLoaded", () => {
    const dateSelect = document.getElementById("movieDates");
    const timeSelect = document.getElementById("movieTimes");
    const datumOverzicht = document.getElementById("overzicht-datum");
    const tijdOverzicht = document.getElementById("overzicht-tijd");

    // Update overzicht bij wijziging
    dateSelect.addEventListener("change", () => {
        datumOverzicht.textContent = dateSelect.value;
    });

    timeSelect.addEventListener("change", () => {
        tijdOverzicht.textContent = timeSelect.value;
    });

    // Initieel zetten (voor als er al een geselecteerde optie is)
    if (dateSelect.value) datumOverzicht.textContent = dateSelect.value;
    if (timeSelect.value) tijdOverzicht.textContent = timeSelect.value;
});

