<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Lista de productos
              <small>/ Productos</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Productos</li>
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
          <button class="btn btn-danger" data-toggle="modal" data-target="#modalAgregarProducto"> Agregar Producto </button>
        </div>
        
        <div class="card-body">
          <table class="table table-bordered table-striped dt-responsive tablaProductos">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Imagen</th>
                <th style="width:10px">Codigo</th>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Stock</th>
                <th>Precio de compra</th>
                <th>Precio de venta</th>
                <th>Agregado en</th>
                <th>Acciones</th>
              </tr>
            </thead>
            
          </table>
          <input type="hidden" value="<?php echo $_SESSION['rank']; ?>" id="perfilOculto">
          
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
<div class="modal" id="modalAgregarProducto">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Agregar Producto</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre del producto" required>
                </div>
                
              </div>
              <!-- username -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newCode" placeholder="Nuevo codigo" id="newCode" readonly>
                </div>
                
              </div>
              <!-- rol -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-bars"></i></span>
                  </div>
                  <select class="form-control" name="rol" id="rol">
                    <option value="Sin Categoría" required>Seleccionar categoría</option>
                    <?php 
                    $categories = ControladorCategorias::ctrMostrarCategorias(null, null);
                    foreach ($categories as $key => $categorie) {
                      echo '<option value="'.$categorie['id'].'">'.$categorie['name'].'</option>';                    }

                     ?>
                  </select>
                </div>
              </div>
                <!-- stock -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-check"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newStock" placeholder="Ingresar la cantidad en inventario" min="0" required>
                </div>
                
              </div>
                <!-- min max stock -->
              <div class="form-group row">
                <div class="input-group mb-3 col-6">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-box"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newMin" placeholder="Inventario bajo" min="0" required>
                </div>
                <div class="input-group mb-3 col-6">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-boxes"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newMax" placeholder="Inventario alto" min="0" required>
                </div>
                
              </div>
              
              <!-- precio de compra y venta -->
              <div class="form-group">

                  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-arrow-down"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newBuyPrice" placeholder="Ingresar el precio de compra" min="0" id="newBuyPrice" step="any" required>
                 </div>
                  <div class="form-group row">
                    <div class="form-group col-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-percent"></i></span>
                      <input type="number" class="form-control" id="nuevoPorcentaje" min="0" value="40" required>



                    </div>
                    
                  </div>

                    <div class="input-group mb-3 col-8">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-arrow-up"></i></span>
                    </div>
                    
                    <input class="form-control" type="number" step="any" name="newSellPrice" placeholder="Ingresar el precio de venta" min="0" id="newSellPrice" required readonly>
                    
                    </div>
                    
                  
                  </div>
                  <div class="form-group" style="padding: 0px">
                      <label>
                        <input type="checkbox" class="flat-red" id="checkNew" checked>
                        Utilizar porcentaje
                      </label>
                    </div>

                
                
                  
                
                
              </div>
              
              
              <!-- foto -->
              <div class="form-group">
                <div class="panel">SUBIR IMAGEN DEL PRODUCTO</div>
                <input type="file" class="photo" name="photo">
                <p class="help-block">Peso máximo de la imagen 2MB</p>
                <img src="Views/img/productos/default-product.jpg" class="img-thumbnail previsualizar" width="100px">
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="newProduct">Guardar Producto</button>
          </div>
        <?php 
          $crearProducto = new ControladorProductos();
          $crearProducto -> ctrCrearProducto();
         ?>
      </form>

    </div>
  </div>
