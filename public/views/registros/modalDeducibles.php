<div class="modal fade" id="ModalDeducibles" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Deducible
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

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check1">
                            <label class=" custom-control-label" for="check1">COMBUSTIBLE SUMINISTRADO POR CLIENTE</label>
                            <div class="col-md-12" id="uno">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="combustible" name="combustible" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check2">
                            <label class=" custom-control-label" for="check2">RETENCIÓN DE GARANTIA</label>
                            <div class="col-md-12" id="dos">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check3">
                            <label class=" custom-control-label" for="check3">DEDUCIBLE DE POLIZA</label>
                            <div class="col-md-12" id="tres">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="poliza" name="poliza" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check4">
                            <label class=" custom-control-label" for="check4">DEDUCIBLE DE ADMINISTRACIÓN</label>
                            <div class="col-md-12" id="cuatro">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="administracion" name="administracion" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check5">
                            <label class=" custom-control-label" for="check5">RETENCIÓN EN LA FUENTE</label>
                            <div class="col-md-12" id="cinco">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check6">
                            <label class=" custom-control-label" for="check6">RETEICA</label>
                            <div class="col-md-12" id="seis">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check7">
                            <label class=" custom-control-label" for="check7">COMBUSTIBLE SUMINISTRADO POR COOSERSUM</label>
                            <div class="col-md-12" id="siete">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check8">
                            <label class=" custom-control-label" for="check8">SEGURIDAD SOCIAL</label>
                            <div class="col-md-12" id="ocho">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check9">
                            <label class=" custom-control-label" for="check9">PRESTACIONES SOCIALES</label>
                            <div class="col-md-12" id="nueve">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check10">
                            <label class=" custom-control-label" for="check10">DEDUCIBLE DE ANTICIPO</label>
                            <div class="col-md-12" id="diez">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check11">
                            <label class=" custom-control-label" for="check11">NOMINA DEL CONDUCTOR</label>
                            <div class="col-md-12" id="once">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check12">
                            <label class=" custom-control-label" for="check12">DOTACIÓN</label>
                            <div class="col-md-12" id="doce">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check13">
                            <label class=" custom-control-label" for="check13">LLANTAS</label>
                            <div class="col-md-12" id="trece">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check14">
                            <label class=" custom-control-label" for="check14">MONITOREO</label>
                            <div class="col-md-12" id="catorce">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check15">
                            <label class=" custom-control-label" for="check15">HORAS EXTRAS</label>
                            <div class="col-md-12" id="quince">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check16">
                            <label class=" custom-control-label" for="check16">PERMISO ESPECIAL</label>
                            <div class="col-md-12" id="diezyseis">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check17">
                            <label class=" custom-control-label" for="check17">REVISION PREVENTIVA</label>
                            <div class="col-md-12" id="diezysiete">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check18">
                            <label class=" custom-control-label" for="check18">EXAMENES MEDICOS</label>
                            <div class="col-md-12" id="diezocho">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check19">
                            <label class=" custom-control-label" for="check19">CURSOS</label>
                            <div class="col-md-12" id="diezynueve">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check20">
                            <label class=" custom-control-label" for="check20">INSTALACION DEL GPS</label>
                            <div class="col-md-12" id="veinte">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
                            </div>
                        </div>

                        <div class="custom-control custom-checkbox custom-checkbox-circle m-3">
                            <input type="checkbox" class="custom-control-input" id="check21">
                            <label class=" custom-control-label" for="check21">PAPELERIA</label>
                            <div class="col-md-12" id="veinteyuno">
                                <input type="number" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="retegarantia" name="retegarantia" placeholder="Deducible de combustible" required>
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