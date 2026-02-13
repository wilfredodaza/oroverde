function renderMapIfPresent() {
  const mapEl = document.getElementById("map");
  if (!mapEl) return; // si no hay mapa en esta vista, no hagas nada

  // espera a que google exista (API ya cargó)
  if (!window.google || !google.maps) {
    setTimeout(renderMapIfPresent, 200);
    return;
  }

  const contact = typeof getContact === "function" ? getContact() : null;

  let miUbicacion = { lat: 4.60971, lng: -74.08175 };
  if (contact?.description?.includes(";")) {
    const [lat, lng] = contact.description.split(";").map(Number);
    if (!Number.isNaN(lat) && !Number.isNaN(lng)) miUbicacion = { lat, lng };
  }

  const map = new google.maps.Map(mapEl, { zoom: 14, center: miUbicacion });
  new google.maps.Marker({ position: miUbicacion, map });
}

// cuando carga la página
window.addEventListener("load", renderMapIfPresent);