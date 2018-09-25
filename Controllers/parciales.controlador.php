<?php 
class ControladorParciales{

	static public function selectPartial($route){
		switch ($route) {
        case 'inicio':
          include "Partials/home.php";
          break;
        case '/':
          include "Partials/home.php";
          break;
        case 'usuario-salir':
          include "Partials/user_logout.php";
          break;
        case 'reportes':
        if ($_SESSION['rank']=='Admin') {
          include "Partials/general_reports.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'informes-productos':
        if ($_SESSION['rank']=='Admin') {
          include "Partials/product_reports.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'informes-clientes':
        if ($_SESSION['rank']=='Admin') {
          include "Partials/client_reports.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'usuarios':
        if ($_SESSION['rank']=='Admin') {
          include "Partials/user_list.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'categorias':
        if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Vendedor') {
          include "Partials/categories.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'productos':
        if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Vendedor') {
          include "Partials/products.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'clientes':
          include "Partials/clients.php";
          break;
        case 'ventas-administrar':
          include "Partials/sales_admin.php";
          break;
        case 'ventas-crear':
        if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Vendedor') {
          include "Partials/sales_create.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'ventas-editar':
        if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Vendedor') {
          include "Partials/sales_edit.php";
        }else{
          include "Partials/not_found.php";
        }
          break;
        case 'proveedores':
        if ($_SESSION['rank']=='Admin') {
          include "Partials/providers.php";
        }else{
          include "Partials/not_found.php";
        }
          break;  
        case 'resoluciones':
        if ($_SESSION['rank']=='Admin' || $_SESSION['rank']=='Contador') {
          include "Partials/resolutions.php";
        }else{
          include "Partials/not_found.php";
        }
          break;  
        default:
          include "Partials/not_found.php";
          break;
      }
	}
}