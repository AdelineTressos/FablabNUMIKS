if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(showPosition);
} else {
    console.log("La géolocalisation n'est pas supportée par ce navigateur.");
}

function showPosition(position) {
    var latitude = position.coords.latitude;
    var longitude = position.coords.longitude;

    // Utiliser latitude et longitude pour afficher la position sur la carte
}


var map = L.map('map').setView([latitude, longitude], 13);

L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap contributors'
}).addTo(map);

L.marker([latitude, longitude]).addTo(map)
    .bindPopup('Vous êtes ici.')
    .openPopup();