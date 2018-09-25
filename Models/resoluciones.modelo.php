<?php 

require_once "conexion.php";

/**
 * 
 */
class ModeloResoluciones
{
	
	static public function mdlMostrarResoluciones($tabla,$valor,$item)
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
	=            Registro de resolucion            =
	===========================================*/
	static public function mdlIngresarResolucion($tabla,$datos){
		$sql = "INSERT INTO $tabla (res_number,first_number,last_number,resDate) VALUES (:res_number,:first_number,:last_number,:resDate)";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'res_number' => $datos['res_number'],
			'first_number' => $datos['first_number'],
			'last_number' => $datos['last_number'],
			'resDate' => $datos['resDate']
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
	static public function mdlActualizarResolucion($tabla,$datos){
		$sql = "UPDATE $tabla SET first_number =:first_number,last_number =:last_number,resDate =:resDate WHERE id =:id";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'first_number' => $datos['first_number'],
			'last_number' => $datos['last_number'],
			'resDate' => $datos['resDate'],
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
	static public function mdlBorrarResolucion($table, $item, $value){
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
