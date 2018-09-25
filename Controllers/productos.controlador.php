<?php 

/**
 * 
 */
class ControladorProductos
{

	/*===================================
	=            PRODUCT CREATE            =
	===================================*/
	
	static public function ctrCrearProducto(){

		if (isset($_POST['newProduct'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newStock"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newCode"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newMin"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newMax"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["newBuyPrice"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["newSellPrice"])) {
			   	/*======================================
			   	=            Validar Imagen            =
			   	======================================*/
			   	$ruta="";
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/productos/".$_POST['newCode'];
			   		mkdir($directorio,0755);
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.png';
			   				$origen = imagecreatefrompng($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   		
			   		
			   	}
			   	
			   	$tabla = "products";
			   $datos = array("name"=> $_POST['newName'],
					   		"code"=> $_POST['newCode'],
					   		"stock"=> $_POST['newStock'],
					   		"min_stock"=> $_POST['newMin'],
					   		"max_stock"=> $_POST['newMax'],
					   		"categorie_id"=> $_POST['rol'],
					   		"photo"=> $ruta,
					   		"buy_price"=> $_POST['newBuyPrice'],
					   		"sell_price"=> $_POST['newSellPrice']); 
			   $answer = ModeloProductos::mdlIngresarProducto($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El producto ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡El producto no puede llevar campos vacios o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
			 	</script>';
			 }
		}

	}
	/*=======================================
	=            Listar Productos            =
	=======================================*/
	static public function ctrMostrarProductos($item,$value,$orden){
		$table = "products";
		
		$answer = ModeloProductos::mdlMostrarProductos($table,$value,$item,$orden);

		return $answer;
	}
	/*===================================
	=            Editar Producto            =
	===================================*/
	
	static public function ctrEditarProducto(){

		if (isset($_POST['editProduct'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newStock"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newCode"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newMin"]) &&
			   preg_match('/^[0-9]+$/', $_POST["newMax"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["newBuyPrice"]) &&
			   preg_match('/^[0-9.]+$/', $_POST["newSellPrice"])) {
			   	/*======================================
			   	=            Validar Imagen             =
			   	======================================*/
			   	$ruta=$_POST['lastPhoto'];
			   	if (isset($_FILES['photo']['tmp_name']) && !empty($_FILES['photo']['tmp_name'])) {
			   		list($ancho,$alto) = getimagesize($_FILES['photo']['tmp_name']);
			   		$nuevoAncho = 500;
			   		$nuevoAlto = 500;
			   		/*==========================================
			   		=            CREANDO DIRECTORIO            =
			   		==========================================*/
			   		$directorio = "Views/img/productos/".$_POST['newCode'];
			   		if (!empty($_POST['lastPhoto'])) {
			   			unlink($_POST['lastPhoto']);
			   		}else{
			   			mkdir($directorio,0755);
			   		}
			   		
			   		
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newCode'].'_'.$preruta.'.png';
			   				$origen = imagecreatefrompng($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagepng($destino,$ruta);
			   				break;
			   			default:
			   				# code...
			   				break;
			   		}
			   		
			   		
			   	}
			   	
			   	$tabla = "products";
			   	
			   $datos = array("name"=> $_POST['newName'],
					   		"code"=> $_POST['newCode'],
					   		"stock"=> $_POST['newStock'],
					   		"min_stock"=> $_POST['newMin'],
					   		"max_stock"=> $_POST['newMax'],
					   		"categorie_id"=> $_POST['rol'],
					   		"photo"=> $ruta,
					   		"buy_price"=> $_POST['newBuyPrice'],
					   		"sell_price"=> $_POST['newSellPrice'],
					   		"id"=> $_POST['editId']); 
			   $answer = ModeloProductos::mdlActualizarProducto($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El producto ha sido actualizado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡El nombre del producto y el codigo no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
			 	</script>';
			 }
		}

	}
	/*======================================
	=            Borrar Producto            =
	======================================*/
	static public function ctrBorrarProducto(){
		if (isset($_GET['idProducto'])) {
			if ($_GET['fotoProducto'] != "") {
				unlink($_GET["fotoProducto"]);
				rmdir('Views/img/productos/'.$_GET['producto']);
			}
		$table = 'products';
		$item = 'id';
		$value = $_GET['idProducto'];
		$answer = ModeloProductos::mdlBorrarProducto($table, $item, $value);
		if ($answer == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡El producto ha sido borrado con exito!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
			 	</script>';
		}
		}
	}
	/*======================================
	=            Operar Producto            =
	======================================*/
	static public function ctrOperarProducto(){
		if (isset($_GET['idOperar'])){
		$table = 'products';
		$item = 'id';
		$value = $_GET['idOperar'];
		$operador = $_GET['tipoDeOperacion'];
		$cantidad = $_GET['cantidad'];
		$answer = ModeloProductos::mdlObtenerInventario($table, $item, $value);
		$stock = $answer['stock'];
		if (preg_match('/^[0-9]+$/', $cantidad)) {
			switch ($operador) {
				case 'suma':
					$stock += $cantidad;
					break;
				case 'resta':
					$stock -= $cantidad;
					break;
				default:
					# code...
					break;
			}
		}
		
		
		$answer2 = ModeloProductos::mdlActualizarInventario($table, $item, $value, $stock);
		if ($answer2 == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡El inventario se ha actualizado!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "productos";
								}
							});
			 	</script>';
		}
		}
	}
	static public function ctrMostrarSumaVentas(){
		$tabla = 'products';
		$answer = ModeloProductos::mdlMostrarSumaVentas($tabla);
		return $answer;
	}
}
