<?php 
require_once "../Controllers/categorias.controlador.php";
require_once "../Models/categorias.modelo.php";
class AjaxCategorias{
/*======================================
=            Editar Categoria            =
======================================*/
	public $idCategoria;
	public function ajaxEditarCategoria(){
		$item = "id";
		$value = $this->idCategoria;
		$answer = ControladorCategorias::ctrMostrarCategorias($item,$value);
		echo json_encode($answer);
	} 
	public function ajaxCheckearCategoria(){
		$item = "name";
		$value = $this->idCategoria;
		$answer = ControladorCategorias::ctrMostrarCategorias($item,$value);
		echo json_encode($answer);
	} 

}
if (isset($_POST['idCategoria'])) {
		
	$editar = new AjaxCategorias();
	$editar -> idCategoria = $_POST['idCategoria'];
	$editar -> ajaxEditarCategoria();	
}
if (isset($_POST['categorieCheck'])) {
		
	$editar = new AjaxCategorias();
	$editar -> idCategoria = $_POST['categorieCheck'];
	$editar -> ajaxCheckearCategoria();	
}