<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="description" content="Tinda Virtual">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="MH Miher">
    <meta name="theme-color" content="#009688">
    <link rel="shortcut icon" href="<?= media(); ?>/images/favicon.ico">
    <title><?= $data['page_tag'] ?></title>
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/main.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="<?= media(); ?>/css/style.css">
  </head>
  <body>
    <section class="material-half-bg">
      <div class="cover"></div>
    </section>
    <section class="login-content">
      <div class="logo">
        <h1><?= $data['page_saludo'];?></h1>
      </div>
      <div class="login-box flipped">
        <div id="divLoading" >
          <div>
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
          </div>
        </div>
        <!-- FORMULARIO PARA CAMBIAR LA CONTRASEÑDA -->
        <form class="forget-form" id="formCambiarPass" name="formCambiarPass" action="">
          <input type="hidden" id="idUsuario" name="idUsuario" value="<?= $data['idpersona'];?>" required> 
          <input type="hidden" id="txtEmail" name="txtEmail" value="<?= $data['email'];?>" required>
          <input type="hidden" id="txtToken" name="txtToken" value="<?= $data['token'];?>" required>
          <h4 class="login-head"><i class="fas fa-key"></i>  Cambiar Contraseña</h4>
          <div class="form-group">
            <input class="form-control" id="txtPassword" name="txtPassword" type="password" placeholder="Nueva Contraseña" required>
          </div>
          <div class="form-group">
            <input class="form-control" id="txtPasswordConfirm" name="txtPasswordConfirm" type="password" placeholder="Confirmar Contraseña" required>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
        </form>
      </div>
    </section>
    <script>
        const base_url = "<?= base_url();?>";
    </script>
    <!-- Essential javascripts for application to work-->
    <script src="<?= media(); ?>/js/jquery-3.3.1.min.js"></script>
    <script src="<?= media(); ?>/js/popper.min.js"></script>
    <script src="<?= media(); ?>/js/bootstrap.min.js"></script>
    <script src="<?= media(); ?>/js/main.js"></script>
    <script src="<?= media(); ?>/js/fontawesome.js"></script>    
    <!-- The javascript plugin to display page loading on top-->
    <script src="<?= media(); ?>/js/plugins/pace.min.js"></script>
    <script type="text/javascript" src="<?= media(); ?>/js/plugins/sweetalert.min.js"></script>

    <script src="<?= media(); ?>/js/<?= $data['functions_login_js']?>"></script>    
  </body>
</html>