<?php 

require_once "conexion.php";

/**
 * 
 */
class ModeloBacklog
{
	
	static public function mdlMostrarRegistros($tabla,$valor,$item)
	{	
		if($item != null){
			$sql = "SELECT * FROM $tabla WHERE $item =:item ORDER BY id DESC";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute([
				'item' => $valor
			]);

			return $pdo -> fetchAll();
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
	static public function mdlIngresarRegistro($tabla,$datos){
		$sql = "INSERT INTO $tabla (product_id, client_id, quantity, sale_id, price) VALUES (:product_id, :client_id, :quantity, :sale_id, :price)";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'product_id' => $datos['product_id'],
			'client_id' => $datos['client_id'],
			'quantity' => $datos['quantity'],
			'sale_id' => $datos['sale_id'],
			'price' => $datos['price']
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Actualizacion de registro            =
	===========================================*/
	static public function mdlActualizarProducto($tabla,$datos){
		$sql = "UPDATE $tabla SET product_id =:product_id, client_id =:client_id, quantity =:quantity, price =:price WHERE sale_id =:sale_id";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'product_id' => $datos['product_id'],
			'client_id' => $datos['client_id'],
			'quantity' => $datos['quantity'],
			'sale_id' => $datos['sale_id'],
			'price' => $datos['price']
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Borrar registros            =
	===========================================*/
	static public function mdlBorrarRegistro($table, $item, $value){
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
	static public function mdlModificarRegistro($table,$item1, $value1, $saleId){
		$sql = "UPDATE $table SET $item1 =:item1 WHERE sale_id =:sale_id";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'item1' => $value1,
			'sale_id' => $saleId
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
		/*===========================================
	=            RANGO VENTAS            =
	===========================================*/
	static public function mdlRangoVentas($tabla,$fechaInicial,$fechaFinal){
		if($fechaInicial == null){
			$sql = "SELECT * FROM $tabla";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute();

			return $pdo -> fetchAll();
			
		}else if($fechaInicial == $fechaFinal){
			$sql = "SELECT * FROM $tabla WHERE sell_date like '%$fechaFinal%'";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute();

			return $pdo -> fetchAll();
		}else{
			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual ->format("Y-m-d");
			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2 ->format("Y-m-d");
			$sql = "SELECT * FROM $tabla WHERE sell_date BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute();

			return $pdo -> fetchAll();
		}
		

		$pdo -> close();
		$pdo = null;
		}
/*===========================================
	=            RANGO VENTAS 2.0            =
	===========================================*/
	static public function mdlRangoVentas2($tabla,$fechaInicial,$fechaFinal,$item,$valor){
		if($fechaInicial == null){
			$sql = "SELECT * FROM $tabla WHERE $item =:item ORDER BY id DESC";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute([
				'item' => $valor
			]);

			return $pdo -> fetchAll();
			
		}else if($fechaInicial == $fechaFinal){
			$sql = "SELECT * FROM $tabla WHERE $item =:item AND sell_date like '%$fechaFinal%'";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute([
				'item' => $valor
			]);

			return $pdo -> fetchAll();
		}else{
			$fechaActual = new DateTime();
			$fechaActual ->add(new DateInterval("P1D"));
			$fechaActualMasUno = $fechaActual ->format("Y-m-d");
			$fechaFinal2 = new DateTime($fechaFinal);
			$fechaFinal2 ->add(new DateInterval("P1D"));
			$fechaFinalMasUno = $fechaFinal2 ->format("Y-m-d");
			$sql = "SELECT * FROM $tabla WHERE $item =:item AND sell_date BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute([
				'item' => $valor
			]);

			return $pdo -> fetchAll();
		}
		

		$pdo -> close();
		$pdo = null;
		}
}
