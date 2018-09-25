<?php 
require_once "../Controllers/proveedores.controlador.php";
require_once "../Models/proveedores.modelo.php";
class AjaxProveedores{
/*======================================
=            Editar Proveedor            =
======================================*/
	public $idProveedor;	
	public function ajaxEditarProveedor(){
		$item = "id";
		$value = $this->idProveedor;
		$answer = ControladorProveedores::ctrMostrarProveedores($item,$value);
		echo json_encode($answer);
	} 
	public function ajaxCheckearProveedor(){
		$item = "id_number";
		$value = $this->idProveedor;
		$answer = ControladorProveedores::ctrMostrarProveedores($item,$value);
		echo json_encode($answer);
	} 

}
if (isset($_POST['idProveedor'])) {
		
	$editar = new AjaxProveedores();
	$editar -> idProveedor = $_POST['idProveedor'];
	$editar -> ajaxEditarProveedor();	
}
if (isset($_POST['documentCheck'])) {
		
	$editar = new AjaxProveedores();
	$editar -> idProveedor = $_POST['documentCheck'];
	$editar -> ajaxCheckearProveedor();	
}