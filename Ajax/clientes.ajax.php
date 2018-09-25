<?php 
require_once "../Controllers/clientes.controlador.php";
require_once "../Models/clientes.modelo.php";
class AjaxClientes{
/*======================================
=            Editar Cliente            =
======================================*/
	public $idCliente;	public function ajaxEditarCliente(){
		$item = "id";
		$value = $this->idCliente;
		$answer = ControladorClientes::ctrMostrarClientes($item,$value);
		echo json_encode($answer);
	} 
	public function ajaxCheckearCliente(){
		$item = "id_number";
		$value = $this->idCliente;
		$answer = ControladorClientes::ctrMostrarClientes($item,$value);
		echo json_encode($answer);
	} 

}
if (isset($_POST['idCliente'])) {
		
	$editar = new AjaxClientes();
	$editar -> idCliente = $_POST['idCliente'];
	$editar -> ajaxEditarCliente();	
}
if (isset($_POST['documentCheck'])) {
		
	$editar = new AjaxClientes();
	$editar -> idCliente = $_POST['documentCheck'];
	$editar -> ajaxCheckearCliente();	
}