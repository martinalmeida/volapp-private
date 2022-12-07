<div class="modal fade default-example-modal-right-sm" id="ModalDeducibles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-right modal-sm">
        <div class="modal-content modal-dialog-scrollable">
            <div class="modal-header">
                <h5 class="modal-title">
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmRegistroDescontable">
                    <div id="alertaFormDeducible"></div>
                    <div class="form-row">

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="hidden" id="idRegistro" name="idRegistro">
                            <input type="checkbox" class="custom-control-input" id="check1">
                            <label class=" custom-control-label" for="check1">DEDUCIBLE DE ADMINISTRACIÓN</label>
                            <div class="col-md-12" id="uno">
                                <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="admon" name="admon" placeholder="Administración" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check2">
                            <label class=" custom-control-label" for="check2">RETENCIÓN EN LA FUENTE</label>
                            <div class="col-md-12" id="dos">
                                <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="retefuente" name="retefuente" placeholder="Retención en la fuente" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check3">
                            <label class=" custom-control-label" for="check3">DEDUCIBLE RETEICA</label>
                            <div class="col-md-12" id="tres">
                                <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="reteica" name="reteica" placeholder="Deducible de reteica" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check4">
                            <label class=" custom-control-label" for="check4">DEDUCIBLE DE ANTICIPO</label>
                            <div class="col-md-12" id="cuatro">
                                <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="anticipo" name="anticipo" placeholder="Deducible de anticipo" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check5">
                            <label class=" custom-control-label" for="check5">OTROS DEDUCIBLES</label>
                            <div class="col-md-12" id="cinco">
                                <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="otros" name="otros" placeholder="Otros deducibles" required>
                                <label class="form-label" for="observacionDeducible">Observación:</label>
                                <textarea onKeyPress="if(this.value.length==1000)return false;" class="form-control" id="observacionDeducible" name="observacionDeducible" rows="5" style="height: 77px;" required></textarea>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnRegistroDescontable"></button>
            </div>
        </div>
    </div>
</div>