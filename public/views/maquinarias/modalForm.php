<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Maquinaria
                    <small class="m-0 text-muted">
                        La maquinaria puede ser pesada o de construcción.
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
                            <label class="form-label" for="nombre">Nombre de la Maquinaria</label>
                            <input type="text" onKeyPress="if(this.value.length==70)return false;" class="form-control" id="nombre" name="nombre" placeholder="Nombre detallado de la Maquinaria" required>
                        </div>
                        <div class="input-group col-md-4 mb-3">
                            <input type="text" class="form-control" id="fechaSoat" name="fechaSoat" placeholder="Fecha de vencimiento del SOAT" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group col-md-4 mb-3">
                            <input type="text" class="form-control" id="fechaLicencia" name="fechaLicencia" placeholder="Fecha de vencimiento de Licencia" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group col-md-4 mb-3">
                            <input type="text" class="form-control" id="fecchaTdr" name="fecchaTdr" placeholder="Fecha de vencimiento del Seguro Todo Riesgo" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="archivoBase64"></div>
                            <label class="form-label" for="archivo">Documentación de la Maquinaria</label>
                            <div class="input-group">
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".pdf" required>
                                    <label class="custom-file-label" for="archivo">Adjuntar Archido de Documentacón</label>
                                </div>
                            </div>
                            <span class="help-block">Archivo de documentación formato pdf.</span>
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