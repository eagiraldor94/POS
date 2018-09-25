<?php 
require_once "../Controllers/usuarios.controlador.php";
require_once "../Models/usuarios.modelo.php";
class AjaxUsuarios{
/*======================================
=            Editar Usuario            =
======================================*/
	public $idUsuario;
	public $estadoUsuario;
	public function ajaxEditarUsuario(){
		$item = "id";
		$value = $this->idUsuario;
		$answer = ControladorUsuarios::ctrMostrarUsuarios($item,$value);
		echo json_encode($answer);
	} 
	public function ajaxActivarUsuario(){
		$item1 = "id";
		$value1 = $this->idUsuario;
		$item2 = "state";
		$value2 = $this->estadoUsuario;
		$table = "users";
		$answer = ModeloUsuarios::mdlActivarUsuario($table,$item1, $value1, $item2, $value2);
	} 
	public function ajaxCheckearUsuario(){
		$item = "username";
		$value = $this->idUsuario;
		$answer = ControladorUsuarios::ctrMostrarUsuarios($item,$value);
		echo json_encode($answer);
	} 

}
if (isset($_POST['idUsuario'])) {
		
	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST['idUsuario'];
	$editar -> ajaxEditarUsuario();	
}
if (isset($_POST['activarUsuario'])) {
	$activar = new AjaxUsuarios();
	$activar -> idUsuario = $_POST['activarUsuario'];
	$activar -> estadoUsuario = $_POST['estadoUsuario'];
	$activar -> ajaxActivarUsuario();

}
if (isset($_POST['userCheck'])) {
		
	$editar = new AjaxUsuarios();
	$editar -> idUsuario = $_POST['userCheck'];
	$editar -> ajaxCheckearUsuario();	
}