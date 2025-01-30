<!-- Modal -->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" >
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formUsuario" name="formUsuario">
          <input type="hidden" name="idUsuario" id="idUsuario" value="">
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="txtIdentificacion">Identificacion</label>
              <input class="form-control" type="text" id="txtIdentificacion" name="txtIdentificacion" placeholder="Identificacion" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="txtNombre">Nombres</label>
              <input class="form-control valid validText" type="text" id="txtNombre" name="txtNombre" placeholder="Nombres" required>
            </div>
            <div class="form-group col-md-6">
              <label class="control-label" for="txtApellido">Apellidos</label>
              <input class="form-control valid validText" type="text" id="txtApellido" name="txtApellido" placeholder="Apellidos" required>
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="txtEmail">Email</label>
              <input class="form-control valid validEmail" type="email" id="txtEmail" name="txtEmail" placeholder="Email" required>
            </div>
            <div class="form-group col-md-6">
              <label class="control-label" for="txtTelefono">Telefono</label>
              <input class="form-control valid validNumber" type="text" id="txtTelefono" name="txtTelefono" placeholder="telefono" required onkeypress="return controlTag(event);">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="listRolid">Tipo usuario</label>
              <select class="form-control" data-live-search="true" id="listRolid" name="listRolid" required>
                <option value=""></option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="listStatus">Estado</label>
              <select class="form-control selectpicker" id="listStatus" name="listStatus" required>
                <option value="1">Activo</option>
                <option value="2">Inactivo</option>
              </select>
            </div> 
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label class="control-label" for="txtPassword">Password</label>
              <input class="form-control" type="password" id="txtPassword" name="txtPassword" placeholder="Constraseña">
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
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
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
              <td>Tipo Usuario:</td>
              <td id="celTipoUsuario">Larry</td>
            </tr>
            <tr>
              <td>Estado:</td>
              <td id="celEstado">Larry</td>
            </tr>
            <tr>
              <td>Fecha registro:</td>
              <td id="celFechaRegistro">Larry</td>
            </tr>
          </tbody>
        </table>
        <button type="buton" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
      </div>
    </div>
  </div>
</div>