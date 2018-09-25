/*==============================================
=            Cambiando menu activo            =
==============================================*/
$(function(){
  $(document).on('click','.nav-link',function(){
    $('.nav-link').removeClass("active");
    $(this).addClass("active");
});
  var getRuta = window.location.pathname;

  switch(getRuta) {
    case '/inicio':
        $('#inicio').addClass("active");
        $('#inicioTree').addClass("menu-open");
        break;
    case '/':
        $('#inicio').addClass("active");
        $('#inicioTree').addClass("menu-open");
        break;
    case '/reportes':
        $('#reportes').addClass("active");
        $('#reportesGenerales').addClass("active");
        $('#reportesTree').addClass("menu-open");
        break;
    case '/informes-productos':
        $('#reportes').addClass("active");
        $('#reportesPorProducto').addClass("active");
        $('#reportesTree').addClass("menu-open");
        break;
    case '/informes-clientes':
        $('#reportes').addClass("active");
        $('#reportesPorCliente').addClass("active");
        $('#reportesTree').addClass("menu-open");
        break;
    case '/ventas-administrar':
        $('#ventas').addClass("active");
        $('#ventasAdmin').addClass("active");
        $('#ventasTree').addClass("menu-open");
        break; 
    case '/ventas-editar':
        $('#ventas').addClass("active");
        $('#ventasAdmin').addClass("active");
        $('#ventasTree').addClass("menu-open");
        break;
    case '/ventas-crear':
        $('#ventas').addClass("active");
        $('#crearVenta').addClass("active");
        $('#ventasTree').addClass("menu-open");
        break;
    case '/resoluciones':
        $('#ventas').addClass("active");
        $('#resAdmin').addClass("active");
        $('#ventasTree').addClass("menu-open");
        break;
    case '/usuarios':
        $('#usuarios').addClass("active");
        break;
    case '/categorias':
        $('#categorias').addClass("active");
        break;
    case '/productos':
        $('#productos').addClass("active");
        break;
    case '/clientes':
        $('#clientes').addClass("active");
        break;menu-open
    case '/proveedores':
        $('#proveedores').addClass("active");
        break;
    default:
        break;
  }
});
/*==============================================
=            EDITAR USUARIO            =
==============================================*/
$(function(){
$(document).on('click', '#ventasAdmin' ,function(){
    localStorage.removeItem('rango');
    localStorage.clear();
});
$(document).on('click', '#reportesGenerales' ,function(){
    localStorage.removeItem('rango2');
    localStorage.clear();
});
  $(document).on('click', '.btnEditarMain' ,function(){
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
        $('#nameEditMe').val(answer['name']);
        $('#usernameEditMe').val(answer['username']);
        $('#passwordMe').val(answer['password']);
        $('#lastPhotoMe').val(answer['photo']);
        
        if (answer['photo'] != "") {
          $('#photoEditMe').attr("src",answer['photo']);
        }
        
      }
    })
  });
});