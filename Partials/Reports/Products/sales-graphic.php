<?php 
	 if (isset($_GET["fechaInicial"])) {
        $fechaInicial = $_GET['fechaInicial'];
        $fechaFinal = $_GET['fechaFinal'];
      }else{
        $fechaInicial = null;
        $fechaFinal = null;
      }
      if (isset($_GET["idProducto"])) {
      	$item = 'product_id';
      	$valor = $_GET['idProducto'];
      }else{
      	$item = null;
      	$valor = null;
      }
      	$tabla = 'back_log';
      	if ($item == null) {
      		$ventasProductos = ModeloBacklog::mdlRangoVentas($tabla, $fechaInicial,$fechaFinal);
      	}else if ($item != null && $fechaInicial == null) {
      		$ventasProductos = ModeloBacklog::mdlMostrarRegistros($tabla,$valor,$item);
      	}else{
      		$ventasProductos = ModeloBacklog::mdlRangoVentas2($tabla, $fechaInicial,$fechaFinal,$item,$valor);
      	}
        
        $arrayResgistros = array();
        $arrayProductos2 = array();
        foreach ($ventasProductos as $key => $venta) {
        	if (isset($arrayResgistros[substr($venta['sell_date'], 0, 10)][$venta['product_id']])) {
        		$arrayResgistros[substr($venta['sell_date'], 0, 10)][$venta['product_id']] += $venta['quantity'];
        	}else{
        		$arrayResgistros[substr($venta['sell_date'], 0, 10)][$venta['product_id']] = $venta['quantity'];
        	}

	  }
	  $tope=5;
	  $item = null;
	  $value = null;
	  $orden = 'sales';
	  $productos2 = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
	  if (count($productos2)<$tope) {
	  	$tope = count($productos2);
	  }
	  for ($i=0; $i < $tope; $i++) {
	  	if (isset($productos2[$i])) {
	  		$arrayProductos2[$productos2[$i]['id']]=$productos2[$i]['name'];
	  	}
	  	
	  }
	  $colores = array('#999999','#43617D','#5A8DAB','#B5D3DB','#DAD2C7');
	  // $ykeys1 = array('a','b','c','d','e');
	  // $ykeys = array();
	  // foreach ($arrayProductos2 as $key => $value) {
	  // 	array_push(array, var)
	  // }
 ?>	
 <!--=======================================
 =            GRAFICO DE VENTAs            =
 ========================================-->
<div class="card">
              <div class="card-header d-flex p-0">
                <h3 class="card-title p-3">
                  <i class="fa fa-pie-chart mr-1"></i>
                  Ventas
                </h3>
              </div><!-- /.card-header -->
              <div class="card-body">
                <div class="tab-content p-0">
                  <!-- Morris chart - Sales -->
                  <div class="chart tab-pane active" id="revenue-chart"
                       style="position: relative; height: 300px;"></div>
                </div>
              </div><!-- /.card-body -->
 </div>
<script>
	var ykeys = [<?php 
	if (isset($_GET['idProducto'])) {
		echo "'a'";
	}else {
	    if ($arrayResgistros != null) {
	    	$i = 0;
		    foreach ($arrayProductos2 as $key => $value) {
		    	if ($i<($tope-1)) {
		    		echo "'".$value."', ";
		    	}else if($i<$tope){
		    		echo "'".$value."'";
		    	}
		    }
		 	
		    
		}else{
			echo "'a'";
		}
	}
     ?>];
    var colors = [<?php 
    if ($arrayResgistros != null) {
	    for ($i=0; $i < $tope; $i++) { 
	    	if ($i<($tope-1)) {
	    		echo "'".$colores[$i]."', ";
	    	}else{
	    		echo "'".$colores[$i]."'";
	    	}
	    }
	}else{
		echo "'#283143'";
	}
     ?>];
    var labels = [<?php 
    if(isset($_GET['idProducto'])){
    	foreach ($productos2 as $keyIdProducto => $valueIdProducto){
    		if ($valueIdProducto['id'] == $_GET['idProducto']) {
    			echo"'".$valueIdProducto['name']."'";
    		}
    	}
    }else{
	    if ($arrayResgistros != null) {
	    	$i=0;
		    foreach ($arrayProductos2 as $keyLabels => $valueLabels) {
		    	echo "'".$valueLabels."'";
		    	if ($i<($tope-1)) {
		    		echo ", ";
		    	}
		    	$i++;
		    }
		}else{
			echo "'Productos'";
		}
	}	
     ?>];
   	var datos = [<?php 
   	if(isset($_GET['idProducto'])){
	    if ($arrayResgistros != null) {
	    	$j=0;
	    	$otroTope = count($arrayResgistros);
		    foreach ($arrayResgistros as $key => $registro) {
		    	foreach ($registro as $key2 => $value) {
		    		echo "{ y: '".$key."', a:".$value."}";
		    	}
		    	if ($j<($otroTope-1)) {
					echo", ";
		    	}
		    	$j++;
		    }
    	}else{
    		if (isset($_GET['fechaInicial'])) {
				echo "{ y: '".$_GET['fechaInicial']."', a: 0 },";
				echo "{ y: '".$_GET['fechaFinal']."', a: 0 }";
			}else{
				echo "{ y: '0', a: 0 }";
			}
    	}
    }else{
	    if ($arrayResgistros != null) {
	    	$j=0;
	    	$otroTope = count($arrayResgistros);
		    foreach ($arrayResgistros as $key => $registro) {
		    	$i=0;
		    	echo "{ y: '".$key."'";
		    	foreach ($registro as $key2 => $value) {
		    		foreach ($arrayProductos2 as $key3 => $value2) {
		    			if ($key2 == $key3) {
		    				echo ", ".$value2.": ".$value."";
		    			}
		    		}	    		
		    		$i++;
		    	}
		    	echo"}";
		    	if ($j<($otroTope-1)) {
					echo", ";
		    	}
		    	$j++;
		    }
		}else{
			if (isset($_GET['fechaInicial'])) {
				echo "{ y: '".$_GET['fechaInicial']."', a: 0 },";
				echo "{ y: '".$_GET['fechaFinal']."', a: 0 }";
			}else{
				echo "{ y: '0', a: 0 }";
			}
			
		}
	}
     ?>];
	var line = new Morris.Area({
    element          : 'revenue-chart',
    resize           : true,
    data             : datos,
    xkey             : 'y',
    ykeys            : ykeys,
    labels           : labels,
    xLabels			 : 'day',
    lineColors       : colors,
    fillOpacity		 : 0.4,
    lineWidth        : 2,
    hideHover        : 'auto',
    gridTextColor    : '#666666',
    gridStrokeWidth  : 0.4,
    pointSize        : 4,
    pointStrokeColors: ['#efefef'],
    gridLineColor    : '#666666',
    gridTextFamily   : 'Open Sans',
    gridTextSize     : 10
  })</script>