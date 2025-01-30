<!-- Modal -->
<div class="modal fade" id="modalFormCliente" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" >
        <div class="modal-content">
            <div class="modal-header headerRegister">
                <h5 class="modal-title" id="titleModal">Nuevo Cliente</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formCliente" name="formCliente">
                    <input type="hidden" name="idUsuario" id="idUsuario" value="">
                    <p class="text-primary">Los campos con asterisco ( <span class="required"> * </span> ) son obligatorios.</p>                    
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="control-label" for="txtIdentificacion">Identificacion <span class="required"> * </span></label>
                            <input class="form-control" type="text" id="txtIdentificacion" name="txtIdentificacion" placeholder="Identificacion" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="txtNombre">Nombres <span class="required"> * </span></label>
                            <input class="form-control valid validText" type="text" id="txtNombre" name="txtNombre" placeholder="Nombres" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="txtApellido">Apellidos <span class="required"> * </span></label>
                            <input class="form-control valid validText" type="text" id="txtApellido" name="txtApellido" placeholder="Apellidos" required>
                        </div>
                    </div>
                    <div class="form-row">

                        <div class="form-group col-md-4">
                            <label class="control-label" for="txtTelefono">Telefono <span class="required"> * </span></label>
                            <input class="form-control valid validNumber" type="text" id="txtTelefono" name="txtTelefono" placeholder="telefono" required onkeypress="return controlTag(event);">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="control-label" for="txtEmail">Email <span class="required"> * </span></label>
                            <input class="form-control valid validEmail" type="email" id="txtEmail" name="txtEmail" placeholder="Email" required>
                        </div>                        
                        <div class="form-group col-md-4">
                            <label class="control-label" for="txtPassword">Password</label>
                            <input class="form-control" type="password" id="txtPassword" name="txtPassword" placeholder="Constraseña">
                        </div>
                    </div>
                    <hr>
                    <h3 class="text-primary">Datos Fiscales</h3>
                    <div class="form-row">                        
                        <div class="form-group col-md-6">
                            <label>Identificacion tributaria <span class="required"> * </span></label>
                            <input class="form-control" type="text" id="txtNit" name="txtNit" required="">
                        </div>

                        <div class="form-group col-md-6">
                            <label>Nombre fiscal <span class="required"> * </span></label>
                            <input class="form-control" type="text" id="txtNombreFiscal" name="txtNombreFiscal" required="">
                        </div>

                        <div class="form-group col-md-12">
                            <label>Direccion fiscal <span class="required"> * </span></label>
                            <input class="form-control" type="text" id="txtDirFiscal" name="txtDirFiscal" required="">
                        </div>
                    </div>
                    <div class="tile-footer">
                        <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span> </button>&nbsp;&nbsp;&nbsp;
                        <button class="btn btn-danger" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- ----------------------------- -->

<!-- Modal -->
<div class="modal fade" id="modalViewCliente" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header header-primary">
                <h5 class="modal-title" id="titleModal">Datos del usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <table class="table table-bordered">
                    <tbody>
                        <tr>
                            <td>Identificación:</td>
                            <td id="celIdentificacion">654654654</td>
                        </tr>
                        <tr>
                            <td>Nombres:</td>
                            <td id="celNombre">Jacob</td>
                        </tr>
                        <tr>
                            <td>Apellidos:</td>
                            <td id="celApellido">Jacob</td>
                        </tr>
                        <tr>
                            <td>Teléfono:</td>
                            <td id="celTelefono">Larry</td>
                        </tr>
                        <tr>
                            <td>Email (Usuario):</td>
                            <td id="celEmail">Larry</td>
                        </tr>
                        <tr>
                            <td>Identificaicon Tributaria:</td>
                            <td id="celNit">Larry</td>
                        </tr>
                        <tr>
                            <td>Nombre Fiscal:</td>
                            <td id="celNomFiscal">Larry</td>
                        </tr>
                        <tr>
                            <td>Direccion Fiscal:</td>
                            <td id="celDirFiscal">Larry</td>
                        </tr>
                        <tr>
                            <td>Fecha registro:</td>
                            <td id="celFechaRegistro">Larry</td>
                        </tr>
                    </tbody>
                </table>
                <button type="buton" class="btn btn-primary w-100" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>