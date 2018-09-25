 <?php 
  $item = null;
  $valor = null;
  $ventas = ControladorVentas::ctrMostrarVentas($item, $valor);
  $clientes = ControladorClientes::ctrMostrarClientes($item,$valor);
  $arrayClientes = array();
  foreach ($ventas as $key => $venta) {
    foreach ($clientes as $key2 => $cliente) {
      if ($venta['client_id']==$cliente['id']) {
        $arrayClientes[$cliente['name']] += $venta['value'];
      }   
    }
  }
 ?>
 <!--=======================================
 =            GRAFICO DE VENTAs            =
 ========================================-->
 <div class="card">
	<div class="card-header bg-primary">
		<span class="card-title"><i class="fa fa-user"></i>Clientes</span>
		<div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
	</div>

	<div class="card-body">
	  <div class="chart-responsive">
	  	<div class="chart" id="barChart2" style="height: 300px;"></div>
	  </div>
	</div>
<!-- /.card-footer-->
</div>
<script>
  //-------------
    //- BAR CHART -
    //-------------
    var bar = new Morris.Bar({
      element: 'barChart2',
      resize: true,
      data: [
      <?php
      foreach ($arrayClientes as $key => $value) {
        echo "{y:'".$key."', a:".$value."},";
      }
      ?>
      ],
      barColors: ['#0af'],
      xkey: 'y',
      ykeys: ['a'],
      labels: ['Compras netas'],
      preUnits: '$',
      hideHover: 'auto'
    })
</script>