/*==============================================
=            EDITAR CATEGORIA           =
==============================================*/
$(function(){
  $(document).on('click', '.btnEditarCategoria' ,function(){
    var idCategoria = $(this).attr("idCategoria");
    var datos = new FormData();
    datos.append("idCategoria", idCategoria);
    $.ajax({
      url:"Ajax/categorias.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        $('#nameEdit').val(answer['name']);
        $('#id').val(answer['id']);        
      }
    })
  });
});

/*==============================================
=            VERIFICACION DE CATEGORIA          =
==============================================*/
$(function(){
  $(document).on( 'change', '#nameEdit' ,function(){
    $(".alert").remove();
    var categorie = $(this).val();
    var datos = new FormData();
    datos.append("categorieCheck", categorie);
    $.ajax({
      url:"Ajax/categorias.ajax.php",
      method: "POST",
      data: datos,
      cache: false,
      contentType: false,
      processData: false,
      dataType: "json",
      success: function(answer){
        if (answer) {
            $("#nameEdit").parent().after('<div class="alert alert-warning">Esta categoría ya existe</div>');
            $("#nameEdit").val("");
        }
      }
    })
  });
});
/*==============================================
=            ELIMINAR CATEGORIA          =
==============================================*/
$(function(){
  $(document).on( 'click', ".btnBorrarCategoria" ,function(){
    var idCategoria = $(this).attr("idCategoria");
    swal({
      title: '¿Está seguro de borrar la categoría?',
      text: "¡Si no lo está puede cancelar la acción!",
      type: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      cancelButtonText: 'Cancelar',
      confirmButtonText: 'Confirmar borrado de categoría'
    }).then((result)=>{
      if(result.value){
        window.location = "index.php?ruta=categorias&idCategoria="+idCategoria;
      }
    })
  });
});