<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de clientes
              <small>/ Clientes</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Clientes</li>
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
          <button class="btn btn-danger" data-toggle="modal" data-target="#modalAgregarCliente"> Agregar Cliente </button>
        </div>
        
        <div class="card-body">
          <table class="table table-bordered table-striped dt-responsive tabla">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Tipo ID</th>
                <th>Número ID</th>
                <th>Direccion</th>
                <th>Ciudad</th>
                <th>Telefono 1</th>
                <th>Telefono 2</th>
                <th>Email</th>
                <th>Ultima Compra</th>
                <th>Fecha de nacimiento</th>
                <th>Total de compras</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $item = null;
                $value = null;
                $clientes = ControladorClientes::ctrMostrarClientes($item,$value);
                foreach ($clientes as $key => $cliente) {
                  echo '
                  <tr>
                    <td>'.($key+1).'</td>';
                    if ($cliente['photo'] != null) {
                      echo '<td><img src="'.$cliente['photo'].'" class="img-thumbnail" width="40px"></td>';
                    }else{
                      echo '<td><img src="Views/img/clientes/anonymous.png" class="img-thumbnail" width="40px"></td>';
                    }
                    echo '
                    <td>'.$cliente['name'].'</td>
                    <td>'.$cliente['id_type'].'</td>
                    <td>'.$cliente['id_number'].'</td>
                    <td>'.$cliente['address'].'</td>
                    <td>'.$cliente['city'].'</td>
                    <td>'.$cliente['phone1'].'</td>
                    <td>'.$cliente['phone2'].'</td>
                    <td>'.$cliente['email'].'</td>                  
                    <td>'.$cliente['last_buy'].'</td>                    
                    <td>'.$cliente['birthday'].'</td>                    
                    <td>$ '.number_format($cliente['balance'],2).'</td>  
                    <td>
                      <div class="btn-group">';
                        if ($_SESSION['rank']=='Admin'||$_SESSION['rank']=='Vendedor') {
                          echo'
                        <button class="btn btn-warning btnEditarCliente" idCliente="'.$cliente['id'].'" data-toggle="modal" data-target="#modalEditarCliente"><i class="fa fa-pen"></i></button>';
                      }
                        if ($_SESSION['rank']=='Admin') {
                          echo'<button class="btn btn-danger btnBorrarCliente" idCliente="'.$cliente['id'].'" fotoCliente="'.$cliente['photo'].'" cliente="'.$cliente['id_number'].'"><i class="fa fa-times"></i></button>';
                        }
                        
                        echo'
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
<div class="modal" id="modalAgregarCliente">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Agregar Cliente</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre del cliente" required>
                </div>
                
              </div>
              
              <!-- Tipo de documento -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-passport"></i></span>
                  </div>
                  <select class="form-control" name="idType" id="idType" required>
                    <option value="">Seleccionar tipo de documento</option>
                    <option value="CC">Cedula de Ciudadanía</option>
                    <option value="CE">Cedula de Extranjería</option>
                    <option value="NIT">NIT</option>
                  </select>
                </div>
              </div>
                <!-- Numero de documento -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newDocument" placeholder="Ingrese el número de documento" required>
                </div>
                
              </div>
                <!-- Direccion -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-map-marked"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newAddress" placeholder="Ingrese la dirección" required>
                </div>
                
              </div>
                 <!-- Ciudad -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-globe-americas"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newCity" placeholder="Ciudad donde se encuentra" required>
                </div>
                
              </div>             
                  <!-- Telefono 1 -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newPhone1" placeholder="Ingrese el telefono principal" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
                </div>
              </div>
                  <!-- Telefono 2 -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newPhone2" placeholder="Ingrese el telefono secundario (Opcional)" data-inputmask="'mask':'(999) 999-9999'" data-mask>
                </div>
                
              </div>                   
                 <!-- email -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                  </div>
                  
                  <input class="form-control" type="email" name="newEmail" placeholder="Ingrese el email" required>
                </div>
                
              </div>
                                <!-- Fecha de nacimiento-->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newBirthday" placeholder="Ingrese la fecha de nacimiento (Opcional)" data-inputmask="'alias':'yyyy/mm/dd'" data-mask>
                </div>
                
              </div>  
              <!-- foto -->
              <div class="form-group">
                <div class="panel">SUBIR FOTO</div>
                <input type="file" class="photo" name="photo">
                <p class="help-block">Peso máximo de la imagen 2MB</p>
                <img src="Views/img/clientes/anonymous.png" class="img-thumbnail previsualizar" width="100px">
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="newClient">Guardar Cliente</button>
          </div>
        <?php 
          $crearCliente = new ControladorClientes();
          $crearCliente -> ctrCrearCliente();
         ?>
      </form>

    </div>
  </div>
</div>
  <!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEditarCliente">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Editar Cliente</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre del cliente" id="nameEdit" required>
                  <input type="hidden" value="" id="editId" name="editId">
                </div>
                
              </div>
                <!-- Numero de documento -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-id-card"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newDocument" placeholder="Ingrese el número de documento" id="documentEdit" required readonly>
                </div>
                
              </div>
                <!-- Direccion -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-map-marked"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newAddress" placeholder="Ingrese la dirección" id="addressEdit" required>
                </div>
                
              </div>
                 <!-- Ciudad -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-globe-americas"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newCity" placeholder="Ciudad donde se encuentra" id="cityEdit" required>
                </div>
                
              </div>             
                  <!-- Telefono 1 -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newPhone1" id="phone1Edit" placeholder="Ingrese el telefono principal" data-inputmask="'mask':'(999) 999-9999'" data-mask required>
                </div>
              </div>
                  <!-- Telefono 2 -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-phone-square"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newPhone2" id="phone2Edit" placeholder="Ingrese el telefono secundario (Opcional)" data-inputmask="'mask':'(999) 999-9999'" data-mask >
                </div>
                
              </div>                   
                 <!-- email -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                  </div>
                  
                  <input class="form-control" type="email" name="newEmail" placeholder="Ingrese el email" id="emailEdit" required>
                </div>
                
              </div>
                                              <!-- Fecha de nacimiento-->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newBirthday" placeholder="Ingrese la fecha de nacimiento (Opcional)" data-inputmask="'alias':'yyyy/mm/dd'" data-mask id="birthdayEdit">
                </div>
                
              </div> 
              <!-- foto -->
              <div class="form-group">
                <div class="panel">SUBIR FOTO</div>
                <input type="file" class="photo" name="photo">
                <p class="help-block">Peso máximo de la imagen 2MB</p>
                <img src="Views/img/clientes/anonymous.png" class="img-thumbnail previsualizar" width="100px" id="photoEdit">
                <input type="hidden" name="lastPhoto" id="lastPhoto">
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="editClient">Actualizar Cliente</button>
          </div>
        <?php 
          $editarCliente = new ControladorClientes();
          $editarCliente -> ctrEditarCliente();
         ?>
      </form>

    </div>
  </div>
</div>
  <?php 
    $borrarCliente = new ControladorClientes();
    $borrarCliente -> ctrBorrarCliente();

   ?>