<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Alquiler para Proovedor
                    <small class="m-0 text-muted">
                        En el modulo alquiler para proovedores se parametrizan los valores para el dueño unico de la maquinaria.
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
                            <label class="form-label">Placa o # de Registro:</label>
                            <select class="select2 custom-select form-control" id="placa" name="placa">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asignar Contrato:</label>
                            <select class="select2 custom-select form-control" id="contrato" name="contrato">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="standByInsert">Stand-By(horas minimas de trabajo por mes):</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="standby" name="standby" placeholder="Stand By (12.5)" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tarifaInsert">Valor de tarifa por hora:</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="horaTarifa" name="horaTarifa" placeholder="Tarifa por hora (100000.80)" required>
                        </div>

                        <div id="inputsEditar">
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