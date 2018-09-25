
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
    $('#product-get').on("change", function(){
      var idProducto = $(this).val();
      if(idProducto == ""){
        if( typeof $_GET['fechaInicial'] != 'undefined' && $_GET['fechaInicial'] != "" && $_GET['fechaInicial'] != 'undefined')
          window.location = "index.php?ruta=informes-productos&fechaInicial="+$_GET['fechaInicial']+"&fechaFinal="+$_GET['fechaFinal'];
        else{
          window.location = 'informes-productos';
        }
      }else{

        var getRutaProductos = window.location.pathname;
        if (getRutaProductos=='/informes-productos') {
          window.location = "index.php?ruta=informes-productos&idProducto="+idProducto;
        }else{
          if( typeof $_GET['fechaInicial'] != 'undefined' && $_GET['fechaInicial'] != "" && $_GET['fechaInicial'] != 'undefined'){
            window.location = "index.php?ruta=informes-productos&idProducto="+idProducto+"&fechaInicial="+$_GET['fechaInicial']+"&fechaFinal="+$_GET['fechaFinal'];
          }else{
            window.location = "index.php?ruta=informes-productos&idProducto="+idProducto;
          }
        }
      }
    });
  /*==============================================
=           REPORTES POR PRODUCTO         =
==============================================*/
if (localStorage.getItem('rango3') != null) {
  $('span#reportrange3').html(localStorage.getItem('rango3'));
}else{
  $('span#reportrange3').html('<i class="fa fa-calendar"></i> Rango de fecha');
}
  
/*==============================================
=            Rango de fechas         =
==============================================*/
    $('#daterange-btn3').daterangepicker(
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
        $('span#reportrange3').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        var rango = $('span#reportrange3').html();
        localStorage.setItem('rango3', rango);
        var getRutaProductos = window.location.pathname;
         if (getRutaProductos=='/informes-productos') {
          window.location = "index.php?ruta=informes-productos&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
        }else{

          if( typeof $_GET['idProducto'] != 'undefined' && $_GET['idProducto'] != "" && $_GET['idProducto'] != 'undefined'){
            window.location = "index.php?ruta=informes-productos&idProducto="+$_GET['idProducto']+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
          }else{
            window.location = "index.php?ruta=informes-productos&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
          }
        }
      }
    );
/*==============================================
=           Cancelar rango de fechas         =
==============================================*/
    $('.daterangepicker.opensright .range_inputs .cancelBtn').on("click", function(){
      localStorage.removeItem('rango3');
      localStorage.clear();
      if( typeof $_GET['idProducto'] != 'undefined' && $_GET['idProducto'] != "" && $_GET['idProducto'] != 'undefined'){
        window.location = "index.php?ruta=informes-productos&idProducto="+$_GET['idProducto'];
      }
      else{
        window.location = 'informes-productos';
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

    localStorage.setItem('rango3', 'Hoy');
    var getRutaProductos = window.location.pathname;
    if (getRutaProductos=='/informes-productos') {
      window.location = "index.php?ruta=informes-productos&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
    }else{
      if( typeof $_GET['idProducto'] != 'undefined' && $_GET['idProducto'] != "" && $_GET['idProducto'] != 'undefined'){
        window.location = "index.php?ruta=informes-productos&idProducto="+$_GET['idProducto']+"&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
      }else{
        window.location = "index.php?ruta=informes-productos&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
      }
    }
  }
});

});
