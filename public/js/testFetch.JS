var tableUsuarios;
document.addEventListener(
  "DOMContentLoaded",
  function () {
    tableUsuarios = $("#tableUsuarios").dataTable({
      /* "aProcessing":true,
        "aServerSide":true,*/
      responsive: true,
      lengthChange: false,
      /*        "language": {
            "url": "//cdn.datatables.net/plug-ins/1.10.20/i18n/Spanish.json",
        },*/
      ajax: {
        url: " " + base_url + "/Usuarios/getUsuarios",
        dataSrc: "",
      },
      columns: [
        { data: "idpersona" },
        { data: "nombres" },
        { data: "apellidos" },
        { data: "email_user" },
        { data: "telefono" },
        { data: "nombrerol" },
        { data: "status" },
        { data: "options" },
      ],
      dom:
        "<'row mb-3'<'col-sm-12 col-md-6 d-flex align-items-center justify-content-start'f><'col-sm-12 col-md-6 d-flex align-items-center justify-content-end'lB>>" +
        "<'row'<'col-sm-12'tr>>" +
        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

      buttons: [
        /* {
                 extend:    'colvis',
                 text:      'Column Visibility',
                 titleAttr: 'Col visibility',
                 className: 'mr-sm-3'
             },*/
        {
          extend: "pdfHtml5",
          text: "<i class='fal fa-file-pdf'></i> PDF",
          titleAttr: "Generar PDF",
          className: "btn-outline-danger btn-sm mr-1",
        },
        {
          extend: "excelHtml5",
          text: "<i class='fal fa-file-excel'></i> Excel",
          titleAttr: "Generar Excel",
          className: "btn-outline-success btn-sm mr-1",
        },
        {
          extend: "csvHtml5",
          text: "<i class='fal fa-file-csv'></i> CSV",
          titleAttr: "Generar CSV",
          className: "btn-outline-primary btn-sm mr-1",
        },
        {
          extend: "copyHtml5",
          text: "<i class='fal fa-copy'></i> Copiar",
          titleAttr: "Copiar al portapapeles",
          className: "btn-outline-primary btn-sm mr-1",
        },
        {
          extend: "print",
          text: "<i class='fal fa-solid fa-print'></i> Print",
          titleAttr: "Imprimir tabla",
          className: "btn-outline-primary btn-sm",
        },
      ],

      responsive: true,
      bDestroy: true,
      iDisplayLength: 10,
      order: [[0, "desc"]],
    });
  },
  false
);

//INSERTAR USUARIO VIA FETCH ASYNC //

let formularioUser = document.getElementById("formUsuario");
formularioUser.addEventListener("submit", function (e) {
  e.preventDefault();

  let formData = new FormData(formUsuario);
  let fetchUrl = base_url + "/USuarios/setUsuario";
  fetch(fetchUrl, {
    method: "POST",
    body: formData,
  })
    .then((response) => response.json())
    .then((objData) => {
      if (objData.status) {
        $("#modalFormUsuario").modal("hide");
        formUsuario.reset();
        tableUsuarios.api().ajax.reload(function () {});
        swal.fire("Usuarios", objData.msg, "success");
      } else {
        swal.fire("Error", objData.msg, "error");
      }
    })
    .catch((error) => {
      swal.fire(
        "Ops!",
        "Ocurrio un error en el sistema,  por favor intentalo de nuevo más tarde.",
        "error"
      );
      console.log("Error: ", error);
    });
});

window.addEventListener(
  "load",
  function () {
    fntRolesUsuario();
    /*fntViewUsuario();
    fntEditUsuario();
    fntDelUsuario();*/
  },
  false
);

/* cargar combo de roles */
function fntRolesUsuario() {
  var ajaxUrl = base_url + "/Roles/getSelectRoles";
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  request.open("GET", ajaxUrl, true);
  request.send();

  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      document.querySelector("#listRolid").innerHTML = request.responseText;
      document.querySelector("#listRolid").value = 1;
      $("#listRolid").selectpicker("render");
    }
  };
}

/*===== CARGAR DATOS AL MODAL DE EDITAR =====*/
function fntViewUsuario(idpersona) {
  var idpersona = idpersona;
  //alert(idpersona);
  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = base_url + "/Usuarios/getUsuario/" + idpersona;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);

      if (objData.status) {
        var estadoUsuario =
          objData.data.status == 1
            ? '<span class="badge badge-success">Activo</span>'
            : '<span class="badge badge-danger">Inactivo</span>';

        document.querySelector("#celIdentificacion").innerHTML =
          objData.data.identificacion;
        document.querySelector("#celNombre").innerHTML = objData.data.nombres;
        document.querySelector("#celApellido").innerHTML =
          objData.data.a_paterno + " " + objData.data.a_materno;
        document.querySelector("#celTelefono").innerHTML =
          objData.data.telefono;
        document.querySelector("#celEmail").innerHTML = objData.data.email_user;
        document.querySelector("#celTipoUsuario").innerHTML =
          objData.data.nombrerol;
        document.querySelector("#celEstado").innerHTML = estadoUsuario;
        document.querySelector("#celFechaRegistro").innerHTML =
          objData.data.fechaRegistro;
        $("#modalViewUser").modal("show");
      } else {
        swal.fire("Error", objData.msg, "error");
      }
    }
  };
}

