<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Valores al Vehiculo
                    <small class="m-0 text-muted">
                        Se asignan los valosres correspondientes al vehiculo.
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistro">
                    <div id="alertaForm"></div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asignar Vehiculo</label>
                            <select class="custom-select form-control" id="vehiculo" name="vehiculo">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asignar Ruta</label>
                            <select class="custom-select form-control" id="ruta" name="ruta">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="kilometraje">kilometraje de Ruta</label>
                            <input type="number" onKeyPress="if(this.value.length==9)return false;" class="form-control" id="kilometraje" name="kilometraje" placeholder="Kilometraje de la ruta" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tarifa">Tarifa de la Ruta</label>
                            <input type="number" onKeyPress="if(this.value.length==9)return false;" class="form-control" id="tarifa" name="tarifa" placeholder="Tarifa de la ruta" required>
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