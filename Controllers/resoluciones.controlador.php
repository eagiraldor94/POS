<?php 

/**
 * 
 */
class ControladorResoluciones
{
	
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearResolucion(){

		if (isset($_POST['newRes'])) {
			if ( preg_match('/^[0-9]+$/', $_POST["newResNumber"]) &&
			  preg_match('/^[0-9]+$/', $_POST["newFirstNumber"]) &&
			    preg_match('/^[0-9]+$/', $_POST["newLastNumber"]) &&
			     preg_match('/^[\/0-9 ]+$/', $_POST["newDate"])){
			   $tabla = "resolutions";
			   $datos = array("res_number"=> $_POST['newResNumber'],
					   		"first_number"=> $_POST['newFirstNumber'],
					   		"last_number"=> $_POST['newLastNumber'],
					   		"resDate"=> $_POST['newDate']);
			   $answer = ModeloResoluciones::mdlIngresarResolucion($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡La resolución ha sido guardada correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "resoluciones";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los datos de la resolución no pueden ir vacios o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "resoluciones";
								}
							});
			 	</script>';
			 }
		}

	}
	/*=======================================
	=            Listar Resoluciones            =
	=======================================*/
	static public function ctrMostrarResoluciones($item,$value){
		$table = "resolutions";
		$answer = ModeloResoluciones::mdlMostrarResoluciones($table, $value, $item);

		return $answer;
	}
	/*===================================
	=           EDITAR RESOLUCION          =
	===================================*/
	
	static public function ctrEditarResolucion(){

		if (isset($_POST['editRes'])) {
			if (preg_match('/^[0-9]+$/', $_POST["newResNumber"]) &&
			  preg_match('/^[0-9]+$/', $_POST["newFirstNumber"]) &&
			    preg_match('/^[0-9]+$/', $_POST["newLastNumber"]) &&
			     preg_match('/^[\/0-9 ]+$/', $_POST["newDate"])) {
			   	
			   	$tabla = "resolutions";
			   	
			   $datos = array("res_number"=> $_POST['newResNumber'],
					   		"first_number"=> $_POST['newFirstNumber'],
					   		"last_number"=> $_POST['newLastNumber'],
					   		"resDate"=> $_POST['newDate'],
					   		"id"=> $_POST['id'],); 
			   $answer = ModeloResoluciones::mdlActualizarResolucion($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡la resolución ha sido actualizada correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "resoluciones";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡Los datos de la resolución no pueden ir vacios o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "resoluciones";
								}
							});
			 	</script>';
			 }
		}

	}
	/*======================================
	=            Borrar Resolucion            =
	======================================*/
	static public function ctrBorrarResolucion(){
		if (isset($_GET['idResolucion'])) {
		$table = 'resolutions';
		$item = 'id';
		$value = $_GET['idResolucion'];
		$answer = ModeloResoluciones::mdlBorrarResolucion($table, $item, $value);
		if ($answer == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡La resolución ha sido borrada con exito!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "resoluciones";
								}
							});
			 	</script>';
		}
		}
	}
	
}
