<div class="modal fade" id="ModalRegistro" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">
                    Agregar Maquinaria
                    <small class="m-0 text-muted">
                        La maquinaria puede ser equipos menores, vehiculos sencillos, de carga pesada, etc...
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
                        <div class="col-md-4 mb-3">
                            <label class="form-label">Equipo o clase: </label>
                            <select class="custom-select form-control" id="tpMaquinaria" name="tpMaquinaria">
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="placa">Placa o # de Registro: </label>
                            <input type="text" onKeyPress="if(this.value.length==20)return false;" class="form-control" id="placa" name="placa" placeholder="Placa o # de Registro" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="marca">Marca: </label>
                            <input type="text" onKeyPress="if(this.value.length==50)return false;" class="form-control" id="marca" name="marca" placeholder="Marca de maquinaria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="referencia">Referencia o linea: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="referencia" name="referencia" placeholder="Referencia de maquinaria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="modelo">Modelo: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="modelo" name="modelo" placeholder="Modelo de maquinaria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="color">Color: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="color" name="color" placeholder="Color de maquinaria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="capacidad">Capacidad o potencia: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="capacidad" name="capacidad" placeholder="Capacidad de maquinaria" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="nroSerie">No. Serie: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="nroSerie" name="nroSerie" placeholder="Numero de serie" required>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label class="form-label" for="nroSerieChasis">No. Serie de chasis: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="nroSerieChasis" name="nroSerieChasis" placeholder="Numero de serie de chasis" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="nroMotor">No. del motor: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="nroMotor" name="nroMotor" placeholder="Numero de motor" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="rodaje">Rodaje: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="rodaje" name="rodaje" placeholder="Rodaje de maquinaria" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="run">RUN: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="run" name="run" placeholder="Run de maquinaria" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="gps">GPS: </label>
                            <input type="text" onKeyPress="if(this.value.length==30)return false;" class="form-control" id="gps" name="gps" placeholder="GPS de maquinaria" required>
                        </div>

                        <div class="input-group col-md-6 mb-3">
                            <input type="text" class="form-control" id="fechaSoat" name="fechaSoat" placeholder="Fecha de vencimiento del SOAT" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="input-group col-md-6 mb-3">
                            <input type="text" class="form-control" id="fechaTecno" name="fechaTecno" placeholder="Fecha de vencimiento de Tecnocomecánica" data-inputmask="'mask': '99/99/9999'" im-insert="true">
                            <div class="input-group-append">
                                <span class="input-group-text fs-xl">
                                    <i class="fal fa-calendar-check"></i>
                                </span>
                            </div>
                        </div>
                        <div class="panel-tag col-md-12">
                            <p>Campos del propietario de maquinaria: </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="propietario">Propietario: </label>
                            <input type="text" onKeyPress="if(this.value.length==70)return false;" class="form-control" id="propietario" name="propietario" placeholder="Propietario de maquinaria" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="documentoPropietario">Nit o C.C: </label>
                            <input type="number" onKeyPress="if(this.value.length==15)return false;" class="form-control" id="documentoPropietario" name="documentoPropietario" placeholder="Nit o C.C propietario" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="telefonoPropietario">Teléfono:</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="telefonoPropietario" name="telefonoPropietario" placeholder="Teléfono de proietario" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="correoPropietario">Correo electronico de propietario:</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="correoPropietario" name="correoPropietario" placeholder="Correo electronico de propietario" required>
                        </div>
                        <div class="panel-tag col-md-12">
                            <p>Campos del operador o conductor de maquinaria: </p>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label" for="operador">Operador o Conductor: </label>
                            <input type="text" onKeyPress="if(this.value.length==70)return false;" class="form-control" id="operador" name="operador" placeholder="Operador o Coductor de maquinaria" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="documentOperador">Nit o C.C: </label>
                            <input type="number" onKeyPress="if(this.value.length==15)return false;" class="form-control" id="documentOperador" name="documentOperador" placeholder="Nit o C.C operador" required>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="form-label" for="telefonOperador">Teléfono:</label>
                            <input type="number" onKeyPress="if(this.value.length==10)return false;" class="form-control" id="telefonOperador" name="telefonOperador" placeholder="Teléfono de operador" required>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label" for="correOperador">Correo electronico de Operador o Conductor:</label>
                            <input type="email" onKeyPress="if(this.value.length==100)return false;" class="form-control" id="correOperador" name="correOperador" placeholder="Correo electronico de operador o conductor" required>
                        </div>
                        <div class="panel-tag col-md-12">
                            <p>Documentación de maquinaria: </p>
                        </div>
                        <div class="col-md-12 mb-3">
                            <div id="archivoBase64"></div>
                            <label class="form-label" for="archivo">Documentación de maquinaria</label>
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