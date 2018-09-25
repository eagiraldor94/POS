<?php 

/**
 * 
 */
function excelPOS($ventas,$Name){
		/*===================================
			=            EXCEL CREATE            =
			===================================*/
			date_default_timezone_set('America/Bogota');
			$momento = date("Y-m-d_h-i-s");
			header('Expires: 0');
			header('Cache-control: private');
			header("Content-type: application/vnd.ms-excel"); // Archivo de Excel
			header("Cache-Control: cache, must-revalidate"); 
			header('Content-Description: File Transfer');
			header('Last-Modified: '.date('D, d M Y H:i:s'));
			header("Pragma: public"); 
			header('Content-Disposition:; filename="'.$Name.'"');
			header("Content-Transfer-Encoding: binary");
			echo utf8_decode("<table border='0'>
					<tr> 
					<td style='font-weight:bold; border:1px solid #eee;'>FACTURA</td> 
					<td style='font-weight:bold; border:1px solid #eee;'>CLIENTE</td>
					<td style='font-weight:bold; border:1px solid #eee;'>VENDEDOR</td>
					<td style='font-weight:bold; border:1px solid #eee;'>CANTIDAD</td>
					<td style='font-weight:bold; border:1px solid #eee;'>PRODUCTOS</td>
					<td style='font-weight:bold; border:1px solid #eee;'>DESCUENTO(%)</td>
					<td style='font-weight:bold; border:1px solid #eee;'>IMPUESTO</td>
					<td style='font-weight:bold; border:1px solid #eee;'>NETO</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>TOTAL</td>		
					<td style='font-weight:bold; border:1px solid #eee;'>METODO DE PAGO</td	
					<td style='font-weight:bold; border:1px solid #eee;'>FECHA</td>		
					</tr>");

			foreach ($ventas as $row => $item){

				$cliente = ControladorClientes::ctrMostrarClientes("id", $item["client_id"]);
				$vendedor = ControladorUsuarios::ctrMostrarUsuarios("id", $item["vendor_id"]);

			 echo utf8_decode("<tr>
			 			<td style='border:1px solid #eee;'>".$item["bill_number"]."</td> 
			 			<td style='border:1px solid #eee;'>".$cliente["name"]."</td>
			 			<td style='border:1px solid #eee;'>".$vendedor["name"]."</td>
			 			<td style='border:1px solid #eee;'>");

			 	$productos =  json_decode($item["products"], true);

			 	foreach ($productos as $key => $valueProductos) {
			 			
			 			echo utf8_decode($valueProductos["quantity"]."<br>");
			 		}

			 	echo utf8_decode("</td><td style='border:1px solid #eee;'>");	

		 		foreach ($productos as $key => $valueProductos) {
			 			
		 			echo utf8_decode($valueProductos["name"]."<br>");
		 		
		 		}

		 		echo utf8_decode("</td>
					<td style='border:1px solid #eee;'>".$item["discount"]."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["tax"],2)."</td>
					<td style='border:1px solid #eee;'>$ ".number_format($item["value"],2)."</td>	
					<td style='border:1px solid #eee;'>$ ".number_format($item["total"],2)."</td>
					<td style='border:1px solid #eee;'>".$item["pay_type"]."</td>
					<td style='border:1px solid #eee;'>".substr($item["updated_at"],0,10)."</td>		
		 			</tr>");


			}


			echo "</table>";
	}
class ControladorVentas 
{
	
	/*===================================
	=            SALE CREATE            =
	===================================*/
	
	static public function ctrCrearVenta(){

		if (isset($_POST['newBill'])) {
			if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["newBillNumber"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newVendorId"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newClientId"])  &&
			   preg_match('/^[0-9.]+$/', $_POST["newNeto"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["newTotal"])&&
			   preg_match('/^[0-9.]+$/', $_POST["newTaxValue"])
				) {
				
				if($_POST['newPaymentMethod'] != "Efectivo"){
					$metodoPago = $_POST['newPaymentMethod'].'-'.$_POST['newTransactionCode'];
				}else{
					$metodoPago = $_POST['newPaymentMethod'];
				}
			   	$tabla = "sales";
			   $datos = array("bill_number"=> $_POST['newBillNumber'],
					   		"client_id"=> $_POST['newClientId'],
					   		"vendor_id"=> $_POST['newVendorId'],
					   		"pay_type"=> $metodoPago,
					   		"products"=> $_POST['productList'],
					   		"discount"=> $_POST['newDiscount'],
					   		"tax"=> $_POST['newTaxValue'],
					   		"value"=> $_POST['newNeto'],
					   		"total"=> $_POST['newTotal']);
			   $item = null;
			   $valor = null;
			   $verificarFactura = ModeloVentas::mdlMostrarVentas($tabla,$valor,$item);
			   foreach ($verificarFactura as $key => $factura) {
			   	if ($datos['bill_number']==$factura['bill_number']) {
			   		$datos['bill_number'] += 1;
			   	}
			   }
			   $answer = ModeloVentas::mdlIngresarVenta($tabla,$datos);
			   $tabla = 'clients';
				$item = 'id';
				$value = $_POST['newClientId'];
				$traerCliente = ModeloClientes::mdlMostrarClientes($tabla,$value,$item);
				$item = 'buys';
				$value = $traerCliente['buys']+1;
				$id = $_POST['newClientId'];
				$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
				$item = 'balance';
				$value = $traerCliente['balance']+$_POST['newTotal'];
				$id = $_POST['newClientId'];
				$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
			   $listaProductos = json_decode($_POST['productList'], true);
			   $tabla = 'sales';
			   $item1 = 'bill_number';
			   $valor1 = $datos['bill_number'];
				$obtenerIdVenta = ModeloVentas::mdlMostrarVentas($tabla,$valor1,$item1);
				$idVenta = $obtenerIdVenta['id'];
				$discount = $obtenerIdVenta['discount'];
				$tabla = "clients";
				$item = 'last_buy';
				$value = $obtenerIdVenta['created_at'];
				$id = $_POST['newClientId'];
				$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
				foreach ($listaProductos as $key => $producto) {
					$tabla = 'products';
					$item = "id";
					$valor = $producto["id"];
					$orden = 'id';
					$traerProducto = ModeloProductos::mdlMostrarProductos($tabla,$valor,$item,$orden);
					$item1 = 'sales';
					$valor1 = $producto['quantity'] + $traerProducto['sales'];
					$actualizarVentas= ModeloProductos::mdlModificarProducto($tabla,$item1,$valor1,$valor);
					$item2 = 'stock';
					$valor2 = $producto['stock'];
					$actualizarStock = ModeloProductos::mdlModificarProducto($tabla,$item2,$valor2,$valor);
					$tabla = 'back_log';
					$datos['product_id'] = $producto['id'];
					$datos['client_id'] = $_POST['newClientId'];
					$datos['sale_id'] = $idVenta;
					$datos['quantity'] = $producto['quantity'];
					$datos['price']= $producto['total']*(100-$discount)/100;
					$crearLog = ModeloBacklog::mdlIngresarRegistro($tabla,$datos);
				}
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡La venta ha sido guardada correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "ventas-administrar";
								}
							});
			   	</script>';
			   }else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los campos de la venta no pueden ir vacios o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "ventas-administrar";
								}
							});
			 	</script>';
			 }   		
			   		
			   	}
			   	
			   	
	}
}
/*===================================
	=            SALE EDIT           =
	===================================*/
	
	static public function ctrEditarVenta(){

		if (isset($_POST['editBill'])) {
			if (preg_match('/^[a-zA-Z0-9]+$/', $_POST["newBillNumber"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newVendorId"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newClientId"])  &&
			   preg_match('/^[0-9.]+$/', $_POST["newNeto"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["newTotal"])&&
			   preg_match('/^[0-9.]+$/', $_POST["newTaxValue"])
				) {
				/*=======================================
				=           Formatear tablas            =
				=======================================*/
				$table = "sales";
				$item = 'id';
				$value = $_POST['editSaleId'];
					
				$traerVentas = ModeloVentas::mdlMostrarVentas($table,$value,$item);

				$productosViejos = json_decode($traerVentas['products'],true);
				$listaProductos = json_decode($_POST['productList'], true);
				$array1 = array_column($productosViejos, 'id','quantity');

				$array2 = array_column($listaProductos, 'id','quantity');
				if ($array1==$array2) {
					$cambios = false;
				}else{
					$cambios = true;
				}
				if ($cambios) {
					$tabla = 'back_log';
					$item = 'sale_id';
					$borrarLog = ModeloBacklog::mdlBorrarRegistro($tabla, $item, $value);
					foreach ($productosViejos as $key => $producto) {
						if ($producto['id'] == $listaProductos[$key]['id'] &&
							$producto['quantity'] == $listaProductos[$key]['quantity']) {

						}else{
						$tabla = 'products';
						$item = "id";
						$valor = $producto["id"];
						$orden = 'id';
						$traerProducto = ModeloProductos::mdlMostrarProductos($tabla,$valor,$item,$orden);
						$item1 = 'stock';
						$valor1 = $producto['quantity'] + $traerProducto['stock'];
						$actualizarVentas= ModeloProductos::mdlModificarProducto($tabla,$item1,$valor1,$valor);
						$item2 = 'sales';
						$valor2 = $traerProducto['sales']-$producto['quantity'];
						$actualizarStock = ModeloProductos::mdlModificarProducto($tabla,$item2,$valor2,$valor);
						}
					}
					$tabla = 'clients';
					$item = 'id';
					$value = $_POST['newClientId'];
					$traerCliente = ModeloClientes::mdlMostrarClientes($tabla,$value,$item);
					$item = 'buys';
					$value = $traerCliente['buys']-1;
					$id = $_POST['newClientId'];
					$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
					$item = 'balance';
					$value = $traerCliente['balance']-$traerVentas['total'];
					$id = $_POST['newClientId'];
					$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
					/*=======================================
					=            Actualizar info            =
					=======================================*/
					
					$idVenta = $_POST['editSaleId'];
					foreach ($listaProductos as $key => $producto) {
						if ($producto['id'] == $productosViejos[$key]['id'] &&
							$producto['quantity'] == $productosViejos[$key]['quantity']) {
							
						}else{
						$tabla = 'products';
						$item = "id";
						$valor = $producto["id"];
						$orden = 'id';
						$traerProducto = ModeloProductos::mdlMostrarProductos($tabla,$valor,$item,$orden);
						$item1 = 'sales';
						$valor1 = $producto['quantity'] + $traerProducto['sales'];
						$actualizarVentas= ModeloProductos::mdlModificarProducto($tabla,$item1,$valor1,$valor);
						$item2 = 'stock';
						$valor2 = $producto['stock'];
						$actualizarStock = ModeloProductos::mdlModificarProducto($tabla,$item2,$valor2,$valor);
						}
						$tabla = 'back_log';
						$datos['product_id'] = $producto['id'];
						$datos['client_id'] = $_POST['newClientId'];
						$datos['sale_id'] = $idVenta;
						$datos['quantity'] = $producto['quantity'];
						$datos['price']= $producto['total']*(100-$_POST['newDiscount'])/100;
						$crearLog = ModeloBacklog::mdlIngresarRegistro($tabla,$datos);
					}
					$tabla = 'clients';
					$item = 'id';
					$value = $_POST['newClientId'];
					$traerCliente = ModeloClientes::mdlMostrarClientes($tabla,$value,$item);
					$item = 'buys';
					$value = $traerCliente['buys']+1;
					$id = $_POST['newClientId'];
					$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
					$item = 'balance';
					$value = $traerCliente['balance']+$_POST['newTotal'];
					$id = $_POST['newClientId'];
					$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);					
				}

				if($_POST['newPaymentMethod'] != "Efectivo"){
						$metodoPago = $_POST['newPaymentMethod'].'-'.$_POST['newTransactionCode'];
					}else{
						$metodoPago = $_POST['newPaymentMethod'];
					}
			   	$tabla = "sales";
			   $datos = array("bill_number"=> $_POST['newBillNumber'],
					   		"client_id"=> $_POST['newClientId'],
					   		"vendor_id"=> $_POST['newVendorId'],
					   		"pay_type"=> $metodoPago,
					   		"products"=> $_POST['productList'],
					   		"discount"=> $_POST['newDiscount'],
					   		"tax"=> $_POST['newTaxValue'],
					   		"value"=> $_POST['newNeto'],
					   		"total"=> $_POST['newTotal']); 
			   $answer = ModeloVentas::mdlActualizarVenta($tabla,$datos);
			   	$tabla = 'sales';
				$item = 'bill_number';
			   	$valor = $datos['bill_number'];
				$obtenerIdVenta = ModeloVentas::mdlMostrarVentas($tabla,$valor,$item);
				$tabla = "clients";
				$item = 'last_buy';
				$value = $obtenerIdVenta['updated_at'];
				$id = $obtenerIdVenta['client_id'];
				$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡La venta ha sido editada correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "ventas-administrar";
								}
							});
			   	</script>';
			   }else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los campos de la venta no pueden ir vacios o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "ventas-administrar";
								}
							});
			 	</script>';
			 }   		
			   		
			   	}
			   	
			   	
	}
}
	/*=======================================
	=            Listar Ventas            =
	=======================================*/
	static public function ctrMostrarVentas($item,$value){
		$table = "sales";
		
		$answer = ModeloVentas::mdlMostrarVentas($table,$value,$item);

		return $answer;
	}
	
	/*======================================
	=            Borrar Venta            =
	======================================*/
	static public function ctrBorrarVenta(){
		if (isset($_GET['idVenta'])) {
				$table = "sales";
				$item = 'id';
				$value = $_GET['idVenta'];
				
				$traerVentas = ModeloVentas::mdlMostrarVentas($table,$value,$item);
				$fechas = array();
				/*======================================
				=            Actualizar fecha ultima compra           =
				======================================*/
				$itemVentas = null;
				$valorVentas = null;
				$traerTodasVentas=ModeloVentas::mdlMostrarVentas($table,$itemVentas,$valorVentas);
				foreach ($traerTodasVentas as $key => $venta) {
					if($venta['client_id']==$traerVentas['client_id']){
						array_push($fechas, $venta['created_at']);
					}
				}
				if (count($fechas)>1){
					if ($traerVentas['created_at'] > $fechas[count($fechas)-2]) {
						$tabla = 'clients';
						$item = 'last_buy';
						$valor = $fechas[count($fechas)-2];
						$id = $traerVentas['client_id'];
						$fechaCompras = ModeloClientes::mdlModificarCliente($tabla,$item, $valor, $id);
					}
				}else{
					$tabla = 'clients';
					$item = 'last_buy';
					$valor = '0000-00-00 00:00:00';
					$id = $traerVentas['client_id'];
					$fechaCompras = ModeloClientes::mdlModificarCliente($tabla,$item, $valor, $id);
				}
				$productosViejos = json_decode($traerVentas['products'],true);
				$tabla = 'back_log';
				$item = 'sale_id';
				$borrarLog = ModeloBacklog::mdlBorrarRegistro($tabla, $item, $value);
				foreach ($productosViejos as $key => $producto) {
					$tabla = 'products';
					$item = "id";
					$valor = $producto["id"];
					$orden = 'id';
					$traerProducto = ModeloProductos::mdlMostrarProductos($tabla,$valor,$item,$orden);
					$item1 = 'stock';
					$valor1 = $producto['quantity'] + $traerProducto['stock'];
					$actualizarVentas= ModeloProductos::mdlModificarProducto($tabla,$item1,$valor1,$valor);
					$item2 = 'sales';
					$valor2 = $traerProducto['sales']-$producto['quantity'];
					$actualizarStock = ModeloProductos::mdlModificarProducto($tabla,$item2,$valor2,$valor);
				}
				$tabla = 'clients';
				$item = 'id';
				$value = $traerVentas['client_id'];
				$traerCliente = ModeloClientes::mdlMostrarClientes($tabla,$value,$item);
				$item = 'buys';
				$value = $traerCliente['buys']-1;
				$id = $traerVentas['client_id'];
				$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);
				$item = 'balance';
				$value = $traerCliente['balance']-$traerVentas['total'];
				$id = $traerVentas['client_id'];
				$modificarCompras=ModeloClientes::mdlModificarCliente($tabla,$item, $value, $id);		
		$table = 'sales';
		$item = 'id';
		$value = $_GET['idVenta'];
		$answer = ModeloVentas::mdlBorrarVenta($table, $item, $value);
		if ($answer == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡La venta ha sido borrada con exito!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "ventas-administrar";
								}
							});
			 	</script>';
		}
		}
	}
	/*======================================
	=            RANGO FECHAS           =
	======================================*/
	public static function ctrRangoVentas($fechaInicial,$fechaFinal){
		$tabla ='sales';
		$answer = ModeloVentas::mdlRangoVentas($tabla, $fechaInicial, $fechaFinal);
		return $answer;
	}
	/*===================================
	=            EXCEL DOWNLOAD            =
	===================================*/
	static public function ctrDescargarReporte(){
		if(isset($_GET['reporte']) && $_GET['reporte']=='general'){
			$tabla = 'sales';
			if (isset($_GET['fechaInicial']) && isset($_GET['fechaFinal'])) {
				$ventas = ModeloVentas::mdlRangoVentas($tabla, $_GET['fechaInicial'], $_GET['fechaFinal']);
			}else{
				$item=null;
				$valor=null;
				$ventas = ModeloVentas::mdlMostrarVentas($tabla, $valor, $item);
			}
			/*===================================
			=            EXCEL CREATE            =
			===================================*/
			date_default_timezone_set('America/Bogota');
			$momento = date("Y-m-d_h-i-s");
			$Name = $_GET['reporte'].'_'.$momento.'.xls';
			excelPOS($ventas,$Name);

		}else if(isset($_GET['reporte']) && $_GET['reporte']=='producto'){
			$tabla = 'back_log';
			$item =  'product_id';
			$valor = $_GET['idProducto'];
			$idArray = array();
			$ventas = array();
			if (isset($_GET['fechaInicial']) && isset($_GET['fechaFinal'])) {
				$ventas1 = ModeloBacklog::mdlRangoVentas2($tabla, $_GET['fechaInicial'], $_GET['fechaFinal'],$item,$valor);
			}else{
				$ventas1 = ModeloBacklog::mdlMostrarRegistros($tabla, $valor,$item);
			}
			foreach ($ventas1 as $key => $value) {
				array_push($idArray, $value['sale_id']);
			}
			$idArray2 = array_unique($idArray);
			foreach ($idArray2 as $key => $value) {
				$temp = ModeloVentas::mdlMostrarVentas('sales',$value,'id');
				array_push($ventas, $temp);
			}
			/*===================================
			=            EXCEL CREATE            =
			===================================*/
			date_default_timezone_set('America/Bogota');
			$momento = date("Y-m-d_h-i-s");
			$Name = $_GET['reporte'].'_'.$_GET['idProducto'].'_'.$momento.'.xls';
			excelPOS($ventas,$Name);

		}else if(isset($_GET['reporte']) && $_GET['reporte']=='cliente'){
			$tabla = 'sales';
			$item = 'client_id';
			$valor=$_GET['idCliente'];
			if (isset($_GET['fechaInicial']) && isset($_GET['fechaFinal'])) {
				$ventas = ModeloVentas::mdlRangoVentas2($tabla, $_GET['fechaInicial'], $_GET['fechaFinal'],$item,$valor);
			}else{
				$ventas = ModeloVentas::mdlRangoVentas2($tabla, null, null,$item,$valor);
			}
			/*===================================
			=            EXCEL CREATE            =
			===================================*/
			date_default_timezone_set('America/Bogota');
			$momento = date("Y-m-d_h-i-s");
			$Name = $_GET['reporte'].'_'.$_GET['idCliente'].'_'.$momento.'.xls';
			excelPOS($ventas,$Name);
		}
	}
	static public function ctrSumaVentas(){
		$tabla = 'sales';
		$answer = ModeloVentas::mdlSumaVentas($tabla);
		return $answer;
	}
	
}
