var permisos = null;
var tablaInforme = "";
var controls = {
  leftArrow: '<i class="fal fa-angle-left" style="font-size: 1.25rem"></i>',
  rightArrow: '<i class="fal fa-angle-right" style="font-size: 1.25rem"></i>',
};
var runDatePicker = function () {
  $("#fechaInicio").datepicker({
    orientation: "buttom left",
    todayHighlight: true,
    templates: controls,
  });
  $("#fechaFin").datepicker({
    orientation: "buttom left",
    todayHighlight: true,
    templates: controls,
  });
};

$(document).ready(function () {
  readPermisos();
  permisos === true ? $("#relacionRender").html("") : formRelacion();
  runDatePicker();
  writePermisos();
  selects();
  $(":input").inputmask();
  $("#placa").select2({
    placeholder: "Seleccione la placa o # de registro",
    allowClear: true,
  });
  $("#contrato").select2({
    placeholder: "Seleccione el contrato",
    allowClear: true,
  });
});

function readPermisos() {
  $.ajax({
    dataType: "json",
    url: urlBase + "routes/informesRelacionProovedor/read",
    type: "GET",
    beforeSend: function () {},
    success: function (result) {
      if (result.data == 1) {
        $("#panel-1").show();
        permisos = true;
      } else {
        $("#panel-1").hide();
        permisos = false;
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
    url: urlBase + "routes/informesRelacionProovedor/write",
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
    url: urlBase + "routes/selects/getVehiculo", //url a donde hacemos la peticion
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
          $("#placa").html(html);
          setTimeout(() => {
            $("#placa").val("").trigger("change");
          }, 10);
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
          setTimeout(() => {
            $("#contrato").val("").trigger("change");
          }, 10);
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

function formRelacion() {
  var html = "";

  html +=
    '<form id="frmRelacion"><div class="form-row">' +
    '<div class="col-md-3 mb-3"><select class="custom-select form-control" id="placa" name="placa"></select></div>' +
    '<div class="col-md-3 mb-3"><select class="custom-select form-control" id="contrato" name="contrato"></select></div>' +
    '<div class="input-group col-md-3 mb-3"><input type="text" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Fecha Inicial" ' +
    'data-inputmask="' +
    "'mask': '99/99/9999'" +
    '" im-insert="true">' +
    '<div class="input-group-append"><span class="input-group-text fs-xl"><i class="fal fa-calendar-check"></i></span></div></div>' +
    '<div class="input-group col-md-3 mb-3"><input type="text" class="form-control" id="fechaFin" name="fechaFin" placeholder="Fecha Final" ' +
    'data-inputmask="' +
    "'mask': '99/99/9999'" +
    '" im-insert="true">' +
    '<div class="input-group-append"><span class="input-group-text fs-xl"><i class="fal fa-calendar-check"></i></span></div></div></div></form>' +
    '<button type="button" id="btnGenerar" class="btn btn-success btn-pills btn-block waves-effect waves-themed">Generar la Relación por Alquiler para Proovedor <i class="fal fa-hand-holding-usd"></i></button>';

  $("#relacionRender").html(html);
  $("#btnGenerar").attr("onclick", "generaRelacion();");
}

function generaRelacion() {
  var html = "";

  html +=
    '<table id="tablaInforme" class="table table-bordered table-hover table-striped w-100"><thead class="bg-primary-600"><tr>' +
    "<th>ID</th>" +
    "<th>Placa o #Registro</th>" +
    "<th>fecha Inicio</th>" +
    "<th>fecha Fin</th>" +
    "<th>Titulo del Contrato</th>" +
    "<th>Horometro Inicial</th>" +
    "<th>Horometro Final</th>" +
    "<th>Total Horas Trabjadas</th>" +
    "<th>Stand-By</th>" +
    "<th>Valor Hora</th>" +
    "<th>Sub Total</th>" +
    "<th>Deducible Administración</th>" +
    "<th>Deducible Retefuente</th>" +
    "<th>Deducible Reteica</th>" +
    "<th>Deducible anticipo</th>" +
    "<th>Otros Deducible</th>" +
    "<th>Total</th>" +
    "<th>Observacion</th>" +
    "</tr></thead><tbody></tbody></table>";

  $("#relacionGenerada").html(html);

  let placa = $("#placa").val();
  let contrato = $("#contrato").val();
  let fechaInicio = $("#fechaInicio").val();
  let fechaFin = $("#fechaFin").val();

  tablaInforme = $("#tablaInforme").DataTable({
    processing: true,
    orderClasses: true,
    deferRender: true,
    serverSide: true,
    responsive: true,
    lengthChange: false,
    paging: false,
    columnDefs: [
      {
        targets: "_all",
        sortable: false,
      },
    ],
    searching: false,
    destroy: true,
    ajax: {
      url: urlBase + "routes/informesRelacionProovedor/relacionAlquiler",
      type: "POST",
      data: {
        placa: placa,
        contrato: contrato,
        fechaInicio: fechaInicio,
        fechaFin: fechaFin,
      },
      dataType: "json",
    },
    dom:
      "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
      "<'row'<'col-sm-12'tr>>" +
      "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
    buttons: [
      {
        extend: "excelHtml5",
        text: "Descargar <i class='fal fa-file-excel'></i>",
        titleAttr: "Generate Excel",
        className: "bg-success-900 btn-sm mr-1",
        messageTop:
          "Relación para pago por Alquiler de maquinarias a Proovedor",
        title: "Relación por Alquiler Proovedor",
      },
    ],
    columns: [
      { data: "id" },
      { data: "placa" },
      { data: "fechaInicio" },
      { data: "fechaFin" },
      { data: "titulo" },
      { data: "horometroInicial" },
      { data: "horometroFin" },
      { data: "totalHoras" },
      { data: "standby" },
      { data: "horaTarifa" },
      { data: "subTotal" },
      { data: "admon" },
      { data: "retefuente" },
      { data: "reteica" },
      { data: "anticipo" },
      { data: "otros" },
      { data: "total" },
      { data: "observacion" },
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

function reajustDatatables() {
  tablaInforme.columns.adjust().draw();
}
