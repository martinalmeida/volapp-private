<div class="modal fade" id="ModalDescontables" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Descontables
                    <small class="m-0 text-muted">
                        Los descontables son prestamos que le hace la empresa a los socios.
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistroDescontable">
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="gasolina">Combustible</label>
                            <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="gasolina" name="gasolina" placeholder="Combustible" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="peaje">Peaje</label>
                            <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="peaje" name="peaje" placeholder="Peaje" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="repuestos">Repuestos</label>
                            <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="repuestos" name="repuestos" placeholder="Repuestos" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="otros">Otros</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="otros" name="otros" placeholder="Otros" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="notaDescontable">Nota para este Descontable</label>
                            <textarea onKeyPress="if(this.value.length==1000)return false;" class="form-control" id="notaDescontable" name="notaDescontable" rows="5" style="height: 77px;" required></textarea>
                        </div>

                        <div id="inputsEditarDescontables">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" id="btnRegistroDescontable"></button>
            </div>
        </div>
    </div>
</div>