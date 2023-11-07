
<!-- Modal Nuevo Usuario-->
<div class="modal fade" id="modalFormUsuario" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header headerRegister">
        <h5 class="modal-title" id="titleModal">Nuevo Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formUsuario" name="formUsuario" class="form-horizontal">
          <input type="hidden" name="idUsuario" id="idUsuario" value="">
          <p class="text-primary">Todos los campos son obligatorios.</p>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtIdentificacion">Identificación</label>
              <input class="form-control  valid validNumber" id="txtIdentificacion" name="txtIdentificacion" type="text" placeholder="Identificación del Usuario" required="" onkeypress="return controlTag(event);">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombre">Nombres</label>
              <input class="form-control valid validText" id="txtNombre" name="txtNombre" type="text" placeholder="Nombre del Usuario" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellido">Apellidos</label>
              <input class="form-control valid validText" id="txtApellido" name="txtApellido" type="text" placeholder="Apellidos del Usuario" required="">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtTelefono">Teléfono</label>
              <input class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" type="text" placeholder="Teléfono del Usuario" required="" onkeypress="return controlTag(event);">
            </div>
            <div class="form-group col-md-6">
              <label for="txtEmail">Email</label>
              <input class="form-control valid validEmail" id="txtEmail" name="txtEmail" type="email" placeholder="Email del Usuario" required="">
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="listRolid">Tipo Usuario</label>
                <select class="form-control" data-live-search="true" id="listRolid" name="listRolid" required="">
                  
                </select>
            </div>
            <div class="form-group col-md-6">
              <label for="listStatus">Status</label>
                <select class="form-control selectpicker" id="listStatus" name="listStatus" required="">
                  <option value="1">Activo</option>
                  <option value="2">Inactivo</option>
                </select>
            </div>
          </div>

          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtPassword">Contraseña</label>
              <input class="form-control" id="txtPassword" name="txtPassword" type="password" placeholder="Contraseña del Usuario">
            </div>
          </div>

          <div class="tile-footer">
            <button id="btnActionForm" class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Guardar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cerrar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>



<!-- Modal Ver Usuario-->
<div class="modal fade" id="modalViewUser" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header header-primary">
        <h5 class="modal-title" id="titleModal">Datos del Usuario</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>Identificacion:</td>
              <td id="celIdentificacion">42914382</td>
            </tr>
            <tr>
              <td>Nombres:</td>
              <td id="celNombre">Jacob</td>
            </tr>
            <tr>
              <td>Apellidoss:</td>
              <td id="celApellido">Jacob</td>
            </tr>
            <tr>
              <td>Telefono:</td>
              <td id="celTelefono">942384712</td>
            </tr>
            <tr>
              <td>Email (Usuario):</td>
              <td id="celEmail">carlos.lopez@gmail.com</td>
            </tr>
            <tr>
              <td>Tipo Usuario:</td>
              <td id="celTipoUsuario">Vendedor</td>
            </tr>
            <tr> 
              <td>Estado:</td>
              <td id="celEstado">Activo</td>
            </tr>
            <tr>
              <td>Fecha de Registro:</td>
              <td id="celFechaRegistro">08/10/2020</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button></div>
    </div>
  </div>
</div>