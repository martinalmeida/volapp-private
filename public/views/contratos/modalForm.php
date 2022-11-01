<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Contratos
                    <small class="m-0 text-muted">
                        Un contrato es la alianza que hace un tercero con la empresa prestadora del servicio de carga pesada.
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistro">
                    <div class="form-row">
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="nombre">Nombres del Contrato</label>
                            <input type="text" onKeyPress="if(this.value.length==50)return false;" class="form-control" id="nombre" name="nombre" placeholder="Nombres del material" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="telefono">Telefono del Contrato</label>
                            <input type="tel" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="telefono" name="telefono" placeholder="Nombres del material" required>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label class="form-label" for="email"> del Contrato</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="email" name="email" placeholder="Nombres del material" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="descripcion">Descripción del Contrato</label>
                            <textarea onKeyPress="if(this.value.length==1000)return false;" class="form-control" id="descripcion" name="descripcion" rows="5" style="height: 77px;" required></textarea>
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