const selector = document.getElementById("movieDates");
selector.addEventListener("input", (e) => {
    let url = window.location.href;
    if (url.indexOf('?') === -1){
        url += '&date=' + e.target.value;
    } else if(url.indexOf('date') !== -1) {
        url = url.replace(/(date=)[^\&]+/, '$1' + e.target.value);
    } else {
        url += '&date=' + e.target.value;
    }
    window.location.href = url;
});

