<?php 

require_once "conexion.php";

/**
 * 
 */
class ModeloVentas
{
	
	static public function mdlMostrarVentas($tabla,$valor,$item)
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
	static public function mdlIngresarVenta($tabla,$datos){
		$sql = "INSERT INTO $tabla(bill_number, client_id, vendor_id, pay_type, products, discount, tax, value, total) VALUES (:bill_number, :client_id, :vendor_id, :pay_type, :products, :discount, :tax, :value, :total)";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'bill_number' => $datos['bill_number'],
			'client_id' => $datos['client_id'],
			'vendor_id' => $datos['vendor_id'],
			'pay_type' => $datos['pay_type'],
			'products' => $datos['products'],
			'discount' => $datos['discount'],
			'tax' => $datos['tax'],
			'value' => $datos['value'],
			'total' => $datos['total']
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
	static public function mdlBorrarVenta($table, $item, $value){
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
	=            Actualizacion de venta            =
	===========================================*/
	static public function mdlActualizarVenta($tabla,$datos){
		$sql = "UPDATE $tabla SET pay_type =:pay_type, products =:products, discount =:discount, tax =:tax, value =:value, total =:total WHERE bill_number =:bill_number";
		$pdo= Conexion::conectar()->prepare($sql);
		if ($pdo->execute([
			'pay_type' => $datos['pay_type'],
			'products' => $datos['products'],
			'discount' => $datos['discount'],
			'tax' => $datos['tax'],
			'value' => $datos['value'],
			'total' => $datos['total'],
			'bill_number' => $datos['bill_number']
		])) {
			return "ok";
		} else {
			return "error";
		}
		


		$pdo -> close();
		$pdo = null;
	}
	/*===========================================
	=            Rango de Fechas            =
	===========================================*/
	static public function mdlRangoVentas($tabla,$fechaInicial,$fechaFinal){
		if($fechaInicial == null){
			$sql = "SELECT * FROM $tabla";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute();

			return $pdo -> fetchAll();
			
		}else if($fechaInicial == $fechaFinal){
			$sql = "SELECT * FROM $tabla WHERE updated_at like '%$fechaFinal%'";
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
			$sql = "SELECT * FROM $tabla WHERE updated_at BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'";
			$pdo= Conexion::conectar()->prepare($sql);
			$pdo->execute();

			return $pdo -> fetchAll();
		}
		

		$pdo -> close();
		$pdo = null;
		}
	/*===========================================
	=            Sumar Ventas           =
	===========================================*/
	static public function mdlSumaVentas($tabla){
		$sql = "SELECT SUM(value) as total FROM $tabla";
		$pdo= Conexion::conectar()->prepare($sql);
		$pdo->execute();

		return $pdo -> fetch();
		$pdo -> close();
		$pdo = null;
		}
	/*===========================================
	=            Rango de Fechas            =
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
			$sql = "SELECT * FROM $tabla WHERE $item =:item AND updated_at like '%$fechaFinal%'";
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
			$sql = "SELECT * FROM $tabla WHERE $item =:item AND updated_at BETWEEN '$fechaInicial' AND '$fechaFinalMasUno'";
			$pdo->execute([
				'item' => $valor
			]);

			return $pdo -> fetchAll();
		}
		

		$pdo -> close();
		$pdo = null;
		}
}