/* =========== UPDATE USUARIO ==========*/

function fntEditUsuario(idpersona) {
  document.querySelector("#titleModal").innerHTML = "Actualizar usuario";
  document
    .querySelector(".modal-header")
    .classList.replace("headerRegister", "headerUpdate");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-info", "btn-primary");
  document.querySelector("#btnText").innerHTML = "Actualizar";
  $("#modalFormUsuario").modal("show");
  var idusuario = idpersona;

  var request = window.XMLHttpRequest
    ? new XMLHttpRequest()
    : new ActiveXObject("Microsoft.XMLHTTP");
  var ajaxUrl = base_url + "/Usuarios/getUsuario/" + idpersona;
  request.open("GET", ajaxUrl, true);
  request.send();
  request.onreadystatechange = function () {
    if (request.readyState == 4 && request.status == 200) {
      var objData = JSON.parse(request.responseText);
      document.querySelector("#idUsuario").value = idpersona;
      document.querySelector("#txtIdentificacion").value =
        objData.data.identificacion;
      document.querySelector("#txtNombre").value = objData.data.nombres;
      document.querySelector("#txtPaterno").value = objData.data.a_paterno;
      document.querySelector("#txtMaterno").value = objData.data.a_materno;
      document.querySelector("#txtTelefono").value = objData.data.telefono;
      document.querySelector("#txtEmail").value = objData.data.email_user;
      document.querySelector("#listStatus").value = objData.data.status;
      /*$('#listRolid').selectpicker('render');

            if(objData.data.status == 1){
                document.querySelector("#listStatus").value = 1;
            }else{
                document.querySelector("#listStatus").value = 2;
            }
            $('#listStatus').selectpicker('render');*/
    }
  };
}

function fntDelUsuario(idpersona) {
  let idUsuario = idpersona;
  // alert(idUsuario);

  var swalWithBootstrapButtons = Swal.mixin({
    customClass: {
      confirmButton: "btn btn-primary",
      cancelButton: "btn btn-danger mr-2",
    },
    buttonsStyling: false,
  });
  swalWithBootstrapButtons
    .fire({
      title: "Eliminar usuario",
      text: "¿Realmente quiere eliminar el Usuario?",
      type: "warning",
      showCancelButton: true,
      confirmButtonText: "Si, Eliminar!",
      cancelButtonText: "No, cancelar!",
      reverseButtons: true,
    })
    .then(function (result) {
      if (result.value) {
        var request = window.XMLHttpRequest
          ? new XMLHttpRequest()
          : new ActiveXObject("Microsoft.XMLHTTP");
        var ajaxUrl = base_url + "/Usuarios/delUsuario";
        var strData = "idUsuario=" + idUsuario;
        request.open("POST", ajaxUrl, true);
        request.setRequestHeader(
          "Content-type",
          "application/x-www-form-urlencoded"
        );
        request.send(strData);
        request.onreadystatechange = function () {
          request.onreadystatechange = function () {
            if (request.readyState == 4 && request.status == 200) {
              var objData = JSON.parse(request.responseText);
              if (objData.status) {
                tableUsuarios.api().ajax.reload(function () {
                  fntRolesUsuario();
                  swal("Eliminar!", objData.msg, "success");
                  //fntViewUsuario();
                  //fntEditUsuario();
                  //fntDelUsuario();
                });
                swalWithBootstrapButtons.fire(
                  "Eliminar!",
                  objData.msg,
                  "success"
                );
              } else {
                swal("Atención!", objData.msg, "error");
              }
            }
          };
        };
      } else if (
        // Read more about handling dismissals
        result.dismiss === Swal.DismissReason.cancel
      ) {
        swalWithBootstrapButtons.fire(
          "Cancelado",
          "El registro esta a salvo :)",
          "error"
        );
      }
    });
  // A message with a custom image and CSS animation disabled
}
function openModal() {
  document.querySelector("#idUsuario").value = "";
  document
    .querySelector(".modal-header")
    .classList.replace("headerUpdate", "headerRegister");
  document
    .querySelector("#btnActionForm")
    .classList.replace("btn-primary", "btn-info");
  document.querySelector("#btnText").innerHTML = "Guardar";
  document.querySelector("#titleModal").innerHTML = "Nuevo Usuario";
  document.querySelector("#formUsuario").reset();
  $("#modalFormUsuario").modal("show");
}
