<?php 

/**
 * 
 */
class ControladorClientes
{
	/*===================================
	=            CLIENT CREATE            =
	===================================*/
	
	static public function ctrCrearCliente(){

		if (isset($_POST['newClient'])) {
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
			   		$directorio = "Views/img/clientes/".$_POST['newDocument'];
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
			   	
			   	$tabla = "clients";
			   $datos = array("name"=> $_POST['newName'],
					   		"id_number"=> $_POST['newDocument'],
					   		"id_type"=> $_POST['idType'],
					   		"address"=> $_POST['newAddress'],
					   		"city"=> $_POST['newCity'],
					   		"phone1"=> $_POST['newPhone1'],
					   		"phone2"=> $_POST['newPhone2'],
					   		"email"=> $_POST['newEmail'],
					   		"birthday"=> $_POST['newBirthday'],
					   		"photo"=> $ruta); 
			   $answer = ModeloClientes::mdlIngresarCliente($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El cliente ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "clientes";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los datos del cliente no pueden ir vacíos o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "clientes";
								}
							});
			 	</script>';
			 }
		}

	}
	/*=======================================
	=            Listar Usuarios            =
	=======================================*/
	static public function ctrMostrarClientes($item,$value){
		$table = "clients";
		
		$answer = ModeloClientes::mdlMostrarClientes($table,$value,$item);

		return $answer;
	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarCliente(){

		if (isset($_POST['editClient'])) {
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
			   		$directorio = "Views/img/clientes/".$_POST['newDocument'];
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
			   	
			   	$tabla = "clients";
			   	
			   $datos = array("name"=> $_POST['newName'],
					   		"id_number"=> $_POST['newDocument'],
					   		"id_type"=> $_POST['idType'],
					   		"address"=> $_POST['newAddress'],
					   		"city"=> $_POST['newCity'],
					   		"phone1"=> $_POST['newPhone1'],
					   		"phone2"=> $_POST['newPhone2'],
					   		"email"=> $_POST['newEmail'],
					   		"birthday"=> $_POST['newBirthday'],
					   		"photo"=> $ruta); 
			   $answer = ModeloClientes::mdlActualizarCliente($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El cliente ha sido actualizado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "clientes";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los datos del cliente no pueden ir vacíos o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "clientes";
								}
							});
			 	</script>';
			 }
		}

	}
	/*======================================
	=            Borrar usuario            =
	======================================*/
	static public function ctrBorrarCliente(){
		if (isset($_GET['idCliente'])) {
			if ($_GET['fotoCliente'] != "") {
				unlink($_GET["fotoCliente"]);
				rmdir('Views/img/clientes/'.$_GET['cliente']);
			}
		$table = 'clients';
		$item = 'id';
		$value = $_GET['idCliente'];
		$answer = ModeloClientes::mdlBorrarCliente($table, $item, $value);
		if ($answer == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡El cliente ha sido borrado con exito!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "clientes";
								}
							});
			 	</script>';
		}
		}
	}
	
}
