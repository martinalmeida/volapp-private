// --URL principal del servidor para peticiones--
var urlPeticion = "http://localhost/volapp/routes/";

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
      url: urlPeticion + "login/getUser", //url a donde hacemos la peticion
      type: "POST",
      beforeSend: function () {
        // $("#overlayText").text("Iniciando Sesion...");
        // $(".overlayCargue").fadeIn("slow");
      },
      complete: function () {
        //$(".overlayCargue").fadeOut("slow");
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
            break;
          case "1":
            if (result.url != "") {
              window.location = result.url;
            } else {
              window.location.replace(urlBase + "Inicio");
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
    data: { peticion: "logout" }, //necesario para enviar archivos
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: "php/controller/controller_login.php", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      $("#overlayText").text("Cerrando Sesión...");
      $(".overlayCargue").fadeOut("slow");
    },
    complete: function () {
      $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "1":
          window.location.replace(urlBase + "Login");
          break;
      }
    },
    error: function (xhr) {
      console.log(xhr);
    },
  });
}

//funcion para preguntar si desea seguir conectado
var seguirConectado = function () {
  var tiempoRestante = 30;
  var contadorRegresivoSeguirConectado = setInterval(function () {
    tiempoRestante -= 1;
    if (tiempoRestante == 0) {
      clearInterval(contadorRegresivoSeguirConectado);
    }
    $("#cuentaAtrasDesconexion").html(tiempoRestante);
  }, 1000);
  $("#cuentaAtrasDesconexion").html(30);
  Swal.fire({
    icon: "info",
    position: "top",
    title: "<strong>Aviso de Sesion</strong>",
    html:
      "<h5>Su sesion esta a punto de finalizar</h5>" +
      "<p>Han transcurrido cerca de 15 minutos desde tu última interacción con la plataforma.</p>" +
      '<p>Para continuar logueado da clic en "Seguir conectado", de lo contrario tu sesión expirará.</p>' +
      '<h1 class="text-center"><span class="cuenta-inactividad" id="cuentaAtrasDesconexion">30</span></h1>',
    showCloseButton: false,
    confirmButtonText: "Seguir conectado",
    confirmButtonColor: "#11386f",
    backdrop: true,
    allowOutsideClick: false,
    allowEscapeKey: false,
    allowEnterKey: false,
    timer: tiempoEspera,
    timerProgressBar: true,
  }).then((result) => {
    if (result.isConfirmed) {
      // Actualizamos la sesion
      actualizarUltimaConexionOnline();
    }
  });
};

function actualizarUltimaConexion() {
  //reinicio los timer
  clearTimeout(contadorCerrarSesion);
  clearTimeout(contadorSeguirConectado);
  contadorCerrarSesion = setTimeout(function () {
    cerrarSesion();
  }, tiempoMaximoCierreSesion);
  contadorSeguirConectado = setTimeout(seguirConectado, tiempoMaximo);
}
