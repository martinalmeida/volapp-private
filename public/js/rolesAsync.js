let edit = false;
var peticion = null;
var tablaRoles = "";
var asignacion = null;

$(document).ready(function () {
  /* ---------  START Serverside Tabla ( tablaRoles ) ----------- */
  tablaRoles = $("#tablaRoles").DataTable({
    processing: true,
    orderClasses: true,
    deferRender: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    pageLength: 30,
    ajax: {
      type: "POST",
      url: urlBase + "routes/roles/readAllDaTable",
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
});

function registrar(form) {
  var respuestavalidacion = validarcampos("#" + form);
  if (respuestavalidacion) {
    var formData = new FormData(document.getElementById(form));
    if (edit == true) {
      peticion = urlBase + "routes/roles/update";
    } else {
      peticion = urlBase + "routes/roles/create";
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
                title: "<strong>Rol Creado</strong>",
                html: "<h5>El Rol se ha registrado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "<strong>Rol Editado</strong>",
                html: "<h5>El Rol se ha editado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            }
            reset();
            $("#ModalRegistro").modal("hide");
            tablaRoles.clear().draw();
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
  $("#inputsEditar").html("");
  edit = true;
  $.ajax({
    data: { idRol: id }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/roles/getData", //url a donde hacemos la peticion
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
          $("#btnRegistro").show();
          $("#btnRegistro").text("Editar Rol");
          $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
          $("#btnRegistro").removeClass("btn btn-info");
          $("#btnRegistro").addClass("btn btn-success");

          $("#nombrerol").val(result.data.nombrerol);
          $("#descripcion").val(result.data.descripcion);

          var html = "";
          html +=
            '<input type="hidden" id="idRol" name="idRol" value="' +
            result.data.id +
            '">';

          $("#inputsEditar").html(html);

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
      idRol: id,
      status: status,
    },
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/roles/status", //url a donde hacemos la peticion
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
            "Estado del rol cambiado exitosamente.",
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
          tablaRoles.clear().draw();
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
    text: "Se eliminara el rol del sistema!",
    type: "warning",
    showCancelButton: true,
    confirmButtonColor: "#3085d6",
    cancelButtonColor: "#d33",
    confirmButtonText: "Eliminar Rol",
    preConfirm: function () {
      $.ajax({
        data: { idRol: id },
        dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
        url: urlBase + "routes/roles/delete", //url a donde hacemos la peticion
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
                "La empresa se ha eliminado satisfactoriamente.",
                "Empresa Eliminada"
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
              tablaRoles.clear().draw();
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

function asignarModulos(id) {
  $("#workSpaceAsignar").html("");
  $("#ModalAsignarModulos").modal({
    backdrop: "static",
    keyboard: false,
  });
  setTimeout(function () {
    $.ajax({
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "routes/modulos/getModulo", //url a donde hacemos la peticion
      type: "GET",
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
            $("#ModalAsignarModulos").modal("hide");
            break;

          case "1":
            // --Traemos los modulos de la plataforma--
            var html = "";

            html += '<div class="panel-content">';
            for (let i = 0; i < result.data.length; i++) {
              html +=
                '<div class="accordion accordion-hover" id="cardModulo' +
                result.data[i].id +
                '">' +
                '<div class="card"><div class="card-header">' +
                '<a href="javascript:void(0);" onclick="modulosAsignados(' +
                id +
                ", " +
                result.data[i].id +
                "); modulosNoAsignados(" +
                id +
                ", " +
                result.data[i].id +
                ');" class="card-title collapsed" data-toggle="collapse" data-target="#cardModulo' +
                result.data[i].id +
                'a" aria-expanded="false"><i class="' +
                result.data[i].icono +
                '"></i>' +
                result.data[i].titulo +
                '<span class="ml-auto"><span class="collapsed-reveal"><i class="fal fa-chevron-up fs-xl"></i></span>' +
                '<span class="collapsed-hidden"><i class="fal fa-chevron-down fs-xl"></i></span></span></a></div><div id="cardModulo' +
                result.data[i].id +
                'a" class="collapse" data-parent="#cardModulo' +
                result.data[i].id +
                '" style=""><div class="card-body">' +
                '<div class="card-group">' +
                '<div class="card">' +
                '<div class="card-body">' +
                '<h4 class="card-title text-success bg-white">Modulos Asignados</h4>' +
                '<div id="asignado' +
                result.data[i].id +
                '"></div></div></div>' +
                '<div class="card">' +
                '<div class="card-body">' +
                '<h4 class="card-title text-danger bg-white">Modulos no Asignados</h4>' +
                '<div id="noAsignado' +
                result.data[i].id +
                '"></div></div></div></div>' +
                "</div></div></div></div>";
            }

            html += "</div>";
            $("#workSpaceAsignar").html(html);
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
            $("#ModalAsignarModulos").modal("hide");
            break;

          case "3":
            Swal.fire({
              icon: "error",
              title: "<strong>Modulos no Encontrados</strong>",
              html: "<h5>No se han encontrado modulos.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#ModalAsignarModulos").modal("hide");
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
        $("#ModalAsignarModulos").modal("hide");
      },
    });
  }, 500);
}

function modulosAsignados(id, idModulo) {
  $("#asignado" + idModulo).html("");
  setTimeout(function () {
    $.ajax({
      data: { idRol: id, idModulo: idModulo },
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "routes/modulos/getAsignados", //url a donde hacemos la peticion
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
            $("#ModalAsignarModulos").modal("hide");
            break;

          case "1":
            // --Traemos los modulos de la plataforma--
            var html = "";

            for (let i = 0; i < result.data.length; i++) {
              html +=
                '<div class="p-1"><button type="button" class="btn btn-primary text-white">' +
                result.data[i].titulo +
                "</button></div>";
            }

            $("#asignado" + idModulo).html(html);
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
            $("#ModalAsignarModulos").modal("hide");
            break;

          case "3":
            var html = "";
            html += '<h3 class="text-dark">No hay modulos Asignados</h3>';
            $("#asignado" + idModulo).html(html);
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
        $("#ModalAsignarModulos").modal("hide");
      },
    });
    //modulosNoAsignados(id, idModulo);
  }, 500);
}

function modulosNoAsignados(id, idModulo) {
  $("#noAsignado" + idModulo).html("");
  setTimeout(function () {
    $.ajax({
      data: { idRol: id, idModulo: idModulo },
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "routes/modulos/getNoAsignados", //url a donde hacemos la peticion
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
            $("#ModalAsignarModulos").modal("hide");
            break;

          case "1":
            // --Traemos los modulos de la plataforma--
            var html = "";

            for (let i = 0; i < result.data.length; i++) {
              html +=
                '<div class="p-1"><button type="button" class="btn btn-primary text-white">' +
                result.data[i].titulo +
                "</button></div>";
            }

            $("#noAsignado" + idModulo).html(html);
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
            $("#ModalAsignarModulos").modal("hide");
            break;

          case "3":
            var html = "";
            html += '<h3 class="text-dark">Todos los modulos Asiganados</h3>';
            $("#noAsignado" + idModulo).html(html);
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
        $("#ModalAsignarModulos").modal("hide");
      },
    });
    //modulosNoAsignados(id, idModulo);
  }, 500);
}

function cambioAsignacion(idModulo, idRol, asignacion) {
  $.ajax({
    data: {
      idModulo: idModulo,
      idRol: idRol,
      asignar: asignacion,
    },
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/modulos/status", //url a donde hacemos la peticion
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
            "Estado del rol cambiado exitosamente.",
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
          tablaRoles.clear().draw();
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

function modulosPermisos(id) {
  $("#workSpacePermisos").html("");
  $("#ModalPermisos").modal({
    backdrop: "static",
    keyboard: false,
  });
  setTimeout(function () {
    $.ajax({
      dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
      url: urlBase + "routes/modulos/getData", //url a donde hacemos la peticion
      type: "GET",
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
            // --Traemos los modulos de la plataforma--
            var html = "";
            for (let i = 0; i < result.data.length; i++) {
              html +=
                '<div class="card bg-white text-center p-3 m-1">' +
                '<blockquote class="blockquote mb-0">' +
                '<div class="frame-wrap bg-white">' +
                '<div class="custom-control custom-checkbox custom-control-inline p-2"><h5><b>' +
                result.data[i].titulo +
                "</b></h5></div>" +
                '<div id="permissions' +
                result.data[i].id +
                '"></div>';

              // --Traemos los permisos que tiene el rol por cada modulo--
              setTimeout(function () {
                $.ajax({
                  data: { idRol: id, idModulo: result.data[i].id }, //datos a enviar a la url
                  dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
                  url: urlBase + "routes/modulos/getPermissions", //url a donde hacemos la peticion
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
                        var html = "";
                        for (let j = 0; j < result.data.length; j++) {
                          html +=
                            '<div class="custom-control custom-checkbox custom-control-inline">' +
                            '<input type="checkbox" class="custom-control-input" id="r' +
                            result.data[j].idModulo +
                            '">' +
                            '<label class="custom-control-label" for="r' +
                            result.data[j].idModulo +
                            '">Leer</label></div>' +
                            '<div class="custom-control custom-checkbox custom-control-inline">' +
                            '<input type="checkbox" class="custom-control-input" id="w' +
                            result.data[j].idModulo +
                            '">' +
                            '<label class="custom-control-label" for="w' +
                            result.data[j].idModulo +
                            '">Escribir</label></div>' +
                            '<div class="custom-control custom-checkbox custom-control-inline">' +
                            '<input type="checkbox" class="custom-control-input" id="u' +
                            result.data[j].idModulo +
                            '">' +
                            '<label class="custom-control-label" for="u' +
                            result.data[j].idModulo +
                            '">Actualizar</label></div>' +
                            '<div class="custom-control custom-checkbox custom-control-inline">' +
                            '<input type="checkbox" class="custom-control-input" id="d' +
                            result.data[j].idModulo +
                            '">' +
                            '<label class="custom-control-label" for="d' +
                            result.data[j].idModulo +
                            '">Eliminar</label></div>';
                          $("#permissions" + result.data[j].idModulo).html(
                            html
                          );
                          $("#w" + result.data[j].idModulo).prop(
                            "checked",
                            true
                          );
                          $("#r" + result.data[j].idModulo).prop(
                            "checked",
                            true
                          );
                          $("#u" + result.data[j].idModulo).prop(
                            "checked",
                            true
                          );
                          $("#d" + result.data[j].idModulo).prop(
                            "checked",
                            true
                          );
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
                        $("#ModalPermisos").modal("hide");
                        break;

                      case "3":
                        Swal.fire({
                          icon: "warning",
                          title: "<strong>Rol sin Modulos</strong>",
                          html: "<h5>Asigna primero modulos a este rol para poder dar permisos a los mismos.</h5>",
                          showCloseButton: true,
                          showConfirmButton: false,
                          cancelButtonText: "Cerrar",
                          cancelButtonColor: "#dc3545",
                          showCancelButton: true,
                          backdrop: true,
                        });
                        $("#ModalPermisos").modal("hide");
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
                    $("#ModalPermisos").modal("hide");
                  },
                });
              }, 500);
              html += "</div></blockquote></div>";
              $("#workSpacePermisos").html(html);
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
            $("#ModalPermisos").modal("hide");
            break;

          case "3":
            Swal.fire({
              icon: "error",
              title: "<strong>Modulos no Encontrados</strong>",
              html: "<h5>No se han encontrado modulos.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            $("#ModalPermisos").modal("hide");
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
        $("#ModalPermisos").modal("hide");
      },
    });
  }, 500);
}

function showModalRegistro() {
  reset();
  $("#btnRegistro").text("Registrar Rol");
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
  $("#inputsEditar").html("");
  $("#btnRegistro").removeClass("btn btn-success");
  $("#btnRegistro").addClass("btn btn-info");
}

function reajustDatatables() {
  tablaRoles.columns.adjust().draw();
}
