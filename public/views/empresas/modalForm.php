<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Empresa
                    <small class="m-0 text-muted">
                        Las empresas pueden ser organizaciones o personas juridicas.
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
                            <label class="form-label" for="nit">NIT</label>
                            <input type="number" onKeyPress="if(this.value.length==20)return false;" min="0" class="form-control" id="nit" name="nit" placeholder="Nit de empresa" required>
                        </div>
                        <div class="col-md-2 mb-3">
                            <label class="form-label" for="digito">Digito</label>
                            <input type="number" onKeyPress="if(this.value.length==1)return false;" min="0" class="form-control" id="digito" name="digito" placeholder="Digito" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="nombre">Nombre</label>
                            <div class="input-group">
                                <input type="text" onKeyPress="if(this.value.length==55)return false;" min="0" class="form-control" id="nombre" name="nombre" placeholder="Nombre de Empresa" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="representante">Representante</label>
                            <input type="text" onKeyPress="if(this.value.length==55)return false;" min="0" class="form-control" id="representante" name="representante" placeholder="Representante Legal" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="telefono">Numero de Telefono</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" min="0" class="form-control" id="telefono" name="telefono" placeholder="Numero de contacto" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="direccion">Dirección</label>
                            <input type="text" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control" id="direccion" name="direccion" placeholder="Dirección" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="correo">Correo Electronico</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control" id="correo" name="correo" placeholder="Correo Electronico de la empresa" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="contacto">Numero de Contacto</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" min="0" class="form-control" id="contacto" name="contacto" placeholder="Numero de contacto" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="emailTec">Correo Electronico Tecnico</label>
                            <input type="text" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control" id="emailTec" name="emailTec" placeholder="Correo Electronico Tecnico" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="emailLogis">Correo Electronico Logistica</label>
                            <input type="text" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control" id="emailLogis" name="emailLogis" placeholder="Correo Electronico Logistica" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <div id="imagenBase64"></div>
                        <label class="form-label" for="logo">Logo de la empresa</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/png" required>
                                <label class="custom-file-label" for="logo">Adjuntar Logo</label>
                            </div>
                        </div>
                        <span class="help-block">Foto del logo de la empresa en formato png.</span>
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