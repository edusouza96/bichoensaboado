<!doctype html>
<html lang="pt-br">
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="/bichoensaboado/css/bootstrap.min.css" rel="stylesheet">
    <link href="/bichoensaboado/css/styleLogin.css" rel="stylesheet">

    <meta property="og:url" content="http://bichoensaboado.com.br/view/login">
    <meta property="og:title" content="Bicho Ensaboado - Login">
    <meta property="og:description" content="Intranet">
    <meta property="og:image" content="http://bichoensaboado.com.br/bichoensaboado/img/logo.jpg">
    <link rel="icon" type="image/png" href="/bichoensaboado/img/logo.jpg" />

  </head>

  <body>
    <?php
      header('Content-Type: text/html; charset=utf-8');
      session_start();
      session_destroy();
      
      if(!empty($_GET['code'])){
        $path = $_SERVER['DOCUMENT_ROOT'];
        include_once($path."/bichoensaboado/view/inc/message.php");
      }
    ?>
      <div class="container col-xs-offset-1 col-xs-10 col-sm-offset-3 col-sm-6 col-lg-offset-4 col-lg-4 col-md-offset-4 col-md-4">

        <form class="form-signin" action="../../controller/Manager.php" method="POST">
          <center>
            <img id="icon" src="../../img/logo.jpg">
          </center>
          <h2 class="form-signin-heading">Entrar</h2>

          <div class="row">
            <div class="form-group">
              <label for="nameLogin" class="sr-only">User</label>
              <input type="hidden" name="module" value="login"/>
              <input type="text" id="nameLogin" name="nameLogin" class="form-control" placeholder="Usuário" required autofocus>
            </div>
          </div>

          <div class="row">
            <div class="form-group">
              <label for="passwordLogin" class="sr-only">Senha</label>
              <input type="password" id="passwordLogin" name="passwordLogin" class="form-control" placeholder="Password" required>
            </div>
          </div>

          <div class="row">
            <div class="form-group">
              <button class="btn btn-lg btn-primary btn-block" type="submit">Entrar</button>
            </div>
          </div>
        </form>
      </div>
  </body>
</html>
