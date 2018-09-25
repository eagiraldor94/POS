/*==============================================
=            SUBIR FOTO DEL CLIENTE            =
==============================================*/
$(function(){
  $(document).on('change','.photo',function(){
  var imagen = this.files[0];
  // validar imagen jpg o png
  if(imagen['type'] != "image/jpeg" && imagen['type'] != "image/png"){
    $('.photo').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe estar en formato JPG o PNG",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });
  }else if(imagen['size'] > 2097152){
    $('.photo').val("");
    swal({
          title: "Error al subir la imagen",
          text: "La imagen debe pesar menos de 2MB",
          type: "error",
          confirmButtonText: "¡Entendido!"
        });  
  }else{
    var datosImagen = new FileReader;
    datosImagen.readAsDataURL(imagen);

    $(datosImagen).on("load", function(event){
      var rutaImagen = event.target.result;
      $(".previsualizar").attr("src",rutaImagen);
    })
  }
});
});
/*==============================================
=            EDITAR CLIENTE            =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarCliente' ,function(){
    var idCliente = $(this).attr("idCliente");
    var datos = new FormData();
    datos.append("idCliente", idCliente);
    $.ajax({
      url:"Ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#nameEdit').val(answer['name']);
        $('#documentEdit').val(answer['id_number']);

        $('#addressEdit').val(answer['address']);
        $('#cityEdit').val(answer['city']);
        $('#lastPhoto').val(answer['photo']);
        $('#phone1Edit').val(answer['phone1']);        
        $('#phone2Edit').val(answer['phone2']);        
        $('#birthdayEdit').val(answer['birthday']);        
        $('#emailEdit').val(answer['email']);
        
        if (answer['photo'] != "") {
          $('#photoEdit').attr("src",answer['photo']);
        }
        
      }
    })
  });
});

/*==============================================
=            VERIFICACION DE DOCUMENTO          =
==============================================*/
$(function(){
  $(document).on( 'change', '#newDocument' ,function(){
    $(".alert").remove();
    var idNumber = $(this).val();
    var datos = new FormData();
    datos.append("documentCheck", idNumber);
    $.ajax({
      url:"Ajax/clientes.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#newDocument").parent().after('<div class="alert alert-warning">Este número de documento ya se encuentra registrado</div>');
            $("#newDocument").val("");
        }
      }
    })
  });
});
/*==============================================
=            ELIMINAR CLIENTE          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarCliente" ,function(){
    var idCliente = $(this).attr("idCliente");
    var fotoCliente = $(this).attr("fotoCliente");

    var cliente = $(this).attr("cliente");
    swal({
      title: '¿Está seguro de borrar el cliente?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de cliente'
    }).then((result)=>{
      if(result.value){
        window.location = "index.php?ruta=clientes&idCliente="+idCliente+"&fotoCliente="+fotoCliente+"&cliente="+cliente;
      }
    })
  });
});