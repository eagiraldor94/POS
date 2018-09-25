<?php 

/**
 * 
 */
class ControladorProveedores
{
	/*===================================
	=            PROVIDER CREATE            =
	===================================*/
	
	static public function ctrCrearProveedor(){

		if (isset($_POST['newProvider'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) && preg_match('/^[\-0-9]+$/', $_POST["newDocument"]) && 
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["newEmail"]) && 
			   preg_match('/^[()\-0-9 ]+$/', $_POST["newPhone1"])) {
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
			   		$directorio = "Views/img/proveedores/".$_POST['newDocument'];
			   		mkdir($directorio,0755);
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newDocument'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newDocument'].'_'.$preruta.'.png';
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
			   	
			   	$tabla = "providers";
			   $datos = array("name"=> $_POST['newName'],
					   		"id_number"=> $_POST['newDocument'],
					   		"id_type"=> $_POST['idType'],
					   		"address"=> $_POST['newAddress'],
					   		"city"=> $_POST['newCity'],
					   		"phone1"=> $_POST['newPhone1'],
					   		"phone2"=> $_POST['newPhone2'],
					   		"email"=> $_POST['newEmail'],
					   		"photo"=> $ruta); 
			   $answer = ModeloProveedores::mdlIngresarProveedor($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El proveedor ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "proveedores";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los datos del proveedor no pueden ir vacíos o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "proveedores";
								}
							});
			 	</script>';
			 }
		}

	}
	/*=======================================
	=            Listar Proveedores            =
	=======================================*/
	static public function ctrMostrarProveedores($item,$value){
		$table = "providers";
		
		$answer = ModeloProveedores::mdlMostrarProveedores($table,$value,$item);

		return $answer;
	}
	/*===================================
	=            Provider EDIT            =
	===================================*/
	
	static public function ctrEditarProveedor(){

		if (isset($_POST['editProvider'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) && preg_match('/^[\-0-9]+$/', $_POST["newDocument"]) &&
			   preg_match('/^[^0-9][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[@][a-zA-Z0-9_]+([.][a-zA-Z0-9_]+)*[.][a-zA-Z]{2,4}$/', $_POST["newEmail"]) && 
			   preg_match('/^[()\-0-9 ]+$/', $_POST["newPhone1"])) {
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
			   		$directorio = "Views/img/proveedores/".$_POST['newDocument'];
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
			   				$ruta = $directorio.'/'.$_POST['newDocument'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newDocument'].'_'.$preruta.'.png';
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
			   	
			   	$tabla = "providers";
			   	
			   $datos = array("name"=> $_POST['newName'],
					   		"id_number"=> $_POST['newDocument'],
					   		"id_type"=> $_POST['idType'],
					   		"address"=> $_POST['newAddress'],
					   		"city"=> $_POST['newCity'],
					   		"phone1"=> $_POST['newPhone1'],
					   		"phone2"=> $_POST['newPhone2'],
					   		"email"=> $_POST['newEmail'],
					   		"photo"=> $ruta); 
			   $answer = ModeloProveedores::mdlActualizarProveedor($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El provider ha sido actualizado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "proveedores";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los datos del proveedor no pueden ir vacíos o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "proveedores";
								}
							});
			 	</script>';
			 }
		}

	}
	/*======================================
	=            Borrar usuario            =
	======================================*/
	static public function ctrBorrarProveedor(){
		if (isset($_GET['idProveedor'])) {
			if ($_GET['fotoProveedor'] != "") {
				unlink($_GET["fotoProveedor"]);
				rmdir('Views/img/proveedores/'.$_GET['proveedor']);
			}
		$table = 'providers';
		$item = 'id';
		$value = $_GET['idProveedor'];
		$answer = ModeloProveedores::mdlBorrarProveedor($table, $item, $value);
		if ($answer == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡El proveedor ha sido borrado con exito!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "proveedores";
								}
							});
			 	</script>';
		}
		}
	}
	
}
