/* ---------  START Serverside Tabla ( table_persona ) ----------- */
$(document).ready(function () {
  tableServerside();
});

function tableServerside() {
  var table_persona = $("#table_persona").DataTable({
    processing: true,
    orderClasses: false,
    deferRender: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    pageLength: 30,
    destroy: true,
    ajax: {
      type: "POST",
      url: urlBase + "routes/usuarios/readAllDaTable",
    },
    dom:
      "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    buttons: [
      {
        extend: "excelHtml5",
        text: "Excel",
        titleAttr: "Generate Excel",
        className: "btn-outline-success btn-sm mr-1",
      },
      {
        extend: "copyHtml5",
        text: "Copy",
        titleAttr: "Copy to clipboard",
        className: "btn-outline-primary btn-sm mr-1",
      },
      {
        extend: "print",
        text: "Print",
        titleAttr: "Print Table",
        className: "btn-outline-primary btn-sm",
      },
    ],
    columns: [
      { data: "id" },
      { data: "identificacion" },
      { data: "nombres" },
      { data: "apellidos" },
      { data: "telefono" },
      { data: "email_user" },
      { data: "ruc" },
      { data: "nombrefiscal" },
      { data: "direccionfiscal" },
      { data: "rolid" },
      { data: "status" },
      { data: "defaultContent" },
    ],
    language: {
      lengthMenu: "Mostrar _MENU_ registros",
      zeroRecords: "No se encontraron resultados",
      info: "Mostrando registros del _START_ al _END_ de un total de _TOTAL_ registros",
      infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
      infoFiltered: "(filtrado de un total de _MAX_ registros)",
      oPaginate: {
        sFirst: "Primero",
        sLast: "Último",
        sNext: "Siguiente",
        sPrevious: "Anterior",
      },
      sProcessing: "Procesando...",
    },
  });
}

function statusRegistro(id) {
  window.alert(id + "hola");
  tableServerside();
  // $.ajax({
  //   dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
  //   url: urlBase + "routes/usuarios/status", //url a donde hacemos la peticion
  //   type: "POST",
  //   beforeSend: function () {
  //     // $("#overlayText").text("Cerrando Sesión...");
  //     // $(".overlayCargue").fadeOut("slow");
  //   },
  //   complete: function () {
  //     // $(".overlayCargue").fadeIn("slow");
  //   },
  //   success: function (result) {
  //     var estado = result.status;
  //     switch (estado) {
  //       case "1":
  //         Command: toastr["success"](
  //           "Estado del usuario cambiado exitosamente.",
  //           "Estado Cambiado"
  //         );

  //         toastr.options = {
  //           closeButton: false,
  //           debug: false,
  //           newestOnTop: true,
  //           progressBar: true,
  //           positionClass: "toast-top-right",
  //           preventDuplicates: true,
  //           onclick: null,
  //           showDuration: 300,
  //           hideDuration: 100,
  //           timeOut: 5000,
  //           extendedTimeOut: 1000,
  //           showEasing: "swing",
  //           hideEasing: "linear",
  //           showMethod: "fadeIn",
  //           hideMethod: "fadeOut",
  //         };

  //         tableServerside();
  //         break;
  //     }
  //   },
  //   error: function (xhr) {
  //     console.log(xhr);
  //   },
  // });
}
