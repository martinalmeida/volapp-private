// --Se ejecuta la cargar toda la pagina--
$(document).ready(function () {
  renderInterfaz();
});

// --Funcion de renderizar contenido--
function renderInterfaz() {
  var html = "";
  html =
    '<h1 class="page-error color-fusion-500">' +
    'ERROR <span class="text-gradient">404</span>' +
    '<small class="fw-500">URL no encontrada</small></h1>' +
    '<h3 class="fw-500 mb-5">Ha experimentado un error técnico. Pedimos disculpas.</h3>' +
    "<h4>Estamos trabajando arduamente para corregir este problema. Espere unos momentos y vuelva a intentar la búsqueda.</h4>";
  $("#workSpace").html(html);
}
