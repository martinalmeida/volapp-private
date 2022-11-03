<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Vehiculo
                    <small class="m-0 text-muted">
                        Un vehiculo puede ser un automotor secillo, tractomula, doble troque, etc...
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
                            <label class="form-label" for="placa">Placa del Vehiculo</label>
                            <input type="text" onKeyPress="if(this.value.length==7)return false;" class="form-control" id="placa" name="placa" placeholder="Placa del vehiculo" required>
                        </div>
                        <div class="col-md-9 mb-3">
                            <label class="form-label" for="nombresConductor">Nombre Completo del Conductor</label>
                            <input type="text" onKeyPress="if(this.value.length==160)return false;" class="form-control" id="nombresConductor" name="nombresConductor" placeholder="Nombres y Apellidos del conductor del vehiculo" required>
                        </div>
                        <!-- <div class="col-md-6 mb-3">
                            <label class="form-label" for="Apaterno">Apellido Paterno</label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="Apaterno" name="Apaterno" placeholder="Apellidos paternos" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="Amaterno">Apellido Materno</label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="Amaterno" name="Amaterno" placeholder="Apellidos maternos" required>
                        </div> -->
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="telefono">Telefono</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="telefono" name="telefono" placeholder="Numero Telefonico" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="email">Correo Electronico</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="email" name="email" placeholder="Correo electronico" required>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="fechaSoat" name="fechaSoat" placeholder="Fecha de vencimiento del SOAT" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-check"></i>
                            </span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="fechaLicencia" name="fechaLicencia" placeholder="Fecha de vencimiento de Licencia" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-check"></i>
                            </span>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" id="fecchaTdr" name="fecchaTdr" placeholder="Fecha de vencimiento del Seguro Todo Riesgo" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                        <div class="input-group-append">
                            <span class="input-group-text fs-xl">
                                <i class="fal fa-calendar-check"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="archivoBase64"></div>
                        <label class="form-label" for="archivo">Documentación del Vehiculo</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="archivo" name="archivo" accept=".pdf" required>
                                <label class="custom-file-label" for="archivo">Adjuntar Archido de Documentacón</label>
                            </div>
                        </div>
                        <span class="help-block">Archivo de documentación formato pdf.</span>
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