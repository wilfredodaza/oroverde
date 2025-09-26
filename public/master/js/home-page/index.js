function loadMapa(){
    const miUbicacion = { lat: 4.60971, lng: -74.08175 }; // Bogotá, ejemplo

    const mapa = new google.maps.Map(document.getElementById("map"), {
      zoom: 14,
      center: miUbicacion,
    });

    const marcador = new google.maps.Marker({
      position: miUbicacion,
      map: mapa,
    });
}

window.addEventListener('load', async function () {
    loadMapa();   
})