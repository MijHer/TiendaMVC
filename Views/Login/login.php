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
      <div class="login-box">
        <div id="divLoading" >
          <div>
            <img src="<?= media(); ?>/images/loading.svg" alt="Loading">
          </div>
        </div>
        <form class="login-form" id="formLogin" name="formLogin">
          <h3 class="login-head"><i class="fa fa-lg fa-fw fa-user"></i>INICIAR SESSION</h3>
          <div class="form-group">
            <label class="control-label">Correo</label>
            <input id="txtEmail" name="txtEmail" class="form-control" type="email" placeholder="Correo" autofocus>
          </div>
          <div class="form-group">
            <label class="control-label">Contraseña</label>
            <input id="txtPassword" name="txtPassword" class="form-control" type="password" placeholder="Contraseña">
          </div>
          <div class="form-group">
            <div class="utility">              
              <p class="semibold-text mb-2"><a href="#" data-toggle="flip">¿Olvidate tu contraseña?</a></p>
            </div>
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-sign-in fa-lg fa-fw"></i>Iniciar session</button>
          </div>
        </form>

        <!-- FORMULARIO PARA RECUPERAR LA CONTRASEÑDA -->
        <form class="forget-form" id="formRecetPass" name="formRecetPass" action="">
          <h4 class="login-head"><i class="fa fa-lg fa-fw fa-lock"></i>¿Olvidate tu contraseña?</h4>
          <div class="form-group">
            <label class="control-label">Correo</label>
            <input class="form-control" id="txtEmailReset" name="txtEmailReset" type="email" placeholder="Correo">
          </div>
          <div class="form-group btn-container">
            <button type="submit" class="btn btn-primary btn-block"><i class="fa fa-unlock fa-lg fa-fw"></i>REINICIAR</button>
          </div>
          <div class="form-group mt-3">
            <p class="semibold-text mb-0"><a href="#" data-toggle="flip"><i class="fa fa-angle-left fa-fw"></i> Iniciar session</a></p>
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