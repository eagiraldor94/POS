/*==============================================
=            SUBIR FOTO DEL USUARIO            =
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
=            EDITAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarUsuario' ,function(){
    var idUsuario = $(this).attr("idUsuario");
    var datos = new FormData();
    datos.append("idUsuario", idUsuario);
    $.ajax({
      url:"Ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#nameEdit').val(answer['name']);
        $('#usernameEdit').val(answer['username']);
        $('#rolEdit').html(answer['type']);

        $('#rolEdit').val(answer['type']);
        $('#password').val(answer['password']);
        $('#lastPhoto').val(answer['photo']);
        
        if (answer['photo'] != "") {
          $('#photoEdit').attr("src",answer['photo']);
        }
        
      }
    })
  });
});
/*==============================================
=            ACTIVAR O DESACTIVAR USUARIO            =
==============================================*/
$(function(){
  $(document).on('click', '.btnActivar' ,function(){
    var idUsuario = $(this).attr("idUsuario");
    var estadoUsuario = $(this).attr("estadoUsuario");
    var datos = new FormData();
    datos.append("activarUsuario", idUsuario);

    datos.append("estadoUsuario", estadoUsuario);
    $.ajax({
      url:"Ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      success: function(answer){
        window.location = "usuarios";
      }
    })
  });
});
/*==============================================
=            VERIFICACION DE USERNAME          =
==============================================*/
$(function(){
  $(document).on( 'change', '#newUser' ,function(){
    $(".alert").remove();
    var username = $(this).val();
    var datos = new FormData();
    datos.append("userCheck", username);
    $.ajax({
      url:"Ajax/usuarios.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#newUser").parent().after('<div class="alert alert-warning">Este usuario ya se encuentra registrado</div>');
            $("#newUser").val("");
        }
      }
    })
  });
});
/*==============================================
=            ELIMINAR USUARIO          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarUsuario" ,function(){
    var idUsuario = $(this).attr("idUsuario");
    var fotoUsuario = $(this).attr("fotoUsuario");

    var usuario = $(this).attr("usuario");
    swal({
      title: '¿Está seguro de borrar el usuario?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de usuario'
    }).then((result)=>{
      if(result.value){
        window.location = "index.php?ruta=usuarios&idUsuario="+idUsuario+"&fotoUsuario="+fotoUsuario+"&usuario="+usuario;
      }
    })
  });
});