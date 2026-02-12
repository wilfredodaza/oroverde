function loadMapa(){

    const contact = getContact();

    let miUbicacion = { lat: 4.60971, lng: -74.08175 }; // Valor por defecto (Bogotá)

    if (contact?.description?.includes(";")) {
      const [lat, lng] = contact.description.split(";").map(Number);
      miUbicacion = { lat, lng }; // Sobrescribe si hay coordenadas válidas
    }

    const mapa = new google.maps.Map(document.getElementById("map"), {
      zoom: 14,
      center: miUbicacion,
    });

}

window.initMap = function () {

    const contact = getContact();

    let miUbicacion = { lat: 4.60971, lng: -74.08175 }; // Bogotá default

    if (contact?.description?.includes(";")) {
        const [lat, lng] = contact.description.split(";").map(Number);
        miUbicacion = { lat, lng };
    }

    const mapa = new google.maps.Map(document.getElementById("map"), {
        zoom: 14,
        center: miUbicacion,
    });

    new google.maps.Marker({
        position: miUbicacion,
        map: mapa
    });
};
