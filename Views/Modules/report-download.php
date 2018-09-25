<?php
require_once "../../Controllers/ventas.controlador.php";
require_once "../../Models/ventas.modelo.php";
require_once "../../Controllers/clientes.controlador.php";
require_once "../../Models/clientes.modelo.php";
require_once "../../Controllers/usuarios.controlador.php";
require_once "../../Models/usuarios.modelo.php";
require_once "../../Models/backlog.modelo.php";
$reporte = new ControladorVentas();
$reporte -> ctrDescargarReporte();