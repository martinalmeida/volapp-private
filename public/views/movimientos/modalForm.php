<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Rutas
                    <small class="m-0 text-muted">
                        La tarifa asignada a la ruta es la que se le cobra al contrato.
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
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="nombre">Nombre de la Ruta</label>
                            <input type="text" onKeyPress="if(this.value.length==50)return false;" class="form-control" id="nombre" name="nombre" placeholder="Nombre de la ruta" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="origen">Origen de la Ruta</label>
                            <input type="text" onKeyPress="if(this.value.length==50)return false;" class="form-control" id="origen" name="origen" placeholder="Nombre de la ruta" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="destino">Destino de la Ruta</label>
                            <input type="text" onKeyPress="if(this.value.length==50)return false;" class="form-control" id="destino" name="destino" placeholder="Nombre de la ruta" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asignar Contrato para esta ruta</label>
                            <select class="custom-select form-control" id="contrato" name="contrato">
                            </select>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="kilometraje">kilometraje de Ruta</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="kilometraje" name="kilometraje" placeholder="Kilometraje de la ruta" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="tarifa">Tarifa de la Ruta</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="tarifa" name="tarifa" placeholder="Tarifa de la ruta" required>
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