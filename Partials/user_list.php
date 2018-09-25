<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de usuarios
              <small>/ Usuarios</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Usuarios</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <button class="btn btn-danger" data-toggle="modal" data-target="#modalAgregarUsuario"> Agregar Usuario </button>
        </div>
        
        <div class="card-body">
          <table class="table table-bordered table-striped tabla dt-responsive">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Nombre</th>
                <th>Usuario</th>
                <th>Foto</th>
                <th>Rol</th>
                <th>Estado</th>
                <th>Último login</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $item = null;
                $value = null;
                $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item,$value);
                foreach ($usuarios as $key => $usuario) {
                  echo '
                  <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$usuario['name'].'</td>
                    <td>'.$usuario['username'].'</td>';
                    if ($usuario['photo'] != null) {
                      echo '<td><img src="'.$usuario['photo'].'" class="img-thumbnail" width="40px"></td>';
                    }else{
                      echo '<td><img src="Views/img/usuarios/anonymous.png" class="img-thumbnail" width="40px"></td>';
                    }
                    echo '
                    <td>'.$usuario['type'].'</td>';
                    if ($usuario['state'] == 1) {
                      echo '<td><button class="btn btn-success btn-sm btnActivar" idUsuario="'.$usuario['id'].'" estadoUsuario="0">Activado</button></td>';
                    }else{
                      echo '<td><button class="btn btn-danger btn-sm btnActivar" idUsuario="'.$usuario['id'].'" estadoUsuario="1">Desactivado</button></td>';
                    }
                    echo '
                    <td>'.$usuario['last_log'].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-warning btnEditarUsuario" idUsuario="'.$usuario['id'].'" data-toggle="modal" data-target="#modalEditarUsuario"><i class="fa fa-pen"></i></button>
                        <button class="btn btn-danger btnBorrarUsuario" idUsuario="'.$usuario['id'].'" fotoUsuario="'.$usuario['photo'].'" usuario="'.$usuario['username'].'"><i class="fa fa-times"></i></button>
                        
                      </div>
                    </td>
                  </tr>
                  ';
                }

               ?>
              
            </tbody>
          </table>
          
          
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--=====================================
  =          Ventana Modal Add         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalAgregarUsuario">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Agregar Usuario</h4>
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
                  
                  <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre" required>
                </div>
                
              </div>
              <!-- username -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newUsername" placeholder="Ingresar nombre de usuario" id="newUser" required>
                </div>
                
              </div>
              <!-- contraseña -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                  </div>
                  
                  <input class="form-control" type="password" name="newPassword" placeholder="Ingresar contraseña" required>
                </div>
                
              </div>
              <!-- rol -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                  </div>
                  <select class="form-control" name="rol">
                    <option value="">Seleccionar perfil</option>
                    <option value="Admin">Administrador</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Contador">Contador</option>
                  </select>
                </div>
                
              </div>
              <!-- foto -->
              <div class="form-group">
                <div class="panel">SUBIR FOTO</div>
                <input type="file" class="photo" name="photo">
                <p class="help-block">Peso máximo de la foto 2MB</p>
                <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="newUser">Guardar Usuario</button>
          </div>
        <?php 
          $crearUsuario = new ControladorUsuarios();
          $crearUsuario -> ctrCrearUsuario();
         ?>
      </form>

    </div>
  </div>
</div>
  <!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEditarUsuario">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Editar Usuario</h4>
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
                  
                  <input class="form-control" type="text" name="newName" value="Editar nombre" placeholder="Editar nombre" id="nameEdit" required>
                </div>
                
              </div>
              <!-- username -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newUsername" value="Editar nombre de usuario" placeholder="Editar nombre de usuario" id="usernameEdit" readonly>
                </div>
                
              </div>
              <!-- contraseña -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-lock"></i></span>
                  </div>
                  
                  <input class="form-control" type="password" name="newPassword" placeholder="Escriba la nueva contraseña (opcional)">
                  <input type="hidden" name="password" id="password">
                </div>
                
              </div>
              <!-- rol -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                  </div>
                  <select class="form-control" name="rol">
                    <option value="" id="rolEdit"></option>
                    <option value="Admin">Administrador</option>
                    <option value="Vendedor">Vendedor</option>
                    <option value="Contador">Contador</option>
                  </select>
                </div>
                
              </div>
              <!-- foto -->
              <div class="form-group">
                <div class="panel">ACTUALIZAR FOTO</div>
                <input type="file" class="photo" name="photo">
                <p class="help-block">Peso máximo de la foto 2MB</p>
                <img src="Views/img/usuarios/anonymous.png" class="img-thumbnail previsualizar" width="100px" id="photoEdit">
                <input type="hidden" name="lastPhoto" id="lastPhoto">
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="editUser">Modificar Usuario</button>
          </div>
        <?php 
          $editarUsuario = new ControladorUsuarios();
          $editarUsuario -> ctrEditarUsuario();
         ?>
      </form>

    </div>
  </div>
</div>
  <?php 
    $borrarUsuario = new ControladorUsuarios();
    $borrarUsuario -> ctrBorrarUsuario();
   ?>