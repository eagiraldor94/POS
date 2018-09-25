<?php 

require_once "conexion.php";

/**
 * 
 */
class ModeloProductos
{
	
	static public function mdlMostrarProductos($tabla,$valor,$item,$orden)
	{	
		if($item != null){
			$sql = "SELECT * FROM $tabla WHERE $item =:item ORDER BY $orden DESC";
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
	=            Registro de producto           =
	===========================================*/
	static public function mdlIngresarProducto($tabla,$datos){
		$sql = "INSERT INTO $tabla (name, code, stock, min_stock, max_stock, categorie_id, photo, buy_price, sell_price) VALUES (:name, :code, :stock, :min_stock, :max_stock, :categorie_id, :photo, :buy_price, :sell_price)";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos['name'],
			'code' => $datos['code'],
			'stock' => $datos['stock'],
			'min_stock' => $datos['min_stock'],
			'max_stock' => $datos['max_stock'],
			'categorie_id' => $datos['categorie_id'],
			'photo' => $datos['photo'],
			'buy_price' => $datos['buy_price'],
			'sell_price' => $datos['sell_price']
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Actualizacion de producto            =
	===========================================*/
	static public function mdlActualizarProducto($tabla,$datos){
		$sql = "UPDATE $tabla SET name =:name, code =:code, stock =:stock, min_stock =:min_stock, max_stock =:max_stock, categorie_id =:categorie_id, photo =:photo, buy_price =:buy_price, sell_price =:sell_price WHERE id =:id";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'name' => $datos['name'],
			'code' => $datos['code'],
			'stock' => $datos['stock'],
			'min_stock' => $datos['min_stock'],
			'max_stock' => $datos['max_stock'],
			'categorie_id' => $datos['categorie_id'],
			'photo' => $datos['photo'],
			'buy_price' => $datos['buy_price'],
			'sell_price' => $datos['sell_price'],
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
	=            Borrar producto            =
	===========================================*/
	static public function mdlBorrarProducto($table, $item, $value){
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
	/*============================================
	=            Operar el inventario            =
	============================================*/
	
	static public function mdlObtenerInventario($table, $item, $value){
		$sql = "SELECT * FROM $table WHERE $item =:item";
		$pdo= Conexion::conectar()->prepare($sql);
		$pdo->execute([
			'item' => $value
		]);

		return $pdo -> fetch();

		$pdo -> close();
		$pdo = null;

	}
	static public function mdlActualizarInventario($table, $item, $value, $stock){
		$sql = "UPDATE $table SET stock =:stock WHERE $item =:item";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'item' => $value,
			'stock' => $stock
		])){
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
	static public function mdlModificarProducto($table,$item1, $value1, $id){
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
	=            Mostrar suma ventas            =
	===========================================*/
	static public function mdlMostrarSumaVentas($tabla){
		$sql = "SELECT SUM(sales) as total FROM $tabla";
		$pdo= Conexion::conectar()->prepare($sql);
		$pdo->execute();

		return $pdo -> fetch();

		$pdo -> close();
		$pdo = null;
	}
}
