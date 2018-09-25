<?php 
  $item = null;
  $valor = null;
  $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
  $usuarios = ControladorUsuarios::ctrMostrarUsuarios($item,$valor);
  $arrayVendedores = array();
  foreach ($ventas as $key => $venta) {
    foreach ($usuarios as $key2 => $usuario) {
      if ($venta['vendor_id']==$usuario['id']) {
        $arrayVendedores[$usuario['name']] += $venta['value'];
      }   
    }
  }
 ?>
<!--=======================================
 =            GRAFICO DE VENTAs            =
 ========================================-->
 <div class="card">
	<div class="card-header bg-success">
		<span class="card-title"><i class="fa fa-user"></i>Vendedores</span>
		<div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
	</div>

	<div class="card-body">
	  <div class="chart-responsive">
	  	<div class="chart" id="barChart1" style="height: 300px;"></div>
	  </div>
	</div>
<!-- /.card-footer-->
</div>
<script>
	//-------------
    //- BAR CHART -
    //-------------
    var bar = new Morris.Bar({
      element: 'barChart1',
      resize: true,
      data: [
      <?php
      foreach ($arrayVendedores as $key => $value) {
        echo "{y:'".$key."', a:".$value."},";
      }
      ?>
      ],
      barColors: ['#20c997'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Ventas netas'],
      preUnits: '$',
      hideHover: 'auto'
    })
</script>