if (document.querySelector('#mapa')) {
    const lat = -13.69035;
    const lng = -71.64040;
    const zoom = 20;

    var map = L.map('mapa', {
        scrollWheelZoom: false // Deshabilita el zoom con el scroll
    }).setView([lat, lng], zoom);

    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
    }).addTo(map);

    L.marker([lat, lng]).addTo(map)
        .bindPopup(`
            <h2 class="mapa__heading">UGM-ATM</h2>
            <p class="mapa__texto">Municipalidad Distrital de Huaro</p>
        `)
        .openPopup();
}


