<?php 
	error_reporting(0);
	 if (isset($_GET["fechaInicial"])) {
        $fechaInicial = $_GET['fechaInicial'];
        $fechaFinal = $_GET['fechaFinal'];
      }else{
        $fechaInicial = null;
        $fechaFinal = null;
      }
        $ventas = ControladorVentas::ctrRangoVentas($fechaInicial,$fechaFinal);
        $arrayFechas = array();
		$arrayVentas = array();
		$sumaPagosMes = array();
        foreach ($ventas as $key => $venta) {
        	$fecha = substr($venta['updated_at'], 0, 10);
        	array_push($arrayFechas, $fecha);
        	$arrayVentas = array($fecha => $venta['total']);
        	foreach ($arrayVentas as $key => $value) {
        		$sumaPagosMes[$key] += $value;
        	}

	  }
	  $noRepetirFechas = array_unique($arrayFechas);
 ?>	
 <!--=======================================
 =            GRAFICO DE VENTAs            =
 ========================================-->
 <div class="card bg-info">
	<div class="card-header">
		<span class="card-title"><i class="fa fa-th"></i> Gráfico de Ventas</span>
		<div class="card-tools">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
            <button type="button" class="btn btn-tool" data-widget="remove"><i class="fa fa-times"></i>
            </button>
          </div>
	</div>

	<div class="card-body border-radius-none nuevoGraficoVentas">
	  <div class="chart" id="line-chart-ventas" style="height: 250px;"></div>
	</div>
<!-- /.card-footer-->
</div>
<script>
	var line = new Morris.Line({
    element          : 'line-chart-ventas',
    resize           : true,
    data             : [
    <?php 
    if ($noRepetirFechas != null) {
	    foreach ($noRepetirFechas as $key) {
	    	echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." },";
	    }
	    echo "{ y: '".$key."', ventas: ".$sumaPagosMes[$key]." }";
	}else{
		if (isset($_GET['fechaInicial'])) {
			echo "{ y: '".$_GET['fechaInicial']."', ventas: 0 },";
			echo "{ y: '".$_GET['fechaFinal']."', ventas: 0 }";
		}else{
			echo "{ y: '0', ventas: 0 }";
		}
		
	}
     ?>
    ],
    xkey             : 'y',
    ykeys            : ['ventas'],
    labels           : ['Ventas'],
    lineColors       : ['#efefef'],
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#fff',
    xLabels          : 'day',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#efefef',
    gridTextFamily   : 'Open Sans',
    preUnits		 : '$',
    gridTextSize     : 10
  })</script>