function testUrl() {
  $.ajax({
    data: { token: "dqtQS2cBmGd8MbyMCHBj3Dq38Xm89vVyxxum4aySt9witAwBN9" }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: "../routes/test/getTest", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      // Code
    },
    success: function (result) {
      console.log(result);
      //   var estado = result.status;
      //   switch (estado) {
      //     case "0":
      //       //--------------------------------
      //       break;

      //     case "1":
      //       //--------------------------------
      //       $("#rtbnPropiedad").html(result.html);
      //       break;
      //   }
    },
    complete: function () {
      // Code
    },
    error: function (xhr) {
      console.log(xhr);
    },
  });
}

testUrl();
