<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reportes por producto</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Tablero</li>
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
          <div class="input-group">
            <button type="button" class="btn btn-default" id="daterange-btn3">
              <span id="reportrange3"><i class="fa fa-calendar"></i> Rango de fecha</span>
              <i class="fa fa-caret-down"></i>
            </button>

          </div>
          <div class="card-tools pull-right">
            <?php 
              if (isset($_GET['fechaInicial']) && isset($_GET['idProducto'])) {
                echo '<a href="Views/Modules/report-download.php?reporte=producto&idProducto='.$_GET['idProducto'].'&fechaInicial='.$_GET['fechaInicial'].'&fechaFinal='.$_GET['fechaFinal'].'"">';
              }elseif (isset($_GET['fechaInicial'])) {
                echo '<a href="Views/Modules/report-download.php?reporte=general&fechaInicial='.$_GET['fechaInicial'].'&fechaFinal='.$_GET['fechaFinal'].'"">';
              }elseif (isset($_GET['idProducto'])) {
                echo '<a href="Views/Modules/report-download.php?reporte=producto&idProducto='.$_GET['idProducto'].'"">';
              }else{
                echo '<a href="Views/Modules/report-download.php?reporte=general">';
              }
             ?>
            
            <button type="button" class="btn btn-success" style="margin-top: 5px"><i class="fa fa-file-excel"></i> Descargar reporte en Excel </button></a>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="card mx-3">
              <div class="card-header d-flex p-0">
                <div class="input-group">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-shopping-cart"></i></span>
                  </div>
                  <select class="form-control" id="product-get">
                    <?php 
                    $productsForReport = ControladorProductos::ctrMostrarProductos(null, null, 'sales');
                    if (isset($_GET['idProducto'])) {
                      foreach ($productsForReport as $key => $value) {
                        if ($_GET['idProducto']==$value['id']) {
                          $actual = $value['name'];
                        }
                      }
                      echo'<option value="'.$_GET['idProducto'].'">'.$actual.'</option>';
                    }else{
                      echo'<option value="">Seleccione un producto</option>';
                    }
                    
                    foreach ($productsForReport as $key => $value) {
                      echo '<option value="'.$value['id'].'">'.$value['name'].'</option>';                    
                    }
                    echo '<option value="">Limpiar selección</option>';
                     ?>
                  </select>
                </div>
              </div><!-- /.card-header -->
           </div>
        </div>
          <div class="row">
            <div class="col-sm-12">
              <?php 
                include "Reports/Products/sales-graphic.php";
               ?>
            </div>
          </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
        </div>
        <!-- /.card-footer-->
      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
 <!-- Personalizado -->
  <script src="Views/js/reportes-productos.js"></script>
  <!-- /.content-wrapper -->