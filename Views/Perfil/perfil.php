<?php 
  headerAdmin($data); 
  getModal('modalPerfil', $data);  
?>

<main class="app-content">
      <div class="row user">
        <div class="col-md-12">
          <div class="profile">
            <div class="info"><img class="user-img" src="<?= media(); ?>/images/avatar.png">
              <h4><?= $_SESSION['userData']['nombres'].' '.$_SESSION['userData']['apellidos']; ?></h4>
              <p><?= $_SESSION['userData']['nombre']; ?></p>
            </div>
            <div class="cover-image"></div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="tile p-0">
            <ul class="nav flex-column nav-tabs user-tabs">
              <li class="nav-item"><a class="nav-link active" href="#user-timeline" data-toggle="tab">Datos Personales</a></li>
              <li class="nav-item"><a class="nav-link" href="#user-settings" data-toggle="tab">Datos de Sesión</a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-9">
          <div class="tab-content">
            <div class="tab-pane active" id="user-timeline">
              <div class="timeline-post">
                <div class="post-media">
                  <div class="content">
                  <h5>DATOS PERSONALES <button class="btn btn-sm btn-info" type="button" onclick="openModalPerfil();"><i class="fas fa-pencil-alt" aria-hidden="true"></i></button></h5>
                  </div>
                </div>
                <table class="table table-bordered">
                  <body>
                    <tr>
                      <td style="width: 150px;">Identificacion</td>
                      <td><?= $_SESSION['userData']['identificacion']; ?> </td>
                    </tr>
                    <tr>
                      <td>Nombres:</td>
                      <td><?= $_SESSION['userData']['nombres']; ?> </td>
                    </tr>
                    <tr>
                      <td>Apellidos:</td>
                      <td><?= $_SESSION['userData']['apellidos']; ?> </td>
                    </tr>
                    <tr>
                      <td>Teléfono:</td>
                      <td><?= $_SESSION['userData']['telefono']; ?> </td>
                    </tr>
                    <tr>
                      <td>Email (Usuario):</td>
                      <td><?= $_SESSION['userData']['email']; ?> </td>
                    </tr>
                  </body>
                </table>
              </div>
            </div>
            <div class="tab-pane fade" id="user-settings">
              <div class="tile user-settings">
                <h4 class="line-head">Datos de Sesión</h4>
                <form id="formDataSession" name="formDataSession">
                  <div class="row mb-4">
                    <div class="col-md-6">
                      <label for="txtEmail">Email Usuario</label>
                      <input class="form-control valid validEmail" id="txtEmail" name="txtEmail" value="<?= $_SESSION['userData']['email']; ?>" type="email" placeholder="Email del Usuario" readonly>
                    </div>
                    <div class="col-md-6">
                      <label for="listStatus">Estado</label>
                      <select class="form-control selectpicker" id="listEstado" name="listEstado" value="<?= $_SESSION['userData']['estado']; ?>">
                        <option value="1">Activo</option>
                        <option value="2">Inactivo</option>
                      </select>
                    </div>
                  </div>
                  <div class="row mb-4"> 
                    <div class="col-md-6">
                      <label for="txtPassword">Contraseña</label>
                      <input class="form-control" id="txtPassword" name="txtPassword" type="password" placeholder="Contraseña del Usuario">
                    </div>
                    <div class="col-md-6">
                      <label for="txtPasswordConfirm">Confirmar Contraseña</label>
                      <input class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" type="password" placeholder="Contraseña del Usuario">
                    </div>
                  </div>

                  <div class="row mb-10">
                    <div class="col-md-12 modal-footer">
                      <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i> Guardar</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
            <div class="tab-pane fade" id="datos">
              <div class="tile user-setting">
                <p>Pagos</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
<?php footerAdmin($data); ?>