<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Registro
                    <small class="m-0 text-muted">
                        Un registro es la información de un viaje que hizo un vehiculo.
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
                            <label class="form-label">Placa</label>
                            <select class="custom-select form-control" id="placa" name="placa">
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Ruta</label>
                            <select class="custom-select form-control" id="ruta" name="ruta">
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Material</label>
                            <select class="custom-select form-control" id="material" name="material">
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="nota">Nota para este registro</label>
                            <textarea onKeyPress="if(this.value.length==1000)return false;" class="form-control" id="nota" name="nota" rows="5" style="height: 77px;" required></textarea>
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