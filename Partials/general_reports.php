<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Reportes Generales</h1>
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
            <button type="button" class="btn btn-default" id="daterange-btn2">
              <span id="reportrange2"><i class="fa fa-calendar"></i> Rango de fecha</span>
              <i class="fa fa-caret-down"></i>
            </button>

          </div>
          <div class="card-tools pull-right">
            <?php 
              if (isset($_GET['fechaInicial'])) {
                echo '<a href="Views/Modules/report-download.php?reporte=general&fechaInicial='.$_GET['fechaInicial'].'&fechaFinal='.$_GET['fechaFinal'].'"">';
              }else{
                echo '<a href="Views/Modules/report-download.php?reporte=general">';
              }
             ?>
            
            <button type="button" class="btn btn-success" style="margin-top: 5px"><i class="fa fa-file-excel"></i> Descargar reporte en Excel </button></a>
          </div>
        </div>

        <div class="card-body">
          <div class="row">
            <div class="col-sm-12">
              <?php 
                include "Reports/sales-graphic.php";
               ?>
            </div>
            <div class="col-md-6 col-sm-12">
              <?php 
                include "Reports/product-sales.php";
               ?>
            </div>
            <div class="col-md-6 col-sm-12">
              <?php 
                include "Reports/vendors.php";
               ?>
               <?php 
                include "Reports/clients.php";
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
  <!-- /.content-wrapper -->