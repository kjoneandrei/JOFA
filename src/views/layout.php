<DOCTYPE html>
    <?php
    include_once 'models/user.php';
    session_start();
    ?>
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
                <div class="navbar-header ">
                    <a class="navbar-brand" href="/">Home</a>
                </div>
                <div class="navbar-header"><a class="navbar-brand" href="/">
                        <?php if (isset($_SESSION[USER])) {
                            echo 'Logged in as: ';
                            echo $_SESSION[USER]->getUserName();

                        }
                        ?>
                    </a>
                </div>
                <ul class="nav navbar-nav navbar-right">
                    <?php if (isset($_SESSION[USER])) {
                        echo '<li><a data-toggle="modal" data-target="#newmessage-modal"><span class="glyphicon glyphicon-plus"></span> New message</a></li>';
                        echo '<li><a href="?controller=messages&action=sentmessages"><span class="glyphicon glyphicon-list-alt"></span> Sent Messages</a></li>';
                        echo '<li><a href="?controller=messages&action=mymessages"><span class="glyphicon glyphicon-envelope"></span> My messages</a></li>';
                        echo '<li><a href="?controller=users&action=logout"><span class="glyphicon glyphicon-log-out"></span> Log out</a></li>';
                    } else {
                        echo '<li><a data-toggle="modal" data-target="#signup-modal"><span class="glyphicon glyphicon-user"></span> Sign Up</a></li>';
                        echo '<li><a data-toggle="modal" data-target="#login-modal"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>

    </header>

    <div class="container">
        <?php
        require_once('routes.php');
        ?>
    </div>

    <div class="navbar navbar-default navbar-fixed-bottom">
        <div class="container">
            <p class="navbar-text pull-left">Site Built By <a href="#">JOFA</a><sup>&COPY;</sup> - 2016</p>
        </div>
    </div>

    <?php
    include 'modals/login.html';
    include 'modals/newmessage.html';
    include 'modals/signup.html';
    ?>
    </body>
    </html>