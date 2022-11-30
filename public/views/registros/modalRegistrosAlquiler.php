<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Registro de ALlquiler
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
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="codFicha">Cod Ficha</label>
                            <input type="text" onKeyPress="if(this.value.length==7)return false;" class="form-control" id="codFicha" name="codFicha" placeholder="Codigo de la ficha del registro" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="horas">Horas Trabajadas:</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="horas" name="horas" placeholder="Horas trabajadas (8.5)" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Placa o # de Registro:</label>
                            <select class="custom-select form-control" id="placa" name="placa">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Acuerdo de Alquiler:</label>
                            <select class="custom-select form-control" id="contrato" name="contrato">
                            </select>
                        </div>
                        <div class="input-group col-md-6 mb-3">
                            <input type="text" class="form-control" id="fechaInicial" name="fechaInicial" placeholder="Fecha de Inicio" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group col-md-6 mb-3">
                            <input type="text" class="form-control" id="fechaFinal" name="fechaFinal" placeholder="Fecha Final" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
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