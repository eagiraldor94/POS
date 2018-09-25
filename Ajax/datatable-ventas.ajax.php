<?php 
require_once "../Controllers/productos.controlador.php";
require_once "../Models/productos.modelo.php";
require_once "../Controllers/categorias.controlador.php";
require_once "../Models/categorias.modelo.php";
class TablaVentas
{
	/*===============================================
	=            Mostrar tabla productos            =
	===============================================*/
	
	public function mostrarTabla()
	{	
	$item = null;
    $valor = null;
    $orden = 'id';

  	$productos = ControladorProductos::ctrMostrarProductos($item, $valor, $orden);

  	echo '{
			"data": [';

			for($i = 0; $i < count($productos)-1; $i++){

				$item = "id";
    			$valor = $productos[$i]["categorie_id"];

				$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
				/*=============================
				=            Stock            =
				=============================*/
				if ($productos[$i]["stock"] <= $productos[$i]["min_stock"]) {
					$stock = "<button class='btn btn-danger'>".$productos[$i]["stock"]."</button>";
				}elseif ($productos[$i]["stock"] >= $productos[$i]["max_stock"]) {
					$stock = "<button class='btn btn-success'>".$productos[$i]["stock"]."</button>";
				}else{
					$stock = "<button class='btn btn-warning'>".$productos[$i]["stock"]."</button>";
				}
				
				
				if ($productos[$i]['photo'] != null) {
							$imagen ="<img src='".$productos[$i]['photo']."' class='img-thumbnail' width='40px'>";
						}else{
							$imagen ="<img src='Views/img/productos/default-product.jpg' class='img-thumbnail' width='40px'>";
                    	}
                 $buttons ="<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[$i]['id']."'>Agregar</button></div>";
				 echo '[
			      "'.($i+1).'",
			      "'.$imagen.'",
			      "'.$productos[$i]["code"].'",
			      "'.$productos[$i]["name"].'",
			      "'.$stock.'",
			      "'.$buttons.'"
			    ],';

			}

			$item = "id";
			$valor = $productos[count($productos)-1]["categorie_id"];

			$categorias = ControladorCategorias::ctrMostrarCategorias($item, $valor);
				if ($productos[count($productos)-1]["stock"] <= $productos[count($productos)-1]["min_stock"]) {
					$stock = "<button class='btn btn-danger'>".$productos[count($productos)-1]["stock"]."</button>";
				}elseif ($productos[count($productos)-1]["stock"] >= $productos[count($productos)-1]["max_stock"]) {
					$stock = "<button class='btn btn-success'>".$productos[count($productos)-1]["stock"]."</button>";
				}else{
					$stock = "<button class='btn btn-warning'>".$productos[count($productos)-1]["stock"]."</button>";
				}
			if ($productos[count($productos)-1]['photo'] != null) {
							$imagen ="<img src='".$productos[count($productos)-1]['photo']."' class='img-thumbnail' width='40px'>";
						}else{
							$imagen ="<img src='Views/img/productos/default-product.jpg' class='img-thumbnail' width='40px'>";
                    	}
            $buttons ="<div class='btn-group'><button class='btn btn-primary agregarProducto recuperarBoton' idProducto='".$productos[count($productos)-1]['id']."'>Agregar</button></div>";

		   echo'[
			      "'.(count($productos)).'",
			      "'.$imagen.'",
			      "'.$productos[count($productos)-1]["code"].'",
			      "'.$productos[count($productos)-1]["name"].'",
			      "'.$stock.'",
			      "'.$buttons.'"
			    ]
			]
		}';
	}
}
/*==================================================
=            Activar tabla de productos            =
==================================================*/
$activar = new TablaVentas();
$activar ->mostrarTabla();

