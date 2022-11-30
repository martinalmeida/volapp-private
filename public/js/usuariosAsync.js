let edit = false;
var peticion = null;
var tablaUsuarios = "";

$(document).ready(function () {
  /* ---------  START Serverside Tabla ( tablaUsuarios ) ----------- */
  tablaUsuarios = $("#tablaUsuarios").DataTable({
    processing: true,
    orderClasses: true,
    deferRender: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    pageLength: 10,
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
      { data: "a_paterno" },
      { data: "a_materno" },
      { data: "telefono" },
      { data: "email_user" },
      { data: "pswd" },
      { data: "nombrefiscal" },
      { data: "direccionfiscal" },
      { data: "nombrerol" },
      { data: "descripcion" },
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
});

function readPermisos() {
  $.ajax({
    dataType: "json",
    url: urlBase + "routes/usuarios/read",
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
    url: urlBase + "routes/usuarios/write",
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
    url: urlBase + "routes/selects/getSucursal", //url a donde hacemos la peticion
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
            '<option value="" disabled selected hidden>Seleccione la Sucursal</option>';
          for (let i = 0; i < result.data.length; i++) {
            html += result.data[i].html;
          }

          $("#sucursal").html(html);
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
  $.ajax({
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/selects/getRol", //url a donde hacemos la peticion
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
            '<option value="" disabled selected hidden>Seleccione el Rol</option>';
          for (let i = 0; i < result.data.length; i++) {
            html += result.data[i].html;
          }

          $("#rol").html(html);
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
      peticion = urlBase + "routes/usuarios/update";
    } else {
      $("#imagenBase64").html("");
      peticion = urlBase + "routes/usuarios/create";
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
                title: "<strong>Empresa Creada</strong>",
                html: "<h5>La Empresa se ha registrado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "<strong>Empresa Editada</strong>",
                html: "<h5>La Empresa se ha editado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            }
            reset();
            $("#ModalRegistro").modal("hide");
            tablaUsuarios.clear().draw();
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

            $("#imagenBase64").html(html);
            break;

          case "6":
            Swal.fire({
              icon: "error",
              title: "<strong>Tamaño execivo de Archivo</strong>",
              html: "<h5>Adjunta un archivo de menor tamaño, el peso maximo es de 2MB.</h5>",
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
  edit = true;
  $.ajax({
    data: { idUser: id }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/usuarios/getData", //url a donde hacemos la peticion
    type: "POST",
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
          $("#btnRegistro").text("Editar Usuario");
          $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
          $("#btnRegistro").removeClass("btn btn-info");
          $("#btnRegistro").addClass("btn btn-success");

          $("#identificacion").val(result.data[0].identificacion);
          $("#nombres").val(result.data[0].nombres);
          $("#Apaterno").val(result.data[0].Apaterno);
          $("#Amaterno").val(result.data[0].Amaterno);
          $("#telefono").val(result.data[0].telefono);
          $("#emailUser").val(result.data[0].emailUser);
          $("#pswd").val(result.data[0].pswd);
          $("#nombreFiscal").val(result.data[0].nombrefiscal);
          $("#direccionFiscal").val(result.data[0].direccionfiscal);
          $("#rol").val(result.data[0].rol);
          $("#sucursal").val(result.data[0].sucursal);

          var html = "";
          html +=
            '<img class="rounded" src="data: ' +
            result.data[0].contenType +
            ";base64," +
            result.data[0].base64 +
            '" width="50" height="auto">' +
            '<input type="hidden" id="idUser" name="idUser" value="' +
            result.data[0].id +
            '">' +
            '<input type="hidden" id="contenType" name="contenType" value="' +
            result.data[0].contenType +
            '">' +
            '<input type="hidden" id="base64" name="base64" value="' +
            result.data[0].base64 +
            '">';

          $("#imagenBase64").html(html);

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
      idUser: id,
      status: status,
    },
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/usuarios/status", //url a donde hacemos la peticion
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
            "Estado de la empresa cambiado exitosamente.",
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
          tablaUsuarios.clear().draw();
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
    text: "Se eliminara al usuario del sistema!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar Usuario",
    preConfirm: function () {
      $.ajax({
        data: { idUser: id },
        dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
        url: urlBase + "routes/usuarios/delete", //url a donde hacemos la peticion
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
                "El usuario se ha eliminado satisfactoriamente.",
                "Usuario Eliminada"
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
              tablaUsuarios.clear().draw();
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
  $("#btnRegistro").text("Registrar Usuario");
  $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
  $("#ModalRegistro").modal({
    backdrop: "static",
    keyboard: false,
  });
}

function reset() {
  edit = false;
  vercampos("#frmRegistro", 1);
  limpiarcampos("#frmRegistro");
  $("#imagenBase64").html("");
  $("#btnRegistro").removeClass("btn btn-success");
  $("#btnRegistro").addClass("btn btn-info");
}

function reajustDatatables() {
  tablaUsuarios.columns.adjust().draw();
}
