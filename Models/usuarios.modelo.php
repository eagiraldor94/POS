<?php 

require_once "conexion.php";

/**
 * 
 */
class ModeloUsuarios
{
	
	static public function mdlMostrarUsuarios($tabla,$valor,$item)
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
	=            Registro de usuario            =
	===========================================*/
	static public function mdlIngresarUsuario($tabla,$datos){
		$sql = "INSERT INTO $tabla(name, username, password, type, photo) VALUES (:name, :username, :password, :type, :photo)";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos['name'],
			'username' => $datos['username'],
			'password' => $datos['password'],
			'type' => $datos['type'],
			'photo' => $datos['photo']
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Actualizacion de usuario            =
	===========================================*/
	static public function mdlActualizarUsuario($tabla,$datos){
		$sql = "UPDATE $tabla SET name =:name, password =:password, type =:type, photo =:photo WHERE username =:username";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos['name'],
			'username' => $datos['username'],
			'password' => $datos['password'],
			'type' => $datos['type'],
			'photo' => $datos['photo']
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Activar usuario            =
	===========================================*/
	static public function mdlActivarUsuario($table,$item1, $value1, $item2, $value2){
		$sql = "UPDATE $table SET $item2 =:item2 WHERE $item1 =:item1";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'item1' => $value1,
			'item2' => $value2
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
	static public function mdlBorrarUsuario($table, $item, $value){
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
