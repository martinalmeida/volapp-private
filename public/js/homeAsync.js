// --Se ejecuta la cargar toda la pagina--
$(document).ready(function () {
  renderInterfaz();
});

function renderInterfaz() {
  var html = "";
  html =
    '<div class="card mb-g rounded-top">' +
    '<div class="row no-gutters row-grid">' +
    '<div class="col-12">' +
    '<div class="d-flex flex-column align-items-center justify-content-center p-4">' +
    '<img src="img/demo/avatars/avatar-admin-lg.png" class="rounded-circle shadow-2 img-thumbnail" alt="">' +
    '<h5 class="mb-0 fw-700 text-center mt-3">' +
    "Dr. Codex Lantern" +
    '<small class="text-muted mb-0">Toronto, Canada</small>' +
    "</h5>" +
    '<div class="mt-4 text-center demo">' +
    '<a href="javascript:void(0);" class="fs-xl" style="color:#3b5998">' +
    '<i class="fab fa-facebook"></i>' +
    "</a>" +
    '<a href="javascript:void(0);" class="fs-xl" style="color:#38A1F3">' +
    '<i class="fab fa-twitter"></i>' +
    "</a>" +
    '<a href="javascript:void(0);" class="fs-xl" style="color:#db3236">' +
    '<i class="fab fa-google-plus"></i>' +
    "</a>" +
    '<a href="javascript:void(0);" class="fs-xl" style="color:#0077B5">' +
    '<i class="fab fa-linkedin-in"></i>' +
    "</a>" +
    '<a href="javascript:void(0);" class="fs-xl" style="color:#000000">' +
    '<i class="fab fa-reddit-alien"></i>' +
    "</a>" +
    '<a href="javascript:void(0);" class="fs-xl" style="color:#00AFF0">' +
    '<i class="fab fa-skype"></i>' +
    "</a>" +
    '<a href="javascript:void(0);" class="fs-xl" style="color:#0063DC">' +
    '<i class="fab fa-flickr"></i>' +
    "</a>" +
    "</div>" +
    "</div>" +
    "</div>" +
    '<div class="col-6">' +
    '<div class="text-center py-3">' +
    '<h5 class="mb-0 fw-700">' +
    "764" +
    '<small class="text-muted mb-0">Connections</small>' +
    "</h5>" +
    "</div>" +
    "</div>" +
    '<div class="col-6">' +
    '<div class="text-center py-3">' +
    '<h5 class="mb-0 fw-700">' +
    "1,673" +
    '<small class="text-muted mb-0">Followers</small>' +
    "</h5>" +
    "</div>" +
    "</div>" +
    '<div class="col-12">' +
    '<div class="p-3 text-center">' +
    '<a href="javascript:void(0);" class="btn-link font-weight-bold">Follow</a> <span class="text-primary d-inline-block mx-3">&#9679;</span>' +
    '<a href="javascript:void(0);" class="btn-link font-weight-bold">Message</a> <span class="text-primary d-inline-block mx-3">&#9679;</span>' +
    '<a href="javascript:void(0);" class="btn-link font-weight-bold">Connect</a>' +
    "</div>" +
    "</div>" +
    "</div>" +
    "</div>";

  $("#workSpace").html(html);
}
