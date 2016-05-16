<DOCTYPE html>
<html>
  <head>
      <script src="js/jquery-2.2.3.min.js"></script>
      <script src="bootstrap-3.3.6/js/bootstrap.min.js"></script>
      <link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/css/bootstrap.min.css"/>
      <link rel="stylesheet" type="text/css" href="bootstrap-3.3.6/css/bootstrap-theme.min.css">
      <link rel="stylesheet" type="text/css" href="css/JOFA.css">
  </head>
  <body>
    <header>
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a class="navbar-brand" href="/">Home</a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <li><a class="" data-toggle="modal" data-target="#signup-modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>
                    <li><a href="#"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
                </ul>
            </div>
        </nav>

    </header>

    <div class="container">
        <?php
        require_once('routes.php');
        include 'modals/signup.html';
        include 'modals/login.html';
        ?>
    </div>

    <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <p class="navbar-text pull-left">Site Built By <a href="#">JOFA</a><sup>&COPY;</sup> - 2016</p>
        </div>
    </div>

  <body>
<html>