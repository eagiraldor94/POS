<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Administrar categorias</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Categorias</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <!-- Default box -->
      <div class="card">
        <div class="card-header">
          <button class="btn btn-danger" data-toggle="modal" data-target="#modalAgregarCategoria"> Agregar Categoría </button>
        </div>
        
        <div class="card-body">
          <table class="table table-bordered table-striped tabla dt-responsive">
            <thead>
              <tr>
                <th style="width:10px">#</th>
                <th>Nombre de categoria</th>
                <th>Acciones</th>
              </tr>
            </thead>
            <tbody>
              <?php 
                $item = null;
                $value = null;
                $categorias = ControladorCategorias::ctrMostrarCategorias($item,$value);
                foreach ($categorias as $key => $categoria) {
                  echo '
                  <tr>
                    <td>'.($key+1).'</td>
                    <td>'.$categoria['name'].'</td>
                    <td>
                       <div class="btn-group">
                        <button class="btn btn-warning btnEditarCategoria" idCategoria="'.$categoria['id'].'" data-toggle="modal" data-target="#modalEditarCategoria"><i class="fa fa-pen"></i></button>
                        <button class="btn btn-danger btnBorrarCategoria" idCategoria="'.$categoria['id'].'"><i class="fa fa-times"></i></button>
                        
                      </div>
                    </td>
                  </tr>
                  ';
                }

               ?>
              
            </tbody>
          </table>
          
          
        </div>
        <!-- /.card-body -->

      </div>
      <!-- /.card -->

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <!--=====================================
  =          Ventana Modal Add         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalAgregarCategoria">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Agregar Categoría</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-th"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" placeholder="Ingresar nombre de la categoría" required>
                </div>
                
              </div>
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="newCategorie">Guardar Categoria</button>
          </div>
        <?php 
          $crearCategoria = new ControladorCategorias();
          $crearCategoria -> ctrCrearCategoria();
         ?>
      </form>

    </div>
  </div>
</div>
  <!--=====================================
  =          Ventana Modal Edit         =
  ======================================-->
<!-- The Modal -->
<div class="modal" id="modalEditarCategoria">

  <div class="modal-dialog">

    <div class="modal-content">
        <form role="form" method="post">

          <!-- Modal Header -->
          <div class="modal-header" style="background: #E5231D ; color: white">

            <h4 class="modal-title">Editar Categoria</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!-- Modal body -->
          <div class="modal-body">
            <div class="box-body">
              <!-- nombre -->
              <div class="form-group">
                <div class="input-group mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="fa fa-th"></i></span>
                  </div>
                  
                  <input class="form-control" type="text" name="newName" placeholder="Editar nombre de categoría" id="nameEdit" required>

                </div>
                <input type="hidden" name="id" id="id">
              </div>
             
            </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="button" class="btn btn-danger pull-left" data-dismiss="modal">Salir</button>

            <button type="submit" class="btn btn-success" name="editCategorie">Modificar Categoría</button>
          </div>
        <?php 
          $editarCategoria = new ControladorCategorias();
          $editarCategoria -> ctrEditarCategoria();
         ?>
      </form>

    </div>
  </div>
</div>
  <?php 
    $borrarCategoria = new ControladorCategorias();
    $borrarCategoria -> ctrBorrarCategoria();
   ?>