<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Registro de Flete
                    <small class="m-0 text-muted">
                        Un registro es la información de la operación que realizo una maquinaria.
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
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="codFicha">Cod Ficha</label>
                            <input type="text" onKeyPress="if(this.value.length==12)return false;" class="form-control" id="codFicha" name="codFicha" placeholder="Codigo de la ficha del registro" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label">Placa o # de Registro:</label>
                            <select class="custom-select form-control" id="placa" name="placa">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Acuerdo de Flete o Ruta:</label>
                            <select class="custom-select form-control" id="acuerdo" name="acuerdo">
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
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="observacion">Observacion del Material</label>
                            <textarea onKeyPress="if(this.value.length==1000)return false;" class="form-control" id="observacion" name="observacion" rows="5" style="height: 77px;" required></textarea>
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