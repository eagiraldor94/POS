<?php 

require_once "conexion.php";

/**
 * 
 */
class ModeloClientes
{
	
	static public function mdlMostrarClientes($tabla,$valor,$item)
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
	static public function mdlIngresarCliente($tabla,$datos){
		$sql = "INSERT INTO $tabla(name, id_number, id_type, address, photo, city, phone1, phone2, email, birthday) VALUES (:name, :id_number, :id_type, :address, :photo, :city, :phone1, :phone2, :email, :birthday)";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos['name'],
			'id_number' => $datos['id_number'],
			'id_type' => $datos['id_type'],
			'address' => $datos['address'],
			'photo' => $datos['photo'],
			'city' => $datos['city'],
			'phone1' => $datos['phone1'],
			'phone2' => $datos['phone2'],
			'email' => $datos['email'],
			'birthday' => $datos['birthday']
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
	static public function mdlActualizarCliente($tabla,$datos){
		$sql = "UPDATE $tabla SET name =:name, birthday =:birthday, address =:address, city =:city, phone1 =:phone1, phone2 =:phone2, email =:email, photo =:photo WHERE id_number =:id_number";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos['name'],
			'id_number' => $datos['id_number'],
			'address' => $datos['address'],
			'photo' => $datos['photo'],
			'city' => $datos['city'],
			'phone1' => $datos['phone1'],
			'phone2' => $datos['phone2'],
			'email' => $datos['email'],
			'birthday' => $datos['birthday']
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
	static public function mdlBorrarCliente($table, $item, $value){
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
	/*===========================================
	=            Actualizar items            =
	===========================================*/
	static public function mdlModificarCliente($table,$item1, $value1, $id){
		$sql = "UPDATE $table SET $item1 =:item1 WHERE id =:id";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'item1' => $value1,
			'id' => $id
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
		/*===========================================
	=            Mostrar clientes con orden            =
	===========================================*/
	static public function mdlMostrarClientes2($tabla,$valor,$item,$order)
	{	
		if($item != null){
			$sql = "SELECT * FROM $tabla WHERE $item =:item ORDER BY $order DESC";
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
}
