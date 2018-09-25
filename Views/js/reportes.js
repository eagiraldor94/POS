
 $(function(){

/*==============================================
=           REPORTES GENERALES         =
==============================================*/
if (localStorage.getItem('rango2') != null) {
  $('span#reportrange2').html(localStorage.getItem('rango2'));
}else{
  $('span#reportrange2').html('<i class="fa fa-calendar"></i> Rango de fecha');
}
  
/*==============================================
=            Rango de fechas         =
==============================================*/
    $('#daterange-btn2').daterangepicker(
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
        $('span#reportrange2').html(start.format('DD/MM/YYYY') + ' - ' + end.format('DD/MM/YYYY'));
        var fechaInicial = start.format('YYYY-MM-DD');
        var fechaFinal = end.format('YYYY-MM-DD');
        var rango = $('span#reportrange2').html();
        localStorage.setItem('rango2', rango);
        window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
      }
    );
/*==============================================
=           Cancelar rango de fechas         =
==============================================*/
    $('.daterangepicker.opensright .range_inputs .cancelBtn').on("click", function(){
      localStorage.removeItem('rango2');
      localStorage.clear();
      window.location = "reportes";
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

    localStorage.setItem('rango2', 'Hoy');
    window.location = "index.php?ruta=reportes&fechaInicial="+fechaInicial+"&fechaFinal="+fechaFinal;
  }
});
});
