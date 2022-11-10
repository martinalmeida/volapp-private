<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Equipo Menor
                    <small class="m-0 text-muted">
                        Un equipo menor es una maquina tal como una rana o equipo de topografia.
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
                            <label class="form-label" for="nombre">Nombre del Equipo Menor</label>
                            <input type="text" onKeyPress="if(this.value.length==70)return false;" class="form-control" id="nombre" name="nombre" placeholder="Nombre detallado del equipo menor" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="archivoBase64"></div>
                            <label class="form-label" for="archivo">Documentación del Equipo Menor</label>
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