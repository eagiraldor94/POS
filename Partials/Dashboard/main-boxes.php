 <?php 
  $ventas = ControladorVentas::ctrSumaVentas();
  $item= null;
  $value = null;
  $orden = 'id';
  $categorias = ControladorCategorias::ctrMostrarCategorias($item,$value);
  $clientes = ControladorClientes::ctrMostrarClientes($item,$value);
  $productos = ControladorProductos::ctrMostrarProductos($item,$value,$orden);


 ?>
<!-- Small boxes (Stat box) -->
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-info">
    <div class="inner">
      <h3>$ <?php echo number_format($ventas['total'],2); ?></h3>

      <p>Ventas</p>
    </div>
    <div class="icon">
      <i class="ion ion-social-usd"></i>
    </div>
    <a href="ventas-administrar" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-success">
    <div class="inner">
      <h3><?php echo count($categorias); ?></h3>

      <p>Categorias</p>
    </div>
    <div class="icon">
      <i class="ion ion-clipboard"></i>
    </div>
    <a href="categorias" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-warning">
    <div class="inner">
      <h3><?php echo count($clientes); ?></h3>

      <p>Clientes</p>
    </div>
    <div class="icon">
      <i class="ion ion-person-add"></i>
    </div>
    <a href="clientes" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
<div class="col-lg-3 col-6">
  <!-- small box -->
  <div class="small-box bg-danger">
    <div class="inner">
      <h3><?php echo count($productos); ?></h3>

      <p>Productos</p>
    </div>
    <div class="icon">
      <i class="ion ion-ios-cart"></i>
    </div>
    <a href="productos" class="small-box-footer">Más información <i class="fa fa-arrow-circle-right"></i></a>
  </div>
</div>
<!-- ./col -->
