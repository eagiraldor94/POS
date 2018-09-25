<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Crear Venta
              <small>/ Ventas</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Crear Venta</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="row">
      <!-- Default box -->
      <div class="card col-xl-5 col-sm-12">
        <!--================================
        =            FORMULARIO            =
        =================================-->
        <form role="form" method="post" class="formularioVenta">
          <div class="card-header bg-success">

                <h3 class="card-title pull-left mt-2"><b>Crear Venta</b></h3>

                <button type="button" class="btn btn-success pull-right" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button>

            
          </div>
          <div class="card-body">
            
            <!-- Vendedor -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newVendor" id="newVendor" value="<?php echo $_SESSION['user']; ?>" readonly>
                  <input type="hidden" name="newVendorId" value="<?php echo $_SESSION['id']; ?>">
                </div>
                
              </div>
              <!-- Factura -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>

                  <?php 
                  $item = null;
                  $valor = null;
                  $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
                  $item = null;
                  $valor = null;
                  $resoluciones = ControladorResoluciones::ctrMostrarResoluciones($item, $valor);
                  if (!$ventas) {
                    foreach ($resoluciones as $clave => $fila) {
                        $id[$clave] = $fila['id'];
                        $res_number[$clave] = $fila['res_number'];
                        $first_number[$clave] = $fila['first_number'];
                        $last_number[$clave] = $fila['last_number'];
                        $date[$clave] = $fila['resDate'];
                    }
                    array_multisort($res_number,$id,$first_number,$last_number,$date);
                    echo '<input class="form-control" type="text" name="newBillNumber" id="newBillNumber" value="'.$first_number[0].'" required readonly>';
                  }else{
                    foreach ($ventas as $key => $value) {
                      # code...
                    }
                    $codigo = $value['bill_number'] +1;
                    echo '<input class="form-control" type="text" name="newBillNumber" id="newBillNumber" value="'.$codigo.'" required readonly>';
                  }

                   ?>
                </div>
                
              </div>
              <!-- Cliente -->
              <div class="form-group">

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                  </div>
                  <select class="form-control" name="newClientId" required>
                    <option value="">Seleccionar cliente</option>
                    <?php 
                    $item = null;
                    $value = null;
                    $clientes = ControladorClientes::ctrMostrarClientes($item,$value);
                    foreach ($clientes as $key => $cliente) {
                      echo '<option value="'.$cliente['id'].'">'.$cliente['name'].'</option>';
                    }
                     ?>
                  </select>
                    
                </div> 

                
              </div>
              <!-- Producto -->
              <div class="form-group row nuevoProducto">

                
                
                
              </div>
              <input type="hidden" name="productList" id="productList" >
              <!--============================================
              =            BOTON AGREGAR PRODUCTO            =
              =============================================-->
              <button type="button" class="btn btn-default d-xl-none btnAgregarProducto">Agregar producto</button>
              <hr>
              <div class="row justify-content-end">
                <div class="col-12">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>SubTotal</th>
                        <th>Dto(%)</th>
                        <th>Neto</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td style="width: 37%">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend d-none d-md-inline-flex"><span class="input-group-text"><i class="ion ion-social-usd"></i></span></div>
                            <input type="text" class="form-control" id="nuevoSubTotalVenta" name="newSubTotal" placeholder="0" required readonly>
                            

                          </div>
                        </td>
                        <td style="width: 25%">
                          <div class="input-group mb-3">

                            <input type="number" class="form-control" min="0" id="nuevoDescuentoVenta" name="newDiscount" placeholder="0" value="0" required>
                            <div class="input-group-append d-none d-md-inline-flex"><span class="input-group-text"><i class="fa fa-percent"></i></span></div>

                          </div>
                        </td>
                        
                        <td style="width: 38%">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend d-none d-md-inline-flex"><span class="input-group-text"><i class="ion ion-social-usd"></i></span></div>
                            <input type="text" class="form-control" id="nuevoNetoVenta" placeholder="0" required readonly>
                            <input type="hidden" name="newNeto" id="netoVenta" required>

                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <div class="row justify-content-end">
                <div class="col-sm-8">
                  <table class="table">
                    <thead>
                      <tr>
                        <th>Impuesto</th>
                        <th>Total</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        
                        <td style="width: 40%">
                          <div class="input-group mb-3">

                            <input type="number" class="form-control" min="0" id="nuevoImpuestoVenta" name="newTax" placeholder="0" value="19" required>
                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-percent"></i></span></div>
                            <input type="hidden" name="newTaxValue" id="newTaxValue">

                          </div>
                        </td>
                        <td style="width: 60%">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="ion ion-social-usd"></i></span></div>
                            <input type="text" class="form-control" id="nuevoTotalVenta" placeholder="0" required readonly>
                            <input type="hidden" name="newTotal" id="totalVenta" required>

                          </div>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
              <!--====================================
              =            Metodo de pago            =
              =====================================-->
              <div class="row">
                <div class="col-6">
                  <div class="form-group">
                    <select name="newPaymentMethod" id="nuevoMetodoPago" class="form-control" required>
                      <option value="">Seleccione medio de pago</option>
                      <option value="Efectivo">Efectivo</option>
                      <option value="TC">Tarjeta Credito</option>
                      <option value="TD">Tarjeta Debito</option>
                    </select>
                  </div>
                </div>
                <div class="cajasMetodoPago row"></div>
              </div>
              

              
          </div>
          <!-- /.card-body -->
          <div class="card-footer">
            <div class="row justify-content-end">
              <button type="submit" class="btn btn-success" name="newBill">Guardar Venta</button>
            </div>
          </div>
        </form>
        <?php 
          $crearVenta = new ControladorVentas();
          $crearVenta -> ctrCrearVenta();
?>
        
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->
      <!-- Default box -->
      <div class="card col-lg-7 d-none d-xl-block">
        <!--========================================
        =            TABLA DE PRODUCTOS            =
        =========================================-->
        <div class="card-header bg-warning">
          <h3 class="card-title">Lista de productos</h3>
        </div>
        <div class="card-body">
          <table class="table table-bordered table-striped dt-responsive tablaVentas">
            <thead>
              <tr>
                <th style="width: 10px">#</th>
                <th>Imagen</th>
                <th>Codigo</th>
                <th>Nombre</th>
                <th>Stock</th>
                <th>Acciones</th>
              </tr>
            </thead>
            
          </table>
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->

    </div>
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