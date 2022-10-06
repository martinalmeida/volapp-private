// --URL principal del servidor para peticiones--
var urlPeticion = "http://localhost/volapp/routes/";

// --Funcion de inicio de Sesión--
function testRoute(form) {
  $("#resultadoRuta").html("");
  var route = $("#testRutes").val();
  var method = $("#methodAjax").val();
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
      url: urlPeticion + route, //url a donde hacemos la peticion
      type: method,
      beforeSend: function () {
        // $("#overlayText").text("Iniciando Sesion...");
        // $(".overlayCargue").fadeIn("slow");
      },
      complete: function () {
        //$(".overlayCargue").fadeOut("slow");
      },
      success: function (result) {
        var html = "";

        html =
          "<p><b>Status: </b><hr>" +
          result.status +
          "</p><p><b>Data: </b><hr>" +
          result.data +
          "</p>";

        $("#resultadoRuta").html(html);
      },
      error: function (xhr) {
        $("#btnLoginIngresar").prop("disabled", false);
      },
    });
  }
}
