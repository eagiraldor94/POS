<?php 
  $item= null;
  $value = null;
  $orden = 'id';
  $productos = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
  if (count($productos <10)) {
    $tope = count($productos);
  }else{
    $tope = 10;
  }
 ?>

<!-- PRODUCT LIST -->
<div class="card">
  <div class="card-header">
    <h3 class="card-title">Últimos productos</h3>

    <div class="card-tools">
      <button type="button" class="btn btn-tool" data-widget="collapse">
        <i class="fa fa-minus"></i>
      </button>
      <button type="button" class="btn btn-tool" data-widget="remove">
        <i class="fa fa-times"></i>
      </button>
    </div>
  </div>
 <!-- /.card-header -->
  <div class="card-body p-0">
    <ul class="products-list product-list-in-card pl-2 pr-2">
      <?php 
      for ($i=0; $i < $tope ; $i++) { 
        echo'<li class="item">
        <div class="product-img">
          <img src="'.$productos[$i]['photo'].'" alt="Product Image" class="img-size-50">
        </div>
        <div class="product-info">
          <a href="productos" class="product-title">'.$productos[$i]['name'].'
            <span class="badge badge-warning float-right">$ '.number_format($productos[$i]['sell_price'],2).'</span></a>
        </div>
      </li>';
      }
      
      ?>
    </ul>
  </div>
  <!-- /.card-body -->
  <div class="card-footer text-center">
    <a href="productos" class="uppercase">Ver todos los productos</a>
  </div>
  <!-- /.card-footer -->
</div>
<!-- /.card -->