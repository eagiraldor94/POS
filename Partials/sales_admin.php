<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Administración
              <small>/ Ventas</small></h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Ventas</li>
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
          <a href="ventas-crear">
            <button class="btn btn-danger"> Agregar Venta </button>
          </a>
          <button type="button" class="btn btn-default pull-right" id="daterange-btn">
            <span id="reportrange"><i class="fa fa-calendar"></i> Rango de fecha</span>
            <i class="fa fa-caret-down"></i>
          </button>
        </div>
        
        <div class="card-body">
          <table class="table table-bordered table-striped dt-responsive tabla">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Número de factura</th>
                <th>Cliente</th>
                <th>Vendedor
                <th>Forma de pago</th>
                <th>Neto</th>
                <th>Total</th>
                <th>Fecha</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
              if (isset($_GET["fechaInicial"])) {
                $fechaInicial = $_GET['fechaInicial'];
                $fechaFinal = $_GET['fechaFinal'];
              }else{
                $fechaInicial = null;
                $fechaFinal = null;
              }
                $ventas = ControladorVentas::ctrRangoVentas($fechaInicial,$fechaFinal);
                foreach ($ventas as $key => $venta) {
                  echo '
                  <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$venta['bill_number'].'</td>';
                    $value = $venta['client_id'];
                    $item = 'id';
                    $cliente = ControladorClientes::ctrMostrarClientes($item,$value);
                    echo '
                    <td>'.$cliente['name'].'</td>';
                    $value = $venta['vendor_id'];
                    $item = 'id';
                    $vendedor = ControladorUsuarios::ctrMostrarUsuarios($item,$value);
                    echo '
                    <td>'.$vendedor['name'].'</td>';
                    echo '
                    <td>'.$venta['pay_type'].'</td>
                    <td>'.number_format($venta['value'],2).'</td>
                    <td>'.number_format($venta['total'],2).'</td>
                    <td>'.$venta['updated_at'].'</td>
                    <td>
                      <div class="btn-group">
                        <button class="btn btn-info btnImprimirFactura" idVenta="'.$venta['id'].'"><i class="fa fa-print"></i></button>';
                        if ($_SESSION['rank']=='Admin') {
                          echo'
                        <button class="btn btn-warning btnEditarVenta" idVenta="'.$venta['id'].'"><i class="fa fa-pen" ></i></button>
                        <button class="btn btn-danger btnBorrarVenta" idVenta="'.$venta['id'].'"><i class="fa fa-times"></i></button>';
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
  <?php 
    $borrarVenta = new ControladorVentas();
    $borrarVenta -> ctrBorrarVenta();
   ?>