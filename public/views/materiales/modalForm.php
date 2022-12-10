<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Material
                    <small class="m-0 text-muted">
                        El material a transportar es la carga que lleva el vehiculo.
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
                            <label class="form-label" for="nombre">Nombres del Material</label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="nombre" name="nombre" placeholder="Nombres del material" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="descripcion">Descripción del Material</label>
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