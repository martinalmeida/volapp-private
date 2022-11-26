var edit = null;
var peticion = null;
var tablaMaquinarias = "";
var controls = {
  leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
  rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>',
};
var runDatePicker = function () {
  $("#fechaSoat").datepicker({
    orientation: "buttom left",
    todayHighlight: true,
    templates: controls,
  });
  $("#fechaTecno").datepicker({
    orientation: "buttom left",
    todayHighlight: true,
    templates: controls,
  });
};

$(document).ready(function () {
  /* ---------  START Serverside Tabla ( tablaMaquinarias ) ----------- */
  tablaMaquinarias = $("#tablaMaquinarias").DataTable({
    processing: true,
    orderClasses: true,
    deferRender: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    pageLength: 10,
    ajax: {
      type: "POST",
      url: urlBase + "routes/maquinarias/readAllDaTable",
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
      { data: "tipo" },
      { data: "placa" },
      { data: "marca" },
      { data: "referencia" },
      { data: "modelo" },
      { data: "color" },
      { data: "capacidad" },
      { data: "nroSerie" },
      { data: "nroSerieChasis" },
      { data: "nroMotor" },
      { data: "rodaje" },
      { data: "rut" },
      { data: "gps" },
      { data: "fechaSoat" },
      { data: "fechaTecno" },
      { data: "propietario" },
      { data: "documentoPropietario" },
      { data: "telefonoPropietario" },
      { data: "correoPropietario" },
      { data: "operador" },
      { data: "documentOperador" },
      { data: "telefonOperador" },
      { data: "correOperador" },
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
  readPermisos();
  writePermisos();
  runDatePicker();
  selects();
  $(":input").inputmask();
});

function readPermisos() {
  $.ajax({
    dataType: "json",
    url: urlBase + "routes/maquinarias/read",
    type: "GET",
    beforeSend: function () {},
    success: function (result) {
      if (result.data == 1) {
        $("#panel-1").show();
      } else {
        $("#panel-1").hide();
      }
    },
    complete: function () {},
    error: function (xhr) {
      console.log(xhr);
    },
  });
}

function writePermisos() {
  $.ajax({
    dataType: "json",
    url: urlBase + "routes/maquinarias/write",
    type: "GET",
    beforeSend: function () {},
    success: function (result) {
      $("#permisoSuperior").html(result.data);
    },
    complete: function () {},
    error: function (xhr) {
      console.log(xhr);
    },
  });
}

function selects() {
  $.ajax({
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/selects/getTipoMaquinaria", //url a donde hacemos la peticion
    type: "GET",
    beforeSend: function () {
      // $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "0":
          Swal.fire({
            icon: "error",
            title: "<strong>Error en el servidor</strong>",
            html: "<h5>Se ha presentado un error al intentar insertar la información.</h5>",
            showCloseButton: true,
            showConfirmButton: false,
            cancelButtonText: "Cerrar",
            cancelButtonColor: "#dc3545",
            showCancelButton: true,
            backdrop: true,
          });
          break;

        case "1":
          var html = "";

          html +=
            '<option value="" disabled selected hidden>Seleccione tipo de Maquinaria</option>';
          for (let i = 0; i < result.data.length; i++) {
            html += result.data[i].html;
          }

          $("#tpMaquinaria").html(html);
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

        default:
          break;
      }
    },
    complete: function () {
      // setTimeout(() => {
      //   $(".overlayCargue").fadeOut("slow");
      // }, 1000);
    },
    error: function (xhr) {
      console.log(xhr);
      Swal.fire({
        icon: "error",
        title: "<strong>Error!</strong>",
        html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
        showCloseButton: true,
        showConfirmButton: false,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#dc3545",
        showCancelButton: true,
        backdrop: true,
      });
    },
  });
}

function registrar(form) {
  $("#alertaForm").html("");
  var respuestavalidacion = validarcampos("#" + form);
  if (respuestavalidacion) {
    var formData = new FormData(document.getElementById(form));
    if (edit == true) {
      peticion = urlBase + "routes/maquinarias/update";
    } else if (edit == false) {
      $("#archivoBase64").html("");
      peticion = urlBase + "routes/maquinarias/create";
    } else if (edit == null) {
      return false;
    }
    $.ajax({
      cache: false, //necesario para enviar archivos
      contentType: false, //necesario para enviar archivos
      processData: false, //necesario para enviar archivos
      data: formData, //necesario para enviar archivos
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: peticion, //url a donde hacemos la peticion
      type: "POST",
      beforeSend: function () {
        // $(".overlayCargue").fadeIn("slow");
      },
      complete: function () {
        // setTimeout(() => {
        //   $(".overlayCargue").fadeOut("slow");
        // }, 1000);
      },
      success: function (result) {
        var estado = result.status;
        var html = "";
        switch (estado) {
          case "0":
            Swal.fire({
              icon: "error",
              title: "<strong>Error en el servidor</strong>",
              html: "<h5>Se ha presentado un error al intentar insertar la información.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#ModalRegistro").modal("hide");
            break;

          case "1":
            if (edit == false) {
              Swal.fire({
                icon: "success",
                title: "<strong>Maquinaria Creada</strong>",
                html: "<h5>La maquinaria se ha registrado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "<strong>Maquinaria Editada</strong>",
                html: "<h5>La maquinaria se ha editado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            }
            $("#ModalRegistro").modal("hide");
            tablaMaquinarias.clear().draw();
            reset();
            break;

          case "2":
            html +=
              '<div class="alert border-danger bg-transparent text-info fade show" role="alert">' +
              '<div class="d-flex align-items-center"><div class="alert-icon text-danger">' +
              '<i class="fal fa-exclamation-triangle"></i></div>' +
              '<div class="flex-1 text-danger"><span class="h5 m-0 fw-700">Error de Validación </span></div>' +
              '<button type="button" class="btn btn-danger btn-pills btn-sm btn-w-m waves-effect waves-themed" data-dismiss="alert" aria-label="Close">' +
              "Cerrar</button></div></div>";

            $("#alertaForm").html(html);
            break;

          case "4":
            Swal.fire({
              icon: "warning",
              title: "<strong>Archivo Dañado</strong>",
              html: "<h5>El archivo esta corrupto.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#ModalRegistro").modal("hide");
            break;

          case "5":
            html +=
              '<div class="alert border-warning bg-transparent text-info fade show" role="alert">' +
              '<div class="d-flex align-items-center"><div class="alert-icon text-warning">' +
              '<i class="fal fa-exclamation-triangle"></i></div>' +
              '<div class="flex-1 text-warning"><span class="h5 m-0 fw-700">Adjunte el Archivo de Documentación de maquinaria </span></div>' +
              '<button type="button" class="btn btn-warning btn-pills btn-sm btn-w-m waves-effect waves-themed" data-dismiss="alert" aria-label="Close">' +
              "Cerrar</button></div></div>";

            $("#archivoBase64").html(html);
            break;

          case "6":
            Swal.fire({
              icon: "error",
              title: "<strong>Tamaño excesivo de Archivo</strong>",
              html: "<h5>Adjunta un archivo de menor tamaño, el peso maximo es de 10MB.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#ModalRegistro").modal("hide");
            break;

          default:
            // Code
            break;
        }
      },
      error: function (xhr) {
        console.log(xhr);
        Swal.fire({
          icon: "error",
          title: "<strong>Error!</strong>",
          html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
          showCloseButton: true,
          showConfirmButton: false,
          cancelButtonText: "Cerrar",
          cancelButtonColor: "#dc3545",
          showCancelButton: true,
          backdrop: true,
        });
        $("#ModalRegistro").modal("hide");
      },
    });
  }
}

function editarRegistro(id) {
  $("#alertaForm").html("");
  $("#archivoBase64").html("");
  $(':input[type="file"]').val("");
  edit = true;
  $.ajax({
    data: { idMaquinaria: id }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/maquinarias/getData", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      // $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      var html = "";
      switch (estado) {
        case "0":
          Swal.fire({
            icon: "error",
            title: "<strong>Error en el servidor</strong>",
            html: "<h5>Se ha presentado un error al intentar insertar la información.</h5>",
            showCloseButton: true,
            showConfirmButton: false,
            cancelButtonText: "Cerrar",
            cancelButtonColor: "#dc3545",
            showCancelButton: true,
            backdrop: true,
          });
          break;

        case "1":
          $("#placa").val(result.data[0].placa);
          $("#marca").val(result.data[0].marca);
          $("#referencia").val(result.data[0].referencia);
          $("#modelo").val(result.data[0].modelo);
          $("#color").val(result.data[0].color);
          $("#capacidad").val(result.data[0].capacidad);
          $("#nroSerie").val(result.data[0].nroSerie);
          $("#nroSerieChasis").val(result.data[0].nroSerieChasis);
          $("#nroMotor").val(result.data[0].nroMotor);
          $("#rodaje").val(result.data[0].rodaje);
          $("#rut").val(result.data[0].rut);
          $("#gps").val(result.data[0].gps);
          $("#fechaSoat").val(result.data[0].fechaSoat);
          $("#fechaTecno").val(result.data[0].fechaTecno);
          $("#propietario").val(result.data[0].propietario);
          $("#documentoPropietario").val(result.data[0].documentoPropietario);
          $("#telefonoPropietario").val(result.data[0].telefonoPropietario);
          $("#correoPropietario").val(result.data[0].correoPropietario);
          $("#operador").val(result.data[0].operador);
          $("#documentOperador").val(result.data[0].documentOperador);
          $("#telefonOperador").val(result.data[0].telefonOperador);
          $("#correOperador").val(result.data[0].correOperador);
          $("#tpMaquinaria").val(result.data[0].idMaquinaria);

          html +=
            '<button type="button" class="btn btn-outline-danger" onclick="visualizarPDF(' +
            "'" +
            result.data[0].contenType +
            "', '" +
            result.data[0].base64 +
            "'" +
            ');" >Ver Documentación del Maquinaria <i class="fal fa-file-pdf"></i></button>' +
            '<input type="hidden" id="idMaquinaria" name="idMaquinaria" value="' +
            result.data[0].id +
            '">' +
            '<input type="hidden" id="contenType" name="contenType" value="' +
            result.data[0].contenType +
            '">' +
            '<input type="hidden" id="base64" name="base64" value="' +
            result.data[0].base64 +
            '">';

          $("#archivoBase64").html(html);

          $("#btnRegistro").text("Editar Maquinaria");
          $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
          $("#btnRegistro").removeClass("btn btn-info");
          $("#btnRegistro").addClass("btn btn-success");
          $("#ModalRegistro").modal({
            backdrop: "static",
            keyboard: false,
          });
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

        default:
          break;
      }
    },
    complete: function () {
      // setTimeout(() => {
      //   $(".overlayCargue").fadeOut("slow");
      // }, 1000);
    },
    error: function (xhr) {
      console.log(xhr);
      Swal.fire({
        icon: "error",
        title: "<strong>Error!</strong>",
        html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
        showCloseButton: true,
        showConfirmButton: false,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#dc3545",
        showCancelButton: true,
        backdrop: true,
      });
    },
  });
}

function visualizarPDF(content, base) {
  var base64 = base;
  const blob = base64ToBlob(base64, content);
  const url = URL.createObjectURL(blob);
  const pdfWindow = window.open("");
  pdfWindow.document.write(
    "<iframe width='100%' height='100%' src='" + url + "'></iframe>"
  );

  function base64ToBlob(base64, type = "application/octet-stream") {
    const binStr = atob(base64);
    const len = binStr.length;
    const arr = new Uint8Array(len);
    for (let i = 0; i < len; i++) {
      arr[i] = binStr.charCodeAt(i);
    }
    return new Blob([arr], { type: type });
  }
}

function statusRegistro(id, status) {
  $.ajax({
    data: {
      idMaquinaria: id,
      status: status,
    },
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/maquinarias/status", //url a donde hacemos la peticion
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
        case "0":
          Swal.fire({
            icon: "error",
            title: "<strong>Error en el servidor</strong>",
            html: "<h5>Se ha presentado un error al intentar insertar la información.</h5>",
            showCloseButton: true,
            showConfirmButton: false,
            cancelButtonText: "Cerrar",
            cancelButtonColor: "#dc3545",
            showCancelButton: true,
            backdrop: true,
          });
          break;

        case "1":
          Command: toastr["success"](
            "Estado del Maquinaria cambiado exitosamente.",
            "Estado Cambiado"
          );

          toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: 300,
            hideDuration: 100,
            timeOut: 5000,
            extendedTimeOut: 1000,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
          };
          tablaMaquinarias.clear().draw();
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
      }
    },
    error: function (xhr) {
      console.log(xhr);
      Command: toastr["error"](
        "Fallo la ejecucion de la acción, por favor comunicate con soporte.",
        "Operación Fallida."
      );

      toastr.options = {
        closeButton: false,
        debug: false,
        newestOnTop: true,
        progressBar: true,
        positionClass: "toast-top-right",
        preventDuplicates: true,
        onclick: null,
        showDuration: 300,
        hideDuration: 100,
        timeOut: 5000,
        extendedTimeOut: 1000,
        showEasing: "swing",
        hideEasing: "linear",
        showMethod: "fadeIn",
        hideMethod: "fadeOut",
      };
    },
  });
}

function eliminarRegistro(id) {
  Swal.fire({
    icon: "warning",
    title: "Que deseas hacer?",
    text: "Se eliminara el Maquinaria del sistema!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar Maquinaria",
    preConfirm: function () {
      $.ajax({
        data: { idMaquinaria: id },
        dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
        url: urlBase + "routes/maquinarias/delete", //url a donde hacemos la peticion
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
            case "0":
              Swal.fire({
                icon: "error",
                title: "<strong>Error en el servidor</strong>",
                html: "<h5>Se ha presentado un error al intentar insertar la información.</h5>",
                showCloseButton: true,
                showConfirmButton: false,
                cancelButtonText: "Cerrar",
                cancelButtonColor: "#dc3545",
                showCancelButton: true,
                backdrop: true,
              });
              break;

            case "1":
              Command: toastr["success"](
                "La maquinaria se ha eliminado satisfactoriamente.",
                "Maquinaria Eliminada"
              );

              toastr.options = {
                closeButton: false,
                debug: false,
                newestOnTop: true,
                progressBar: true,
                positionClass: "toast-top-right",
                preventDuplicates: true,
                onclick: null,
                showDuration: 300,
                hideDuration: 100,
                timeOut: 5000,
                extendedTimeOut: 1000,
                showEasing: "swing",
                hideEasing: "linear",
                showMethod: "fadeIn",
                hideMethod: "fadeOut",
              };
              tablaMaquinarias.clear().draw();
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
          }
        },
        error: function (xhr) {
          console.log(xhr);
          Command: toastr["error"](
            "Fallo la ejecucion de la acción, por favor comunicate con soporte.",
            "Operación Fallida."
          );

          toastr.options = {
            closeButton: false,
            debug: false,
            newestOnTop: true,
            progressBar: true,
            positionClass: "toast-top-right",
            preventDuplicates: true,
            onclick: null,
            showDuration: 300,
            hideDuration: 100,
            timeOut: 5000,
            extendedTimeOut: 1000,
            showEasing: "swing",
            hideEasing: "linear",
            showMethod: "fadeIn",
            hideMethod: "fadeOut",
          };
        },
      });
    },
  });
}

function showModalRegistro() {
  reset();
  $("#alertaForm").html("");
  $("#btnRegistro").text("Registrar Maquinaria");
  $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
  $("#ModalRegistro").modal({
    backdrop: "static",
    keyboard: false,
  });
  edit = false;
}

function showModalAsignar(id) {
  $.ajax({
    data: { idMaquinaria: id }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/maquinarias/checkAcuerdo", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      // $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      var html = "";
      switch (estado) {
        case "0":
          Swal.fire({
            icon: "error",
            title: "<strong>Error en el servidor</strong>",
            html: "<h5>Se ha presentado un error al intentar insertar la información.</h5>",
            showCloseButton: true,
            showConfirmButton: false,
            cancelButtonText: "Cerrar",
            cancelButtonColor: "#dc3545",
            showCancelButton: true,
            backdrop: true,
          });
          break;

        case "1":
          Swal.fire({
            icon: "warning",
            title: "<strong>Maquinaria Asociada</strong>",
            html: "<h5>Esta maquinaria ya se encuentra asociada a un acuerdo</h5>",
            showCloseButton: true,
            showConfirmButton: false,
            cancelButtonText: "Cerrar",
            cancelButtonColor: "#dc3545",
            showCancelButton: true,
            backdrop: true,
          });
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
          var html = "";

          html +=
            '<div class="panel-content">' +
            '<div class="panel-tag">' +
            "Los acuerdos o modos de facturación es la clacificación del la formula final de pago a los equipos, maquinarias y vehiculos. En caso de asignar mal el acuerdo, comicate a sistema." +
            '</div><div class="card-group">' +
            '<div class="card bg-success">' +
            '<div class="card-body text-center">' +
            '<h3 class="card-title text-white">Modo Alquiler</h3>' +
            '<h1 class="text-white"><i class="fal fa-hands-usd fa-2x"></i></i></h1>' +
            '<p class="card-text text-white">En el modo alquiler se calcula el Stand By de horas, u horometro final menos horometro inicial.</p>' +
            '<button type="button" class="btn btn-outline-light btn-pills waves-effect waves-themed" onclick="asignarModoFacturacion(' +
            id +
            ', 1);">Asignar modo Alquiler</button>' +
            "</div>" +
            "</div>" +
            '<div class="card bg-info">' +
            '<div class="card-body text-center">' +
            '<h3 class="card-title text-white">Modo Flete</h3>' +
            '<h1 class="text-white"><i class="fal fa-route fa-2x"></i></h1>' +
            '<p class="card-text text-white">En el modo flete se calcula solo un valor pactado por viaje con el socio o dueño del vehículo.</p>' +
            '<button type="button" class="btn btn-outline-light btn-pills waves-effect waves-themed" onclick="asignarModoFacturacion(' +
            id +
            ', 2);">Asignar modo Flete</button>' +
            "</div>" +
            "</div>" +
            '<div class="card bg-primary">' +
            '<div class="card-body text-center">' +
            '<h3 class="card-title text-white">Modo Movimiento</h3>' +
            '<h1 class="text-white"><i class="fal fa-truck-container fa-2x"></i></h1>' +
            '<p class="card-text text-white">Calculo de nro de viajes, tarifa de ruta pactada, metraje cubico y kilometros recorridos.</p>' +
            '<button type="button" class="btn btn-outline-light btn-pills waves-effect waves-themed" onclick="asignarModoFacturacion(' +
            id +
            ', 3);">Asignar modo Movimiento</button>' +
            "</div>" +
            "</div>" +
            "</div></div>";

          $("#workSpace").html(html);

          $("#ModalAsignar").modal({
            backdrop: "static",
            keyboard: false,
          });
          break;

        default:
          break;
      }
    },
    complete: function () {
      // setTimeout(() => {
      //   $(".overlayCargue").fadeOut("slow");
      // }, 1000);
    },
    error: function (xhr) {
      console.log(xhr);
      Swal.fire({
        icon: "error",
        title: "<strong>Error!</strong>",
        html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
        showCloseButton: true,
        showConfirmButton: false,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#dc3545",
        showCancelButton: true,
        backdrop: true,
      });
    },
  });
}

function asignarModoFacturacion(id, table) {
  $.ajax({
    data: { idMaquinaria: id, tabla: table }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/maquinarias/asignarMode", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      // $(".overlayCargue").fadeIn("slow");
    },
    complete: function () {
      // setTimeout(() => {
      //   $(".overlayCargue").fadeOut("slow");
      // }, 1000);
    },
    success: function (result) {
      var estado = result.status;
      var html = "";
      switch (estado) {
        case "0":
          Swal.fire({
            icon: "error",
            title: "<strong>Error en el servidor</strong>",
            html: "<h5>Se ha presentado un error al intentar insertar la información.</h5>",
            showCloseButton: true,
            showConfirmButton: false,
            cancelButtonText: "Cerrar",
            cancelButtonColor: "#dc3545",
            showCancelButton: true,
            backdrop: true,
          });
          $("#ModalAsignar").modal("hide");
          break;

        case "1":
          Swal.fire({
            icon: "success",
            title: "<strong>Modo Asignado</strong>",
            html: "<h5>Modo de facturación asignado a la maquinaria exitosamente.</h5>",
            showCloseButton: false,
            confirmButtonText: "Aceptar",
            confirmButtonColor: "#64a19d",
            backdrop: true,
          });

          $("#ModalAsignar").modal("hide");
          tablaMaquinarias.clear().draw();
          reset();
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

        default:
          // Code
          break;
      }
    },
    error: function (xhr) {
      console.log(xhr);
      Swal.fire({
        icon: "error",
        title: "<strong>Error!</strong>",
        html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
        showCloseButton: true,
        showConfirmButton: false,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#dc3545",
        showCancelButton: true,
        backdrop: true,
      });
      $("#ModalRegistro").modal("hide");
    },
  });
}

function reset() {
  vercampos("#frmRegistro", 1);
  limpiarcampos("#frmRegistro");
  $("#archivoBase64").html("");
  $("#btnRegistro").removeClass("btn btn-success");
  $("#btnRegistro").addClass("btn btn-info");
  $(':input[type="file"]').val("");
}

function reajustDatatables() {
  tablaMaquinarias.columns.adjust().draw();
}
