<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Contratos
                    <small class="m-0 text-muted">
                        Un contrato es la alianza que hace un tercero con la empresa.
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
                        <div class="input-group col-md-6 mb-3">
                            <input type="text" class="form-control" id="fechaInicio" name="fechaInicio" placeholder="Fecha de inicio del Contrato" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group col-md-6 mb-3">
                            <input type="text" class="form-control" id="fechaFin" name="fechaFin" placeholder="Fecha de vencimiento del Contrato" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="titulo">Titulo del Contrato</label>
                            <input type="text" onKeyPress="if(this.value.length==50)return false;" class="form-control" id="titulo" name="titulo" placeholder="Nombres del contrato" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="representante">Representante del Contrato</label>
                            <input type="text" onKeyPress="if(this.value.length==70)return false;" class="form-control" id="representante" name="representante" placeholder="Represente del contrato" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="telefono">Telefono de Contacto</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="telefono" name="telefono" placeholder="Telefono de Contacto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Correo de Contacto</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="email" name="email" placeholder="Correo de Contacto del contrato" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="archivoBase64"></div>
                            <label class="form-label" for="archivo">Documentación del Contrato</label>
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
                <a class="text-dark" target="_blank" href="https://www.adobe.com/acrobat/online/compress-pdf.html">Ir a pagina de compresion de documentos PDF <i class="fal fa-file-pdf fa-1x"></i></a>
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnRegistro"></button>
            </div>
        </div>
    </div>
</div>