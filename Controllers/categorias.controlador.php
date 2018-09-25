<?php 

/**
 * 
 */
class ControladorCategorias
{
	
	/*===================================
	=            USER CREATE            =
	===================================*/
	
	static public function ctrCrearCategoria(){

		if (isset($_POST['newCategorie'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])){
			   $tabla = "categories";
			   $datos = $_POST['newName'];
			   $answer = ModeloCategorias::mdlIngresarCategoria($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡La categoría ha sido guardada correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "categorias";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡La categoría no puede ir vacía o llevar caracteres especiales!",
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
	static public function ctrMostrarCategorias($item,$value){
		$table = "categories";
		$answer = ModeloCategorias::mdlMostrarCategorias($table, $value, $item);

		return $answer;
	}
	/*===================================
	=           EDITAR CATEGORIA          =
	===================================*/
	
	static public function ctrEditarCategoria(){

		if (isset($_POST['editCategorie'])) {
			if (preg_match('/^[a-zA-Z0-9ñÑáéíóúÁÉÍÓÚ ]+$/', $_POST["newName"])) {
			   	
			   	$tabla = "categories";
			   	
			   $datos = array("name"=> $_POST['newName'],
					   		"id"=> $_POST['id'],); 
			   $answer = ModeloCategorias::mdlActualizarCategoria($tabla,$datos);
			   if ($answer == "ok") {
			   	echo '<script>
						swal({
						type: "success",
						title: "¡la categoria ha sido actualizada correctamente!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "categorias";
								}
							});
			   	</script>';
			   }
			 } else {
			 	echo'<script>
					swal({
						type: "error",
						title: "¡El nombre de la categoría no puede ir vacío o llevar caracteres especiales!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "categorias";
								}
							});
			 	</script>';
			 }
		}

	}
	/*======================================
	=            Borrar usuario            =
	======================================*/
	static public function ctrBorrarCategoria(){
		if (isset($_GET['idCategoria'])) {
		$table = 'categories';
		$item = 'id';
		$value = $_GET['idCategoria'];
		$answer = ModeloCategorias::mdlBorrarCategoria($table, $item, $value);
		if ($answer == "ok") {
			echo'<script>
					swal({
						type: "success",
						title: "¡La categoría ha sido borrada con exito!",
						showConfirmButton: true,
						confirmButtonText: "Cerrar",
						closeOnConfirm: false
						}).then((result)=>{
								if(result.value){
									window.location = "categorias";
								}
							});
			 	</script>';
		}
		}
	}
	
}
