<!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Bienvenido al sistema POS</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="inicio">Inicio</a></li>
              <li class="breadcrumb-item active">Tablero</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">

      <div class="row m-3">
        <?php 
        if ($_SESSION['rank']=='Admin') {
          include 'dashboard/main-boxes.php';
        }
         ?>
      </div>
      <div class="row mb-3 pb-5 mx-3">
        <div class="col-lg-12">
          <?php 
        if ($_SESSION['rank']=='Admin') {
            include "Reports/sales-graphic.php";
          }
           ?>
        </div>
        <div class="col-lg-6">
          <?php 
        if ($_SESSION['rank']=='Admin') {
            include "Reports/product-sales.php";
          }
           ?>
        </div>
        <div class="col-lg-6">
          <?php 
        if ($_SESSION['rank']=='Admin') {
            include "Dashboard/recent-products.php";
          }
           ?>
        </div>
        <div class="col-lg-12">
          <?php 
        if ($_SESSION['rank']!='Admin') {
          echo '<div class="card">
                  <div class="card-body">
                    <div class="row justify-content-center py-0 my-5">
                      <img src="Views/img/plantilla/AF_LOGO_SISTEMA_POS-01.png" alt="Logo Esforza" class="align-self-center" id="logoBienvenida" style="width: 60%;">
                    </div>
                    <div class="row justify-content-center pt-0 pb-5 mt-0 mb-5" id="textoBienvenida">
                      <h5 class="text-center">Bienvenid@ '.$_SESSION['name'].'. Este es el sistema tipo POS. Podrá encontrar la navegación a través de sus diferentes modulos a los que se le ha concedido acceso en el lado izquierdo de su pantalla.</h5>
                    </div>  
                  </div>
                </div>';
        }


           ?>
        </div>
      </div>

    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
      