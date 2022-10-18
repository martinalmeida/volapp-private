// --Variables globales para los timer de desconexion 900000 15 minutos
var contadorCerrarSesion;
var contadorSeguirConectado;
var tiempoMaximo = 900000;
var tiempoEspera = 30000;
var tiempoMaximoCierreSesion = tiempoMaximo + tiempoEspera;

// --Se ejecuta la cargar toda la pagina--
$(document).ready(function () {
  Swal.close();
});

// --Funcion de inicio de Sesión--
function login(form) {
  var respuestavalidacion = validarcampos("#" + form);
  if (respuestavalidacion) {
    $("#btnLoginIngresar").prop("disabled", true);
    var formData = new FormData(document.getElementById(form)); //Datos del formulario
    formData.append(
      "token",
      "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9"
    );
    $.ajax({
      cache: false, //necesario para enviar archivos
      contentType: false, //necesario para enviar archivos
      processData: false, //necesario para enviar archivos
      data: formData, //necesario para enviar archivos
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "routes/login/getUser", //url a donde hacemos la peticion
      type: "POST",
      beforeSend: function () {
        var html = "";
        html +=
          '<div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div>';

        $("#spinnerLogin").html(html);
      },
      complete: function () {
        // $("#spinnerLogin").html("");
      },
      success: function (result) {
        $("#btnLoginIngresar").prop("disabled", false);
        var estado = result.status;

        switch (estado) {
          case "0":
            Swal.fire({
              icon: "error",
              title: "<strong>Error en el servidor</strong>",
              html: "<h5>Se ha presentado un error al intentar consultar la información.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#spinnerLogin").html("");
            break;

          case "1":
            if (result.url != "") {
              window.location = urlBase + result.url;
            }
            break;

          case "2":
            Swal.fire({
              icon: "error",
              title: "<strong>Error de Validacón</strong>",
              html: "<h5>Se ha presentado un error al intentar validar la información.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#spinnerLogin").html("");
            break;

          case "3":
            Swal.fire({
              icon: "info",
              title: "<strong>Credenciales Incorrectas</strong>",
              html: "<h5>Las credenciales son incorrectas o el usuario se encuantra inactivo.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#spinnerLogin").html("");
            break;

          default:
            break;
        }
      },
      error: function (xhr) {
        $("#btnLoginIngresar").prop("disabled", false);
      },
    });
  }
}

// --Funcion de cerrar Sesión--
function cerrarSesion() {
  $.ajax({
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/login/logout", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      // $("#overlayText").text("Cerrando Sesión...");
      // $(".overlayCargue").fadeOut("slow");
    },
    complete: function () {
      // $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "1":
          window.location.replace(urlBase);
          break;
      }
    },
    error: function (xhr) {
      console.log(xhr);
    },
  });
}
