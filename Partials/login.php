<div class="login-box">
  <div class="login-logo">
    <a href=""><img src="Views/img/plantilla/AF_LOGO_GRANDE-01.png" alt="Logotipo_Esforza" class="img-fluid"
           style="margin: -25% 0px -20% 0px"></a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Ingresar al sistema POS</p>

      <form method="post">

        <div class="form-group has-feedback">

          <input type="text" class="form-control" placeholder="Usuario" name="user" required>

          <span class="fa fa-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
          <input type="password" class="form-control" placeholder="Contraseña" name="pass" required>
          <span class="fa fa-lock form-control-feedback"></span>
        </div>
        <div class="row">
          <!-- /.col -->
          <div class="col-12">
            <button type="submit" class="btn btn-danger btn-block btn-flat">Ingresar</button>
          </div>
          <!-- /.col -->
        </div>
        <?php 
          $login= new ControladorUsuarios();
          $login-> ctrIngresoUsuario();
         ?>
      </form>

      
    </div>
    <!-- /.login-card-body -->
  </div>
</div>