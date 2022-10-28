<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Sucursal
                    <small class="m-0 text-muted">
                        Una sucursal es una cede de una empresa.
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistro">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="descripcion">Descripción de la Sucursal</label>
                            <textarea onKeyPress="if(this.value.length==1000)return false;" class="form-control" id="descripcion" name="descripcion" rows="5" style="height: 77px;" required></textarea>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="direccion">Dirección</label>
                            <input type="text" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="direccion" name="direccion" placeholder="Dirección de la sucursal" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="telefono">Telefono</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="telefono" name="telefono" placeholder="Telefono de la sucursal" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="email">Correo Electronico</label>
                            <input type="text" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="email" name="email" placeholder="Correo electronico" required>
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