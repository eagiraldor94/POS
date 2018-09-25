<?php 
require_once "../Controllers/resoluciones.controlador.php";
require_once "../Models/resoluciones.modelo.php";
class AjaxResoluciones{
/*======================================
=            Editar Resolucion            =
======================================*/
	public $idResolucion;
	public function ajaxEditarResolucion(){
		$item = "id";
		$value = $this->idResolucion;
		$answer = ControladorResoluciones::ctrMostrarResoluciones($item,$value);
		echo json_encode($answer);
	} 
	public function ajaxCheckearResolucion(){
		$item = "res_number";
		$value = $this->idResolucion;
		$answer = ControladorResoluciones::ctrMostrarResoluciones($item,$value);
		echo json_encode($answer);
	} 

}
if (isset($_POST['idResolucion'])) {
		
	$editar = new AjaxResoluciones();
	$editar -> idResolucion = $_POST['idResolucion'];
	$editar -> ajaxEditarResolucion();	
}
if (isset($_POST['resolutionCheck'])) {
		
	$editar = new AjaxResoluciones();
	$editar -> idResolucion = $_POST['resolutionCheck'];
	$editar -> ajaxCheckearResolucion();	
}