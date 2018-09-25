<?php

require_once "../../../Controllers/ventas.controlador.php";
require_once "../../../Models/ventas.modelo.php";

require_once "../../../Controllers/clientes.controlador.php";
require_once "../../../Models/clientes.modelo.php";

require_once "../../../Controllers/usuarios.controlador.php";
require_once "../../../Models/usuarios.modelo.php";

require_once "../../../Controllers/productos.controlador.php";
require_once "../../../Models/productos.modelo.php";
require_once "../../../Controllers/resoluciones.controlador.php";
require_once "../../../Models/resoluciones.modelo.php";
//REQUERIMOS LA CLASE TCPDF

require_once('tcpdf_include.php');

// Extend the TCPDF class to create custom Header and Footer
class MYPDF extends TCPDF {

    // Page footer
    public function Footer() {
        // Position at 15 mm from bottom
        $this->SetY(-15);
        // Set font
        $this->SetFont('helvetica', 'I', 8);
        // Page number
        $this->Cell(0, 10, 'Pagina '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'C', 0, '', 0, false, 'T', 'M');
    }
}

class NumeroALetras
{
    private static $UNIDADES = [
        '',
        'UN ',
        'DOS ',
        'TRES ',
        'CUATRO ',
        'CINCO ',
        'SEIS ',
        'SIETE ',
        'OCHO ',
        'NUEVE ',
        'DIEZ ',
        'ONCE ',
        'DOCE ',
        'TRECE ',
        'CATORCE ',
        'QUINCE ',
        'DIECISEIS ',
        'DIECISIETE ',
        'DIECIOCHO ',
        'DIECINUEVE ',
        'VEINTE '
    ];
    private static $DECENAS = [
        'VENTI',
        'TREINTA ',
        'CUARENTA ',
        'CINCUENTA ',
        'SESENTA ',
        'SETENTA ',
        'OCHENTA ',
        'NOVENTA ',
        'CIEN '
    ];
    private static $CENTENAS = [
        'CIENTO ',
        'DOSCIENTOS ',
        'TRESCIENTOS ',
        'CUATROCIENTOS ',
        'QUINIENTOS ',
        'SEISCIENTOS ',
        'SETECIENTOS ',
        'OCHOCIENTOS ',
        'NOVECIENTOS '
    ];
    public static function convertir($number, $moneda = '', $centimos = '', $forzarCentimos = false)
    {
        $converted = '';
        $decimales = '';
        if (($number < 0) || ($number > 999999999)) {
            return 'No es posible convertir el numero a letras';
        }
        $div_decimales = explode('.',$number);
        if(count($div_decimales) > 1){
            $number = $div_decimales[0];
            $decNumberStr = (string) $div_decimales[1];
            if(strlen($decNumberStr) == 2){
                $decNumberStrFill = str_pad($decNumberStr, 9, '0', STR_PAD_LEFT);
                $decCientos = substr($decNumberStrFill, 6);
                $decimales = self::convertGroup($decCientos);
            }
        }
        else if (count($div_decimales) == 1 && $forzarCentimos){
            $decimales = 'CERO ';
        }
        $numberStr = (string) $number;
        $numberStrFill = str_pad($numberStr, 9, '0', STR_PAD_LEFT);
        $millones = substr($numberStrFill, 0, 3);
        $miles = substr($numberStrFill, 3, 3);
        $cientos = substr($numberStrFill, 6);
        if (intval($millones) > 0) {
            if ($millones == '001') {
                $converted .= 'UN MILLON ';
            } else if (intval($millones) > 0) {
                $converted .= sprintf('%sMILLONES ', self::convertGroup($millones));
            }
        }
        if (intval($miles) > 0) {
            if ($miles == '001') {
                $converted .= 'MIL ';
            } else if (intval($miles) > 0) {
                $converted .= sprintf('%sMIL ', self::convertGroup($miles));
            }
        }
        if (intval($cientos) > 0) {
            if ($cientos == '001') {
                $converted .= 'UN ';
            } else if (intval($cientos) > 0) {
                $converted .= sprintf('%s ', self::convertGroup($cientos));
            }
        }
        if(empty($decimales)){
            $valor_convertido = $converted . strtoupper($moneda);
        } else {
            $valor_convertido = $converted . strtoupper($moneda) . ' CON ' . $decimales . ' ' . strtoupper($centimos);
        }
        return $valor_convertido;
    }
    private static function convertGroup($n)
    {
        $output = '';
        if ($n == '100') {
            $output = "CIEN ";
        } else if ($n[0] !== '0') {
            $output = self::$CENTENAS[$n[0] - 1];
        }
        $k = intval(substr($n,1));
        if ($k <= 20) {
            $output .= self::$UNIDADES[$k];
        } else {
            if(($k > 30) && ($n[2] !== '0')) {
                $output .= sprintf('%sY %s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            } else {
                $output .= sprintf('%s%s', self::$DECENAS[intval($n[1]) - 2], self::$UNIDADES[intval($n[2])]);
            }
        }
        return $output;
    }
}
class imprimirFactura{

public $codigo;

public function traerImpresionFactura(){

//TRAEMOS LA INFORMACIÓN DE LA VENTA

$itemVenta = "id";
$valorVenta = $this->codigo;
$dummy = number_format(0,2);
$respuestaVenta = ControladorVentas::ctrMostrarVentas($itemVenta, $valorVenta);
$totalLetras = NumeroALetras::convertir($respuestaVenta['total'], 'pesos colombianos', 'centavos');
$totalLetras .=' (COP).';
$itemRes = null;
$valorRes = null;
$valorVenta = $respuestaVenta['bill_number'];
$respuestaRes = ControladorResoluciones::ctrMostrarResoluciones($itemRes, $valorRes);
foreach ($respuestaRes as $key => $res) {
	if ($valorVenta >= $res['first_number'] && $valorVenta <= $res['last_number']) {
		$numeroRes = $res['res_number'];
		$minRes = $res['first_number'];
		$maxRes = $res['last_number'];
		$fechaRes = $res['resDate'];
	}
}

$fecha = substr($respuestaVenta["updated_at"],0,-8);
$fechaVto = $respuestaVenta['expires_at'];
$productos = json_decode($respuestaVenta["products"], true);
$neto = number_format($respuestaVenta["value"],2);
$impuesto = number_format($respuestaVenta["tax"],2);
$total = number_format($respuestaVenta["total"],2);
$descuento = $respuestaVenta['discount'];
$subTotal = number_format(($respuestaVenta['value']*(100/(100-$descuento))),2);

//TRAEMOS LA INFORMACIÓN DEL CLIENTE

$itemCliente = "id";
$valorCliente = $respuestaVenta["client_id"];

$respuestaCliente = ControladorClientes::ctrMostrarClientes($itemCliente, $valorCliente);

//TRAEMOS LA INFORMACIÓN DEL VENDEDOR

$itemVendedor = "id";
$valorVendedor = $respuestaVenta["vendor_id"];

$respuestaVendedor = ControladorUsuarios::ctrMostrarUsuarios($itemVendedor, $valorVendedor);
$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

// set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);
$pdf->startPageGroup();

$pdf->AddPage();

// ---------------------------------------------------------

$bloque1 = <<<EOF

	<table>
		<tr>
			
			<td style="width:540px; border-top: 2px solid #666"></td>
		
		</tr>
		<tr>
			<td>
				<h1 style="width:540px; text-align:center; background-color:white"><b>Solufert S.A.S</b></h1>
			</td>
		</tr>
	</table>
	<table>
		<tr>
			<td style="width:20px; background-color:white"></td>
			<td style="width:50px; background-color:white"><img src="images/logo_solufert.jpg"></td>
			<td style="width:5px; background-color:white"></td>
			

			<td style="background-color:white; width:195px">
				
				<div style="font-size:12px; text-align:center; line-height:15px">
					
					<br>
					<b>NIT:</b> 71.759.963-9

					<br>
					<b>Régimen Común</b>

				</div>

			</td>

			<td style="background-color:white; width:195px">

				<div style="font-size:12px; text-align:center; line-height:15px">
					
					<br>
					<b>Teléfono:</b> 300 786 52 49
					
					<br>
					<b>ventas@esforzaitaly.com</b>

				</div>
				
			</td>

			
			<td style="width:5px; background-color:white"></td>
			<td style="width:50px; background-color:white"><img src="images/logo_esforza.png"></td>
			<td style="width:20px; background-color:white"></td>
		</tr>
	</table>
	<table>
		<tr>
			<td>
				<h4 style="width:540px; text-align:center"><b>NO SOMOS GRANDES CONTRIBUYENTES NI AUTORETENEDORES</b></h4>
			</td>
		</tr>
	</table>

EOF;

$pdf->writeHTML($bloque1, false, false, false, false, '');

// ---------------------------------------------------------

$bloque2 = <<<EOF

	<table>
		
		<tr>
			
			<td style="width:540px"></td>
		
		</tr>

	</table>

	<table style="font-size:10px; padding:5px 10px;">
	
		<tr>
		
			<td style="border: 1px solid #666; background-color:white; width:80px"><b>Vendedor:</b></td>
			<td style="border: 1px solid #666; background-color:white; width:250px">$respuestaVendedor[name]</td>			
			<td style="border: 1px solid #666; background-color:white; width:210px; text-align:center; color:red"><b>FACTURA DE VENTA N. </b>$valorVenta</td>

			

		</tr>

		<tr>
			<td style="border: 1px solid #666; background-color:white; width:80px">
				<b>Cliente:</b>
			</td>
			<td style="border: 1px solid #666; background-color:white; width:250px">
				$respuestaCliente[name]
			</td>
			<td style="border: 1px solid #666; background-color:white; width:130px; text-align:left">
							<b>Fecha de expedición:</b>
			</td>
			<td style="border: 1px solid #666; background-color:white; width:80px; text-align:left">
				$fecha 
			</td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:80px">
				<b>$respuestaCliente[id_type]:</b>
			</td>
			<td style="border: 1px solid #666; background-color:white; width:250px">
				$respuestaCliente[id_number]
			</td>
			<td style="border: 1px solid #666; background-color:white; width:130px; text-align:left">
				<b>Fecha de vencimiento:</b>
			</td>
			<td style="border: 1px solid #666; background-color:white; width:80px; text-align:left">
				$fechaVto
			</td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:80px">
				<b>Dirección:</b>
			</td>
			<td style="border: 1px solid #666; background-color:white; width:250px">
				$respuestaCliente[address]
			</td>
			<td style="width:130px"></td>
			<td style="width:80px"></td>
		</tr>
		<tr>
			<td style="border: 1px solid #666; background-color:white; width:80px">
				<b>Teléfono:</b>
			</td>
			<td style="border: 1px solid #666; background-color:white; width:250px">
				$respuestaCliente[phone1]
			</td>
			<td style="border: 1px solid #666; background-color:white; width:80px">
				
				<b>Ciudad:</b>
			</td>
			<td style="border: 1px solid #666; background-color:white; width:130px">
				
				$respuestaCliente[city]
			</td>
		</tr>
		<tr>
			<td style="width:540px"></td>
		</tr>
	</table>

EOF;

$pdf->writeHTML($bloque2, false, false, false, false, '');

// ---------------------------------------------------------

$bloque3 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>Codigo</b></td>
		<td style="border: 1px solid #666; background-color:white; width:180px; text-align:center"><b>Producto</b></td>
		<td style="border: 1px solid #666; background-color:white; width:80px; text-align:center"><b>Cantidad</b></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>Valor Unit.</b></td>
		<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center"><b>Valor Total</b></td>

		</tr>

	</table>

EOF;

$pdf->writeHTML($bloque3, false, false, false, false, '');

// ---------------------------------------------------------

foreach ($productos as $key => $item) {

$itemProducto = "name";
$valorProducto = $item["name"];
$orden = 'id';

$respuestaProducto = ControladorProductos::ctrMostrarProductos($itemProducto, $valorProducto,$orden);

$valorUnitario = number_format($respuestaProducto["sell_price"], 2);

$precioTotal = number_format($item["total"], 2);

$bloque4 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$respuestaProducto[code]
			</td>
			<td style="border: 1px solid #666; color:#333; background-color:white; width:180px; text-align:center">
				$item[name]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:80px; text-align:center">
				$item[quantity]
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$valorUnitario
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:center">$ 
				$precioTotal
			</td>


		</tr>

	</table>


EOF;

$pdf->writeHTML($bloque4, false, false, false, false, '');

}

// ---------------------------------------------------------

$bloque5 = <<<EOF

	<table style="font-size:10px; padding:5px 10px;">

		<tr>

			<td style="color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

			<td style="border-bottom: 1px solid #666; background-color:white; width:100px; text-align:center"></td>

		</tr>

		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				<b>Subtotal:</b>
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $subTotal
			</td>

		</tr>
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				<b>Descuento:</b>
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$descuento%
			</td>

		</tr>
		<tr>
		
			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666;  background-color:white; width:100px; text-align:center">
				<b>Neto:</b>
			</td>

			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $neto
			</td>

		</tr>

		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				<b>IVA:</b>
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $impuesto
			</td>

		</tr>
		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				<b>Retefuente:</b>
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $dummy
			</td>

		</tr>
		<tr>

			<td style="border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				<b>ReteIVA:</b>
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $dummy
			</td>

		</tr>
		<tr>

			<td style="border-bottom: 1px solid #666; border-right: 1px solid #666; color:#333; background-color:white; width:340px; text-align:center"></td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				<b>ReteICA:</b>
			</td>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $dummy
			</td>

		</tr>




		<tr>
		
			<td style="border: 1px solid #666; color:#333; background-color:white; width:340px; text-align:left">
				<b>SON: </b> $totalLetras
			</td>

			<td style="border: 1px solid #666; background-color:white; width:100px; text-align:center">
				<b>Total:</b>
			</td>
			
			<td style="border: 1px solid #666; color:#333; background-color:white; width:100px; text-align:right">
				$ $total
			</td>

		</tr>


	</table>

EOF;

$pdf->writeHTML($bloque5, false, false, false, false, '');

$bloque6 = <<<EOF

	<table>
		<tr>
			<td style="background-color:white; width:540px; text-align:center"></td>
		</tr>
		<tr>
			<td style="background-color:white; width:540px; text-align:center"></td>
		</tr>
		<tr>
			<td style="background-color:white; width:540px; text-align:center"></td>
		</tr>
		<tr>
			<td style="background-color:white; width:540px; text-align:center"></td>
		</tr>
		<tr>
			<td style="background-color:white; width:540px; text-align:center"></td>
		</tr>
		<tr>
			<td style="background-color:white; width:540px; text-align:center"></td>
		</tr>
		<tr>
			<td style="background-color:white; width:540px; text-align:center; border-top: 2px solid #666">
				<h4 style="font-size:10px; line-height:30px">CONSIGNAR A NOMBRE DE SOLUFERT SAS BANCOLOMBIA CUENTA DE AHORROS No. 0013764450</h4>
			</td>
		</tr>
		<tr>
			<td style="font-size:8px; padding:15px 15px;background-color:white; width:540px; text-align:justify">
				Factura impresa por computador (Art:565 y 569 E.T) Resolución DIAN $numeroRes numeración autorizada de $minRes a $maxRes de $fechaRes. Se asimila en todos sus efectos legales a una letra de cambio según Art. 774 del código de comercio. La mora en el pago de sus obligaciones genera intereses a la máxima tasa legal permitida Art. 88 del código de comercio. El cliente declara que si esta factura fuese recibida y/o firmada por algún empleado o agente autorizado del comprador se entenderá como una aceptación de su contenido, plazo y valor y podrá ser reportado en caso de incumplimiento a la base de datos de procrédito o cualquier otra.
			</td>
		</tr>
	</table>

EOF;

$pdf->writeHTML($bloque6, false, false, false, false, '');



// ---------------------------------------------------------
//SALIDA DEL ARCHIVO 

$pdf->Output('Factura_No_'.$valorVenta.'.pdf');

}

}

$factura = new imprimirFactura();
$factura -> codigo = $_GET["idVenta"];
$factura -> traerImpresionFactura();

?>