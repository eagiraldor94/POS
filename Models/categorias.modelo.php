<?php 

require_once "conexion.php";

/**
 * 
 */
class ModeloCategorias
{
	
	static public function mdlMostrarCategorias($tabla,$valor,$item)
	{	
		if($item != null){
			$sql = "SELECT * FROM $tabla WHERE $item =:item";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute([
				'item' => $valor
			]);

			return $pdo -> fetch();
		}else{
			$sql = "SELECT * FROM $tabla";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute();

			return $pdo -> fetchAll();
		}
		

		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Registro de categoria            =
	===========================================*/
	static public function mdlIngresarCategoria($tabla,$datos){
		$sql = "INSERT INTO $tabla (name) VALUES (:name)";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Actualizacion de categoria            =
	===========================================*/
	static public function mdlActualizarCategoria($tabla,$datos){
		$sql = "UPDATE $tabla SET name =:name WHERE id =:id";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos['name'],
			'id' => $datos['id']
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Borrar usuario            =
	===========================================*/
	static public function mdlBorrarCategoria($table, $item, $value){
		$sql = "DELETE FROM $table WHERE $item =:item";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'item' => $value
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	
}
