
 $(function(){
var $_GET = {};
if(document.location.toString().indexOf('?') !== -1) {
    var query = document.location
                   .toString()
                   // get the query string
                   .replace(/^.*?\?/, '')
                   // and remove any existing hash string (thanks, @vrijdenker)
                   .replace(/#.*$/, '')
                   .split('&');

    for(var i=0, l=query.length; i<l; i++) {
       var aux = decodeURIComponent(query[i]).split('=');
       $_GET[aux[0]] = aux[1];
    }
}
/*==============================================
=           Capturar producto         =
==============================================*/
    $('#client-get').on("change", function(){
      var idCliente = $(this).val();
      if(idCliente == ""){
        if( typeof $_GET['fechaInicial'] != 'undefined' && $_GET['fechaInicial'] != "" && $_GET['fechaInicial'] != 'undefined')
          window.location = "index.php?ruta=informes-clientes&fechaInicial="+$_GET['fechaInicial']+"&fechaFinal="+$_GET['fechaFinal'];
        else{
          window.location = 'informes-clientes';
        }
      }else{

        var getRutaClientes = window.location.pathname;
        if (getRutaClientes=='/informes-clientes') {
          window.location = "index.php?ruta=informes-clientes&idCliente="+idCliente;
        }else{
          if( typeof $_GET['fechaInicial'] != 'undefined' && $_GET['fechaInicial'] != "" && $_GET['fechaInicial'] != 'undefined'){
            window.location = "index.php?ruta=informes-clientes&idCliente="+idCliente+"&fechaInicial="+$_GET['fechaInicial']+"&fechaFinal="+$_GET['fechaFinal'];
          }else{
            window.location = "index.php?ruta=informes-clientes&idCliente="+idCliente;
          }
        }
      }
    });
  /*==============================================
=           REPORTES POR PRODUCTO         =
==============================================*/
if (localStorage.getItem('rango4') != null) {
  $('span#reportrange4').html(localStorage.getItem('rango4'));
}else{
  $('span#reportrange4').html('<i class="fa fa-calendar"></i> Rango de fecha');
}
  
/*==============================================
=            Rango de fechas         =
==============================================*/
    $('#daterange-btn4').daterangepicker(
      {
        ranges   : {
          'Hoy'       : [moment(), moment()],
          'Ayer'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Últimos 7 dias' : [moment().subtract(6, 'days'), moment()],
          'Últimos 30 dias': [moment().subtract(29, 'days'), moment()],
          'Este mes'  : [moment().startOf('month'), moment().endOf('month')],
          'El mes pasado'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment(),
        endDate  : moment(),
        "locale": {
          closeText: 'Cerrar',
       prevText: '< Ant',
       nextText: 'Sig >',
       currentText: 'Hoy',
       monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
       monthNamesShort: ['Ene','Feb','Mar','Abr', 'May','Jun','Jul','Ago','Sep', 'Oct','Nov','Dic'],
       dayNames: ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'],
       dayNamesShort: ['Dom','Lun','Mar','Mié','Juv','Vie','Sáb'],
       dayNamesMin: ['Do','Lu','Ma','Mi','Ju','Vi','Sá'],
        "daysOfWeek": ["Do","Lu","Ma","Mi","Ju","Vi","Sa"],
       weekHeader: 'Sm',
       dateFormat: 'dd/mm/yy',
       firstDay: 1,
       isRTL: false,
       showMonthAfterYear: false,
       yearSuffix: ''
        }
      },
      function (start, end) {
        $('span#reportrange4').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        var rango = $('span#reportrange4').html();
        localStorage.setItem('rango4', rango);
        var getRutaClientes = window.location.pathname;
         if (getRutaClientes=='/informes-clientes') {
          window.location = "index.php?ruta=informes-clientes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
        }else{

          if( typeof $_GET['idCliente'] != 'undefined' && $_GET['idCliente'] != "" && $_GET['idCliente'] != 'undefined'){
            window.location = "index.php?ruta=informes-clientes&idCliente="+$_GET['idCliente']+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
          }else{
            window.location = "index.php?ruta=informes-clientes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
          }
        }
      }
    );
/*==============================================
=           Cancelar rango de fechas         =
==============================================*/
    $('.daterangepicker.opensright .range_inputs .cancelBtn').on("click", function(){
      localStorage.removeItem('rango4');
      localStorage.clear();
      if( typeof $_GET['idCliente'] != 'undefined' && $_GET['idCliente'] != "" && $_GET['idCliente'] != 'undefined'){
        window.location = "index.php?ruta=informes-clientes&idCliente="+$_GET['idCliente'];
      }
      else{
        window.location = 'informes-clientes';
      }
    });
/*==============================================
=           Capturar hoy         =
==============================================*/
$('.daterangepicker.opensright .ranges li').on('click',function(){
  var hoy = $(this).html();
  if (hoy == 'Hoy') {
    var d = new Date();
    var dia = d.getDate();
    var mes = d.getMonth()+1;
    var año = d.getFullYear();
    if (mes <10) {
      var fechaInicial = año+"-0"+mes+"-"+dia;
      var fechaFinal = año+"-0"+mes+"-"+dia;
    }else if (dia < 10) {
      var fechaInicial = año+"-"+mes+"-0"+dia;
      var fechaFinal = año+"-"+mes+"-0"+dia;
    }else if (dia < 10 && mes<10 ) {
      var fechaInicial = año+"-0"+mes+"-0"+dia;
      var fechaFinal = año+"-0"+mes+"-0"+dia; 
    }else{
      var fechaInicial = año+"-"+mes+"-"+dia;
     var fechaFinal = año+"-"+mes+"-"+dia;
    }

    localStorage.setItem('rango4', 'Hoy');
    var getRutaClientes = window.location.pathname;
    if (getRutaClientes=='/informes-clientes') {
      window.location = "index.php?ruta=informes-clientes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
    }else{
      if( typeof $_GET['idCliente'] != 'undefined' && $_GET['idCliente'] != "" && $_GET['idCliente'] != 'undefined'){
        window.location = "index.php?ruta=informes-clientes&idCliente="+$_GET['idCliente']+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
      }else{
        window.location = "index.php?ruta=informes-clientes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
      }
    }
  }
});

});
