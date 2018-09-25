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
  <?php 
    $item = 'id';
    $valor = $_GET['idVenta'];
    $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
    $valor = $ventas['vendor_id'];
    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($item, $valor);
   ?>
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
            <div class="row align-items-center">
              <div class="col-md-8">
                <h3 class="card-title"><b>Crear Venta</b></h3>
              </div>
              <div class="col-md-4">
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modalAgregarCliente" data-dismiss="modal">Agregar Cliente</button>
              </div>
            </div>
            
          </div>
          <div class="card-body">
            
            <!-- Vendedor -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-user"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newVendor" id="newVendor" value="<?php echo $vendedor['name']; ?>" readonly>
                  <input type="hidden" name="newVendorId" value="<?php echo $vendedor['id']; ?>" required>
                  <input type="hidden" name="editSaleId" value="<?php echo $ventas['id'];  ?>" required>
                </div>
                
              </div>
              <!-- Factura -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-key"></i></span>
                  </div>

                 
                  
                  
                 <input class="form-control" type="text" name="newBillNumber" id="newBillNumber" value="<?php echo $ventas['bill_number']; ?>" required readonly>
                  

                  
                </div>
                
              </div>
              <!-- Cliente -->
              <div class="form-group">

                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-users"></i></span>
                  </div>
                    <?php 
                    $item = 'id';
                    $value = $ventas['client_id'];
                    $cliente = ControladorClientes::ctrMostrarClientes($item,$value);
                      echo '<input type="text" class="form-control" name="clientEdit" value="'.$cliente['name'].'" readonly required>';
                      echo '<input type="hidden" name="newClientId" value="'.$cliente['id'].'" required>';
                     ?>
                </div> 

                
              </div>
              <!-- Producto -->
              <div class="form-group row nuevoProducto">
                <?php 
                    $listaProductos = json_decode($ventas['products'], true);
                    foreach ($listaProductos as $key => $producto) {
                      $item = "id";
                      $value = $producto['id'];
                      $orden = 'id';
                      $answer = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
                      echo '<div class="row" style="padding: 0px 8px">
                      <div class="col-sm-6">
                      <div class="input-group mb-3">
                      <div class="input-group-prepend">
                      <button type="button" class="btn btn-danger btn-sm quitarProducto input-group-text" idProducto="'.$producto['id'].'">
                      <i class="fa fa-times">
                      </i>
                      </button>
                      </div>
                      <input type="text" class="form-control agregarProducto nuevaDescripcionProducto" name="newProduct" idProducto="'.$producto['id'].'" value="'.$producto['name'].'" required readonly>
                      </div>
                      </div>
                      <div class="col-sm-2 mb-3">
                      <input type="number" class="form-control nuevaCantidadProducto" name="newQuantity" min="1" max="'.($answer['stock']+$producto['quantity']).'" stock="'.($answer['stock']+$producto['quantity']).'" newStock="'.($answer['stock']+$producto['quantity']-1).'" placeholder="Cantidad" value="'.$producto['quantity'].'" required>
                      </div>
                      <div class="col-sm-4 ingresoPrecio">
                      <div class="input-group mb-3">
                      <div class="input-group-prepend">
                      <span class="input-group-text">
                      <i class="ion ion-social-usd">
                      </i>
                      </span>
                      </div>
                      <input type="text" class="form-control nuevaPrecioProducto" precioBase="'.$producto['price'].'" name="newPrice" value="'.$producto['total'].'" readonly required>
                      </div>
                      </div>
                      </div>';
                    }
                 ?>

                
                
                
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
                            <input type="text" class="form-control" id="nuevoSubTotalVenta" name="newSubTotal" placeholder="0" value="<?php 
                              $subTotal = $ventas['value']/(1-($ventas['discount']/100));
                              echo $subTotal;
                             ?>" required readonly>
                            

                          </div>
                        </td>
                        <td style="width: 25%">
                          <div class="input-group mb-3">

                            <input type="number" class="form-control" min="0" id="nuevoDescuentoVenta" name="newDiscount" placeholder="0" value="<?php echo $ventas['discount']; ?>" required>
                            <div class="input-group-append d-none d-md-inline-flex"><span class="input-group-text"><i class="fa fa-percent"></i></span></div>

                          </div>
                        </td>
                        
                        <td style="width: 38%">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend d-none d-md-inline-flex"><span class="input-group-text"><i class="ion ion-social-usd"></i></span></div>
                            <input type="text" class="form-control" id="nuevoNetoVenta" placeholder="0" value="<?php echo $ventas['value']; ?>" required readonly>
                            <input type="hidden" name="newNeto" id="netoVenta" value="<?php echo $ventas['value']; ?>" required>

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

                            <input type="number" class="form-control" min="0" id="nuevoImpuestoVenta" name="newTax" placeholder="0" value="<?php 
                              $tax = round(($ventas['tax']/$ventas['value'])*100);
                              echo $tax;
                             ?>" required>
                            <div class="input-group-append"><span class="input-group-text"><i class="fa fa-percent"></i></span></div>
                            <input type="hidden" name="newTaxValue" id="newTaxValue" value="<?php echo $ventas['tax']; ?>">

                          </div>
                        </td>
                        <td style="width: 60%">
                          <div class="input-group mb-3">
                            <div class="input-group-prepend"><span class="input-group-text"><i class="ion ion-social-usd"></i></span></div>
                            <input type="text" class="form-control" id="nuevoTotalVenta" placeholder="0" value="<?php echo $ventas['total']; ?>" required readonly>
                            <input type="hidden" name="newTotal" id="totalVenta" value="<?php echo $ventas['total']; ?>" required>

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
              <button type="submit" class="btn btn-success" name="editBill">Guardar cambios</button>
            </div>
          </div>
        </form>
        <?php 
          $editarVenta = new ControladorVentas();
          $editarVenta -> ctrEditarVenta();
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