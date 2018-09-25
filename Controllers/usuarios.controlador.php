<?php 

/**
 * 
 */
class ControladorUsuarios
{
	/*=============================================
	=                    LOGIN               =
	=============================================*/
	
	
	static public function ctrIngresoUsuario(){
		
		if (isset($_POST['user']) && isset($_POST['pass'])) {

			if (preg_match('/^[a-zA-Z-0-9]+$/', $_POST['user'])) {
				$table = "users";
				$user = $_POST['user'];
				$item = "username";
				$answer = ModeloUsuarios::mdlMostrarUsuarios($table,$user,$item);
				$password = $_POST["pass"];
				if ($answer['username'] == $user && password_verify($password,$answer['password']) ) {
					if ($answer['state'] == 1) {
						$_SESSION['rank']=$answer['type'];
						$_SESSION['user']=$answer['username'];
						$_SESSION['name']=$answer['name'];
						$_SESSION['id']=$answer['id'];
						$_SESSION['photo']=$answer['photo'];
						/*=============================================
						=                  REGISTRAR LOGIN               =
						=============================================*/
						date_default_timezone_set('America/Bogota');
						$_SESSION['log'] = date("Y-m-d h:i:s");
						$value2=$_SESSION['log'];
						$item2 = 'last_log';
						$value1 = $_SESSION['id'];
						$item1 = 'id';
						$table = 'users';
						$logRegister = ModeloUsuarios::mdlActivarUsuario($table,$item1, $value1, $item2, $value2);
						if ($logRegister) {
							echo ' <script>
						window.location = "inicio"; </script> ';

						}
						
					}else{
					echo '<br><div class="alert alert-warning" style="text-align: center;" >Este usuario se encuentra desactivado, por favor contacte al administrador.</div>';	
					}
					
					}else{
					echo '<br><div class="alert alert-warning" style="text-align: center;" >Las credenciales ingresadas no son correctas.</div>';
				}
			}
		}
	}
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearUsuario(){

		if (isset($_POST['newUser'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"]) &&
			   preg_match('/^[a-zA-Z0-9]+$/', $_POST["newUsername"])) {
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
			   		$directorio = "Views/img/usuarios/".$_POST['newUsername'];
			   		mkdir($directorio,0755);
			   		/*===========================================================================
			   		=            Funciones defecto PHP dependiendo de tipo de imagen            =
			   		===========================================================================*/
			   		switch ($_FILES['photo']['type']) {
			   			case 'image/jpeg':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.png';
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
			   	
			   	$tabla = "users";
			   $datos = array("name"=> $_POST['newName'],
					   		"username"=> $_POST['newUsername'],
					   		"password"=> password_hash($_POST["newPassword"], PASSWORD_DEFAULT),
					   		"type"=> $_POST['rol'],
					   		"photo"=> $ruta); 
			   $answer = ModeloUsuarios::mdlIngresarUsuario($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El usuario ha sido guardado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡El usuario no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
			 	</script>';
			 }
		}

	}
	/*=======================================
	=            Listar Usuarios            =
	=======================================*/
	static public function ctrMostrarUsuarios($item,$value){
		$table = "users";
		
		$answer = ModeloUsuarios::mdlMostrarUsuarios($table,$value,$item);

		return $answer;
	}
	/*===================================
	=            USER EDIT            =
	===================================*/
	
	static public function ctrEditarUsuario(){

		if (isset($_POST['editUser'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
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
			   		$directorio = "Views/img/usuarios/".$_POST['newUsername'];
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
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.jpg';
			   				$origen = imagecreatefromjpeg($_FILES['photo']['tmp_name']);
			   				$destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
			   				imagecopyresized($destino, $origen, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);
			   				imagejpeg($destino,$ruta);
			   				break;
			   			case 'image/png':
			   				$preruta = date('Y-m-d_his');
			   				$preruta = (string)$preruta;
			   				$ruta = $directorio.'/'.$_POST['newUsername'].'_'.$preruta.'.png';
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
			   	
			   	$tabla = "users";
			   	if ($_POST['newPassword'] != "") {
			   		$password = password_hash($_POST["newPassword"], PASSWORD_DEFAULT);
			   	}else{
			   		$password=$_POST['password'];
			   	}
			   $datos = array("name"=> $_POST['newName'],
					   		"username"=> $_POST['newUsername'],
					   		"password"=> $password,
					   		"type"=> $_POST['rol'],
					   		"photo"=> $ruta); 
			   $answer = ModeloUsuarios::mdlActualizarUsuario($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡El usuario ha sido actualizado correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡El nombre no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
			 	</script>';
			 }
		}

	}
	/*======================================
	=            Borrar usuario            =
	======================================*/
	static public function ctrBorrarUsuario(){
		if (isset($_GET['idUsuario'])) {
			if ($_GET['fotoUsuario'] != "") {
				unlink($_GET["fotoUsuario"]);
				rmdir('Views/img/usuarios/'.$_GET['usuario']);
			}
		$table = 'users';
		$item = 'id';
		$value = $_GET['idUsuario'];
		$answer = ModeloUsuarios::mdlBorrarUsuario($table, $item, $value);
		if ($answer == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡El usuario ha sido borrado con exito!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "usuarios";
								}
							});
			 	</script>';
		}
		}
	}
	
}
