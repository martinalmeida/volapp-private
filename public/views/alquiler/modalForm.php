<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Acuerdo de Alquiler
                    <small class="m-0 text-muted">
                        Puedes asignar a una misma placa a varios acuerdos(rutas).
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistro">
                    <div id="alertaFormInsert"></div>
                    <div class="form-row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Placa o # de Registro:</label>
                            <select class="custom-select form-control" id="placaInsertInsert" name="placaInsertInsert">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asignar Contrato:</label>
                            <select class="custom-select form-control" id="contratoInsertInsert" name="contratoInsertInsert">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="standByInsert">Stand-By(horas minimas de trabajo por mes):</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="standByInsert" name="standByInsert" placeholder="Stand By (12.5)" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tarifaInsert">Valor de tarifa por hora:</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="tarifaInsert" name="tarifaInsert" placeholder="Tarifa por hora (100000.80)" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-info active" id="btnRegistro"></button>
            </div>
        </div>
    </div>
</div>