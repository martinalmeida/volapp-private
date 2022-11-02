<div class="modal fade" id="ModalAsignarTarifa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Asignar Kilometraje
                    <small class="m-0 text-muted">
                        En esta modal puedes gestionar los kilometrajes para cada contrato a la hora de facturar.
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistroAsignar">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label">Contrato</label>
                            <select class="custom-select form-control" id="contrato" name="contrato">
                            </select>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="kilometraje">Kilometraje</label>
                            <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="kilometraje" name="kilometraje" placeholder="Kilometraje para este contrato" required>
                        </div>

                        <div id="inputsEditarAsignar">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnRegistroAsignar"></button>
            </div>
        </div>
    </div>
</div>