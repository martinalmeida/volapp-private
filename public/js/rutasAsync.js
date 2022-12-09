let edit = null;
var peticion = null;
var tablaRutas = "";

$(document).ready(function () {
  /* ---------  START Serverside Tabla ( tablaRutas ) ----------- */
  tablaRutas = $("#tablaRutas").DataTable({
    processing: true,
    orderClasses: true,
    deferRender: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    pageLength: 10,
    ajax: {
      type: "POST",
      url: urlBase + "routes/rutas/readAllDaTable",
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
      { data: "nombre" },
      { data: "origen" },
      { data: "destino" },
      { data: "titulo" },
      { data: "kilometraje" },
      { data: "tarifa" },
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
  selects();
  $("#contrato").select2({
    placeholder: "Seleccione el Contrato para esta ruta",
    allowClear: true,
  });
});

function readPermisos() {
  $.ajax({
    dataType: "json",
    url: urlBase + "routes/rutas/read",
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
    url: urlBase + "routes/rutas/write",
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
    url: urlBase + "routes/selects/getContrato", //url a donde hacemos la peticion
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

          for (let i = 0; i < result.data.length; i++) {
            html += result.data[i].html;
          }

          $("#contrato").html(html);
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
      peticion = urlBase + "routes/rutas/update";
    } else if (edit == false) {
      $("#inputsEditar").html("");
      peticion = urlBase + "routes/rutas/create";
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
                title: "<strong>Contrato Creado</strong>",
                html: "<h5>El contrato se ha registrado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "<strong>Contrato Editado</strong>",
                html: "<h5>El contrato se ha editado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            }
            $("#ModalRegistro").modal("hide");
            tablaRutas.clear().draw();
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
  $("#inputsEditar").html("");
  $("#alertaForm").html("");
  edit = true;
  $.ajax({
    data: { idRuta: id }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/rutas/getData", //url a donde hacemos la peticion
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
          $("#nombre").val(result.data[0].nombre);
          $("#origen").val(result.data[0].origen);
          $("#destino").val(result.data[0].destino);
          $("#kilometraje").val(result.data[0].kilometraje);
          $("#tarifa").val(result.data[0].tarifa);
          $("#contrato").val(result.data[0].contrato);
          $("#contrato").val(result.data[0].contrato).trigger("change");

          html +=
            '<input type="hidden" id="idRuta" name="idRuta" value="' +
            result.data[0].id +
            '">' +
            '<input type="hidden" id="idRuC" name="idRuC" value="' +
            result.data[0].idRuC +
            '">';

          $("#inputsEditar").html(html);
          $("#btnRegistro").text("Editar Contrato");
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

function statusRegistro(id, status) {
  $.ajax({
    data: {
      idRuta: id,
      status: status,
    },
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/rutas/status", //url a donde hacemos la peticion
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
            "Estado del Contrato cambiado exitosamente.",
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
          tablaRutas.clear().draw();
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
    text: "Se eliminara el Contrato del sistema!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar Contrato",
    preConfirm: function () {
      $.ajax({
        data: { idRuta: id },
        dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
        url: urlBase + "routes/rutas/delete", //url a donde hacemos la peticion
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
                "El contrato se ha eliminado satisfactoriamente.",
                "Contrato Eliminado"
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
              tablaRutas.clear().draw();
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
  $("#btnRegistro").text("Registrar Contrato");
  $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
  $("#ModalRegistro").modal({
    backdrop: "static",
    keyboard: false,
  });
  edit = false;
}

function reset() {
  vercampos("#frmRegistro", 1);
  limpiarcampos("#frmRegistro");
  $("#btnRegistro").removeClass("btn btn-success");
  $("#btnRegistro").addClass("btn btn-info");
}

function filterFloat(evt, input) {
  // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
  var key = window.Event ? evt.which : evt.keyCode;
  var chark = String.fromCharCode(key);
  var tempValue = input.value + chark;
  if (key >= 48 && key <= 57) {
    if (filter(tempValue) === false) {
      return false;
    } else {
      return true;
    }
  } else {
    if (key == 8 || key == 13 || key == 0) {
      return true;
    } else if (key == 46) {
      if (filter(tempValue) === false) {
        return false;
      } else {
        return true;
      }
    } else {
      return false;
    }
  }
}

function filter(__val__) {
  var preg = /^([0-9]+\.?[0-9]{0,2})$/;
  if (preg.test(__val__) === true) {
    return true;
  } else {
    return false;
  }
}

function reajustDatatables() {
  tablaRutas.columns.adjust().draw();
}
