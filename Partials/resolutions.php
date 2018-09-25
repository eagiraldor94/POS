<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Administrar resoluciones de facturación</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Resoluciones</li>
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
          <button class="btn btn-danger" data-toggle="modal" data-target="#modalAgregarResolucion"> Agregar Resolución </button>
        </div>
        
        <div class="card-body">
          <table class="table table-bordered table-striped tabla dt-responsive">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Numero de resolución</th>
                <th>Primer numero de factura</th>
                <th>Último número de factura</th>
                <th>Fecha de resolución</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $item = null;
                $value = null;
                $resoluciones = ControladorResoluciones::ctrMostrarResoluciones($item,$value);
                foreach ($resoluciones as $key => $resolucion) {
                  echo '
                  <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$resolucion['res_number'].'</td>
                    <td>'.$resolucion['first_number'].'</td>
                    <td>'.$resolucion['last_number'].'</td>
                    <td>'.$resolucion['resDate'].'</td>
                    <td>
                       <div class="btn-group">';
                        if ($_SESSION['rank']=='Admin') {
                          echo'
                        <button class="btn btn-warning btnEditarResolucion" idResolucion="'.$resolucion['id'].'" data-toggle="modal" data-target="#modalEditarResolucion"><i class="fa fa-pen"></i></button>
                        <button class="btn btn-danger btnBorrarResolucion" idResolucion="'.$resolucion['id'].'"><i class="fa fa-times"></i></button>';
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
<div class="modal" id="modalAgregarResolucion">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Agregar Resolución</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- numero resolucion -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newResNumber" placeholder="Ingresar número de la resolución" id="newResNumber" required>
                </div>
                
              </div>
              <!-- numero minimo factura -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-arrow-down"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newFirstNumber" placeholder="Ingresar el tope inferior de factura autorizado" required>
                </div>
                
              </div>
              <!-- numero maximo factura -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-arrow-up"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newLastNumber" placeholder="Ingresar el tope superior de factura autorizado" required>
                </div>
              </div>
                                <!-- Fecha de autorizacion-->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newDate" placeholder="Ingrese la fecha de la resolución" data-inputmask="'alias':'yyyy/mm/dd'" data-mask required>
                </div>
                
              </div>                 
              </div>
            </div>


          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="newRes">Guardar Resolución</button>
          </div>
        <?php 
          $crearResolucion = new ControladorResoluciones();
          $crearResolucion -> ctrCrearResolucion();
         ?>
      </form>

    </div>
  </div>
</div>
  <!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEditarResolucion">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Editar Resolución</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
             <!-- numero resolucion -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newResNumber" placeholder="Ingresar número de la resolución" id="resNumberEdit" required readonly>
                  <input type="hidden" name="id" id="id">
                </div>
                
              </div>
              <!-- numero minimo factura -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-arrow-down"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newFirstNumber" placeholder="Ingresar el tope inferior de factura autorizado" id="firstNumberEdit" required>
                </div>
                
              </div>
              <!-- numero maximo factura -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-arrow-up"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newLastNumber" placeholder="Ingresar el tope superior de factura autorizado" id="lastNumberEdit" required>
                </div>
              </div>
                                <!-- Fecha de autorizacion-->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newDate" placeholder="Ingrese la fecha de la resolución" data-inputmask="'alias':'yyyy/mm/dd'" data-mask id="dateEdit" required>
                </div>
                
              </div>                 
              </div>
            </div>
   

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="editRes">Modificar Resolución</button>
          </div>
        <?php 
          $editarResolucion = new ControladorResoluciones();
          $editarResolucion -> ctrEditarResolucion();
         ?>
      </form>

    </div>
  </div>
</div>
  <?php 
    $borrarResolucion = new ControladorResoluciones();
    $borrarResolucion -> ctrBorrarResolucion();
   ?>