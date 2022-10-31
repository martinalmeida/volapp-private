<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Usuario
                    <small class="m-0 text-muted">
                        Los usuarios dependen de una empresa directatente y segun su rol pertenecen a una sucursal o no.
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
                            <label class="form-label" for="identificacion">Identificacion</label>
                            <input type="number" onKeyPress="if(this.value.length==50)return false;" min="0" class="form-control" id="identificacion" name="identificacion" placeholder="Identificación del usuario" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nombres">Nombres</label>
                            <div class="input-group">
                                <input type="text" onKeyPress="if(this.value.length==50)return false;" min="0" class="form-control" id="nombres" name="nombres" placeholder="Nombres del usuario" required>
                            </div>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="Apaterno">Apellido Paterno</label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" min="0" class="form-control" id="Apaterno" name="Apaterno" placeholder="Apellido Paterno" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="Amaterno">Apellido Materno</label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" min="0" class="form-control" id="Amaterno" name="Amaterno" placeholder="Apellido Materno" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="telefono">Telefono</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" min="0" class="form-control" id="telefono" name="telefono" placeholder="Telefono" required>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="emailUser">Correo Electronico</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control" id="emailUser" name="emailUser" placeholder="Correo Electronico del usuario" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="pswd">Contraseña</label>
                            <input type="text" onKeyPress="if(this.value.length==20)return false;" min="0" class="form-control" id="pswd" name="pswd" placeholder="Contraseña" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="nombreFiscal">Nombre Fiscal</label>
                            <input type="text" onKeyPress="if(this.value.length==81)return false;" min="0" class="form-control" id="nombreFiscal" name="nombreFiscal" placeholder="Nombre fiscal del usuario" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="direccionFiscal">Dirección Fiscal</label>
                            <input type="text" onKeyPress="if(this.value.length==100)return false;" min="0" class="form-control" id="direccionFiscal" name="direccionFiscal" placeholder="Dirección fiscal del usuario" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Sucursal</label>
                            <select class="custom-select form-control" id="sucursal" name="sucursal">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Rol Usuario</label>
                            <select class="custom-select form-control" id="rol" name="rol">
                            </select>
                        </div>
                    </div>
                    <div class="form-group">

                        <div id="imagenBase64">

                        </div>

                        <label class="form-label" for="logo">Foto de Usuario</label>
                        <div class="input-group">

                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="logo" name="logo" accept="image/png" required>
                                <label class="custom-file-label" for="logo">Adjuntar Foto del Usuario</label>
                            </div>
                        </div>
                        <span class="help-block">Foto del usuario en formato png.</span>
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