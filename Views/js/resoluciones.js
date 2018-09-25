/*==============================================
=            EDITAR RESOLUCION           =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarResolucion' ,function(){
    var idResolucion = $(this).attr("idResolucion");
    var datos = new FormData();
    datos.append("idResolucion", idResolucion);
    $.ajax({
      url:"Ajax/resoluciones.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#resNumberEdit').val(answer['res_number']);
        $('#firstNumberEdit').val(answer['first_number']);
        $('#lastNumberEdit').val(answer['last_number']);
        $('#dateEdit').val(answer['resDate']);
        $('#id').val(answer['id']);        
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE CATEGORIA          =
==============================================*/
$(function(){
  $(document).on( 'change', '#newResNumber' ,function(){
    $(".alert").remove();
    var resNumber = $(this).val();
    var datos = new FormData();
    datos.append("resolutionCheck", resNumber);
    $.ajax({
      url:"Ajax/resoluciones.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#newResNumber").parent().after('<div class="alert alert-warning">Esta resolución ya existe</div>');
            $("#newResNumber").val("");
        }
      }
    })
  });
});
/*==============================================
=            ELIMINAR RESOLUCION          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarResolucion" ,function(){
    var idResolucion = $(this).attr("idResolucion");
    swal({
      title: '¿Está seguro de borrar la resolución?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de resolución'
    }).then((result)=>{
      if(result.value){
        window.location = "index.php?ruta=resoluciones&idResolucion="+idResolucion;
      }
    })
  });
});