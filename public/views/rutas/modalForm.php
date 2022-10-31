<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Placas
                    <small class="m-0 text-muted">
                        Una placa es un vehiculo de carga pesada.
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistro">
                    <div class="form-row">
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="placa">Placa del Vehiculo</label>
                            <input type="text" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="placa" name="placa" placeholder="Placa del vehiculo" required>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="nombresConductor">Nombres del Conductor</label>
                            <input type="text" onKeyPress="if(this.value.length==50)return false;" class="form-control" id="nombresConductor" name="nombresConductor" placeholder="Nombres del conductor del vehiculo" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Apaterno">Apellido Paterno</label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="Apaterno" name="Apaterno" placeholder="Apellidos paternos" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Amaterno">Apellido Materno</label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="Amaterno" name="Amaterno" placeholder="Apellidos maternos" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="telefono">Telefono</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="telefono" name="telefono" placeholder="Numero Telefonico" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Correo Electronico</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="email" name="email" placeholder="Correo electronico" required>
                        </div>

                        <div id="inputsEditar">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnRegistro"></button>
            </div>
        </div>
    </div>
</div>