</div>
  <!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEditarProducto">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post" enctype="multipart/form-data">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Editar Producto</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre del producto" id="nameEdit" required>
                  <input type="hidden" value="" id="editId" name="editId">
                </div>
                
              </div>
              <!-- username -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-barcode"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newCode" placeholder="Ingresar el nuevo codigo" id="codeEdit" required <?php if ($_SESSION['rank']!='Admin'){
                    echo'readonly';
                  } ?>>
                </div>
                
              </div>
              <!-- rol -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-bars"></i></span>
                  </div>
                  <select class="form-control" name="rol">
                    <option value="" id="rolEdit">Seleccionar categoría</option>
                    <?php 
                    $categories = ControladorCategorias::ctrMostrarCategorias(null, null);
                    foreach ($categories as $key => $categorie) {
                      echo '<option value="'.$categorie['id'].'">'.$categorie['name'].'</option>';                   
                    }

                     ?>
                  </select>
                </div>
              </div>
                <!-- stock -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-check"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newStock" placeholder="Ingresar la cantidad en inventario" min="0" id="stockEdit" required <?php if ($_SESSION['rank']!='Admin'){
                    echo'readonly';
                  } ?>>
                </div>
                
              </div>
              <!-- min max stock -->
              <div class="form-group row">
                <div class="input-group mb-3 col-6">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-box"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newMin" placeholder="Inventario bajo" min="0" id="minEdit" required>
                </div>
                <div class="input-group mb-3 col-6">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-boxes"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newMax" placeholder="Inventario alto" min="0" id="maxEdit" required>
                </div>
                
              </div>
              
              <!-- precio de compra y venta -->
              <div class="form-group">
                  <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-arrow-down"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newBuyPrice" placeholder="Ingresar el precio de compra" min="0" id="buyPriceEdit" step="any" required>
                 </div> 
                 <div class="form-group row">
                    <div class="form-group col-4">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-percent"></i></span>
                      <input type="number" class="form-control" min="0" value="40" id="editarPorcentaje" required>
                    </div>
                  </div>
                  <div class="input-group mb-3 col-8">
                    <div class="input-group-prepend">
                      <span class="input-group-text"><i class="fa fa-arrow-up"></i></span>
                    </div>
                    <input class="form-control" type="number" name="newSellPrice" placeholder="Ingresar el precio de venta" min="0" step="any" id="sellPriceEdit" required readonly>
                  </div>
                </div>
                  <div class="form-group" style="padding: 0px">
                      <label>
                        <input type="checkbox" class="flat-red" id="checkEdit" checked>
                        Utilizar porcentaje
                      </label>
                  </div>
              </div>
                 
              <!-- foto -->
              <div class="form-group">
                <div class="panel">ACTUALIZAR IMAGEN DEL PRODUCTO</div>
                <input type="file" class="photo" name="photo">
                <p class="help-block">Peso máximo de la foto 2MB</p>
                <img src="Views/img/productos/default-product.jpg" class="img-thumbnail previsualizar" width="100px" id="photoEdit">
                <input type="hidden" name="lastPhoto" id="lastPhoto">
              </div>
            </div>
          </div>
           <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="editProduct">Actualizar Producto</button>
          </div>
        <?php 
          $editarProducto = new ControladorProductos();
          $editarProducto -> ctrEditarProducto();
         ?>
      </form>

    </div>
  </div>
</div>
 <!--=====================================
  =          Ventana Modal Operar         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalOperarProducto">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title" id="tituloModal"></h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-cube"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre del producto" id="inventoryName" readonly>
                  <input type="hidden" id="idOperar" value="">

                  <input type="hidden" id="tipoDeOperacion" value="">
                </div>
                
              </div>
              <!-- username -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa" id="iconoOperar"></i></span>
                  </div>
                  
                  <input class="form-control" type="number" name="newNumber" placeholder="Ingresar el nuevo codigo" id="newQuantity" required>
                </div>
                
              </div>
              
          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="button" class="btn btn-success btnOperar">Modificar Inventario</button>
            <?php 
              $operarProducto = new ControladorProductos();
              $operarProducto -> ctrOperarProducto();
             ?>
          </div>

      </form>

    </div>
  </div>
  </div>
  </div>
</div>

  <?php 
    $borrarProducto = new ControladorProductos();
    $borrarProducto -> ctrBorrarProducto();

   ?>