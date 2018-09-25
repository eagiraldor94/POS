<!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEditarMain">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Editar Mi Perfil</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" value="Editar nombre" placeholder="Editar nombre" id="nameEditMe" required>
                </div>
                
              </div>
              <!-- username -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newUsername" value="Editar nombre de usuario" placeholder="Editar nombre de usuario" id="usernameEditMe" readonly>
                </div>
                
              </div>
              <!-- contraseña -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                  </div>
                  
                  <input class="form-control" type="password" name="newPassword" placeholder="Escriba la nueva contraseña (opcional)">
                  <input type="hidden" name="password" id="passwordMe">
                </div>
                
              </div>
              <!-- rol -->
              <div class="form-group">
              	<input type="hidden" name="rol" value="<?php echo $_SESSION['rank'] ?>">
                               
              </div>
              <!-- foto -->
              <div class="form-group">
                <div class="panel">ACTUALIZAR FOTO</div>
                <input type="file" class="photo" name="photo">
                <p class="help-block">Peso máximo de la foto 2MB</p>
                <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px" id="photoEditMe">
                <input type="hidden" name="lastPhoto" id="lastPhotoMe">
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="editUser">Modificar Informacion</button>
          </div>
        <?php 
          $editarMain = new ControladorUsuarios();
          $editarMain -> ctrEditarUsuario();
         ?>
      </form>

    </div>
  </div>
</div>