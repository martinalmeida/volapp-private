/* ---------  START Serverside Tabla ( table_persona ) ----------- */
var tablaEmpresas = $("#table_persona").DataTable({
  processing: true,
  orderClasses: false,
  deferRender: true,
  serverSide: true,
  responsive: true,
  lengthChange: false,
  pageLength: 30,
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

let edit = false;

function registrar(form) {
  var respuestavalidacion = validarcampos("#" + form);
  if (respuestavalidacion) {
    var formData = new FormData(document.getElementById(form));
    if (edit == true) {
      var peticion = urlBase + "routes/empresas/update";
    } else {
      var peticion = urlBase + "routes/empresas/create";
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
              title: "<strong>Error!</strong>",
              html: "<h5>Se ha presentado un error, por favor informar al area de Sistemas.</h5>",
              showCloseButton: true,
              showConfirmButton: false,
              cancelButtonText: "Cerrar",
              cancelButtonColor: "#dc3545",
              showCancelButton: true,
              backdrop: true,
            });
            break;
          case "1":
            if (edit == false) {
              Swal.fire({
                icon: "success",
                title: "<strong>Cargo Creado</strong>",
                html: "<h5>El Cargo se ha registrado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            } else {
              Swal.fire({
                icon: "success",
                title: "<strong>Cargo Editado</strong>",
                html: "<h5>El Cargo se ha editado exitosamente</h5>",
                showCloseButton: false,
                confirmButtonText: "Aceptar",
                confirmButtonColor: "#64a19d",
                backdrop: true,
              });
            }
            reset();
            $("#ModalRegistro").modal("hide");
            tablaEmpresas.clear().draw();
            break;
          case "2":
            $.toast({
              heading: "Error!",
              text: "Ya existe un Cargo con este nombre",
              showHideTransition: "slide",
              icon: "info",
              position: "top-right",
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
      },
    });
  }
}

function editar_registro(id) {
  edit = true;
  datos_registro(id);
}

function datos_registro(id) {
  $.ajax({
    data: {
      peticion: "datosCargo",
      id_cargo: id,
    }, //datos a enviar a la url
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "php/controller/controller_cargos.php", //url a donde hacemos la peticion
    type: "POST",
    beforeSend: function () {
      $(".overlayCargue").fadeIn("slow");
    },
    success: function (result) {
      var estado = result.status;
      switch (estado) {
        case "0":
          Swal.fire({
            title: "Error!",
            text: "Se ha presentado un error, comuniquese con el area de sistemas.",
            icon: "error",
            showCancelButton: true,
            showConfirmButton: false,
            cancelButtonColor: "#d33",
            cancelButtonText: "Cerrar!",
          });
          break;
        case "1":
          if (edit == false) {
            $("#ModalRegistro").find("h5.modal-title").html("Ver Cargo");
            $("#btnRegistro").hide();
            $("#btnRegistro").text("Registrar");
            $("#btnRegistro").attr("onclick", "");
            vercampos("#frmRegistro", 2);
          } else {
            $("#ModalRegistro").find("h5.modal-title").html("Editar Cargo");
            $("#btnRegistro").show();
            $("#btnRegistro").text("Editar");
            $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
          }
          $("#id_cargo").val(result.id_cargo);
          $("#descripcion").val(result.descripcion);
          $("#ModalRegistro").modal("show");
          break;
        case "2":
          $.toast({
            heading: "Información!",
            text: "Sin datos",
            showHideTransition: "slide",
            icon: "info",
            position: "top-right",
          });
          break;
        default:
          break;
      }
    },
    complete: function () {
      setTimeout(() => {
        $(".overlayCargue").fadeOut("slow");
      }, 1000);
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
      idRegistro: id,
      status: status,
    },
    dataType: "json", //Si no se especifica jQuery automaticamente encontrará el tipo basado en el header del archivo llamado (pero toma mas tiempo en cargar, asi que especificalo)
    url: urlBase + "routes/empresas/status", //url a donde hacemos la peticion
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
          tablaEmpresas.clear().draw();
          break;
      }
    },
    error: function (xhr) {
      console.log(xhr);
      Command: toastr["error"](
        "Fallo la ejecucion de la funcion, por favor comunicate con soporte.",
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

function showModalRegistro() {
  $("#btnRegistro").show();
  $("#btnRegistro").text("Registrar Empresa");
  $("#btnRegistro").attr("onclick", "registrar('frmRegistro');");
  $("#ModalRegistro").modal("show");
}

function reset() {
  vercampos("#frmRegistro", 1);
  limpiarcampos("#frmRegistro");
  edit = false;
}
