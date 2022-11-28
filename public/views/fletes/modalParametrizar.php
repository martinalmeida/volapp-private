<div class="modal fade" id="ModalParametrizar" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Parametrizar Maquinaria
                    <small class="m-0 text-muted">
                        Al parametrizar los valores de esta maquinaria, estara lista para entrar a operar en la plataforma.
                    </small>
                </h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true"><i class="fal fa-times"></i></span>
                </button>
            </div>
            <div class="modal-body">
                <form id="frmParametrizar">
                    <div id="alertaForm"></div>
                    <div class="form-row">
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="id">Id Alquiler:</label>
                            <input type="text" class="form-control" id="id" disabled>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="placa">Placa o # de Registro:</label>
                            <input type="text" class="form-control" id="placa" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="tipo">Tipo de Maquinaria:</label>
                            <input type="text" class="form-control" id="tipo" disabled>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Asignar Ruta:</label>
                            <select class="custom-select form-control" id="ruta" name="ruta">
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="flete">Valor del Flete:</label>
                            <input type="text" onkeypress="return filterFloat(event,this);" class="form-control" id="flete" name="flete" placeholder="valor del flete (1200000.60)" required>
                        </div>

                        <div id="inputsParametrizar">
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                <button type="button" class="btn btn-primary" id="btnParametrizar"></button>
            </div>
        </div>
    </div>
</div>