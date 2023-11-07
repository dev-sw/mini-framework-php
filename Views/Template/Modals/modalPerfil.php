
<!-- Modal Perfil-->
<div class="modal fade" id="modalFormPerfil" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header headerUpdate">
        <h5 class="modal-title" id="titleModal">Actualizar Perfil</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="formPerfil" name="formPerfil" class="form-horizontal">
          
          <p class="text-primary">Datos del Perfil <small>campos obligatorios (<span class="required">*</span>).</small></p>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtIdentificacion">Identificación (DNI) <span class="required">*</span></label>
              <input class="form-control valid validNumber" id="txtIdentificacion" name="txtIdentificacion" value="<?= $_SESSION['userData']['identificacion']; ?>" type="text" placeholder="Identificación del Usuario" required="" onkeypress="return controlTag(event);">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtNombre">Nombres <span class="required">*</span></label>
              <input class="form-control valid validText" id="txtNombre" name="txtNombre" value="<?= $_SESSION['userData']['nombres']; ?>" type="text" placeholder="Nombre del Usuario" required="">
            </div>
            <div class="form-group col-md-6">
              <label for="txtApellido">Apellidos <span class="required">*</span></label>
              <input class="form-control valid validText" id="txtApellido" name="txtApellido" value="<?= $_SESSION['userData']['apellidos']; ?>" type="text" placeholder="Apellidos del Usuario" required="">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="txtTelefono">Teléfono <span class="required">*</span></label>
              <input class="form-control valid validNumber" id="txtTelefono" name="txtTelefono" value="<?= $_SESSION['userData']['telefono']; ?>" type="text" placeholder="Teléfono del Usuario" required="" onkeypress="return controlTag(event);">
            </div>
          </div>
          <div class="modal-footer">
            <button id="btnActionForm" class="btn btn-info" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i><span id="btnText">Actualizar</span></button>&nbsp;&nbsp;&nbsp;
            <button class="btn btn-danger" type="button" data-dismiss="modal"><i class="fa fa-fw fa-lg fa-times-circle"></i>Cancelar</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>