<?php 
require_once "../Controllers/productos.controlador.php";
require_once "../Models/productos.modelo.php";
require_once "../Controllers/categorias.controlador.php";
require_once "../Models/categorias.modelo.php";

class AjaxProductos{
/*======================================
=            Editar Usuario            =
======================================*/
	public $idProducto;
	public $listarProductos;
	public $nombreProducto;
	public function ajaxEditarProducto(){
		if ($this->listarProductos == "ok") {
			$item = null;
			$value = null;
			$orden = 'id';
			$answer = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
			echo json_encode($answer);
		}else if ($this->nombreProducto != "") {
			$item = "name";
			$value = $this->nombreProducto;
			$orden = 'id';
			$answer = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
			echo json_encode($answer);
		}else{
			$item = "id";
			$value = $this->idProducto;
			$orden = 'id';
			$answer = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
			echo json_encode($answer);
		}	
	} 
	public function ajaxCheckearProducto(){
		$item = "name";
		$value = $this->idProducto;
		$orden = 'id';
		$answer = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
		echo json_encode($answer);
	} 
	
	public function ajaxCrearCodigoProducto(){
		$item = "categorie_id";
		$value = $this->idProducto;
		$orden = 'id';
		$answer = ControladorProductos::ctrMostrarProductos($item,$value,$orden);
		echo json_encode($answer);
	}
	

}
if (isset($_POST['idProducto'])) {
		
	$editar = new AjaxProductos();
	$editar -> idProducto = $_POST['idProducto'];
	$editar -> ajaxEditarProducto();	
}

if (isset($_POST['nameCheck'])) {
		
	$editar = new AjaxProductos();
	$editar -> idProducto = $_POST['nameCheck'];
	$editar -> ajaxCheckearProducto();	
}
if (isset($_POST['idCategoria'])) {
		
	$editar = new AjaxProductos();
	$editar -> idProducto = $_POST['idCategoria'];
	$editar -> ajaxCrearCodigoProducto();	
}
if (isset($_POST['listarProductos'])) {
	
	$editar = new AjaxProductos();
	$editar -> listarProductos = $_POST['listarProductos'];
	$editar -> ajaxEditarProducto();	
}
if (isset($_POST['nombreProducto'])) {
	
	$editar = new AjaxProductos();
	$editar -> nombreProducto = $_POST['nombreProducto'];
	$editar -> ajaxEditarProducto();	
}

/**
 * 
 */
