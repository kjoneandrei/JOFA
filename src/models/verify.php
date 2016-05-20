
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
/**
* Created by PhpStorm.
* User: andreihogea
* Date: 20/05/16
* Time: 12:19
*/
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>NETTUTS > Sign up</title>
    <link href="css/style.css" type="text/css" rel="stylesheet" />
</head>
<body>
    <!-- start header div -->
    <div id="header">
        <h3>JOFAJOFA > Sign up</h3>
    </div>
    <!-- end header div -->

    <!-- start wrap div -->
    <div id="wrap">
        <!-- start PHP code -->
        <?php

            mysql_connect("localhost", "tutorial", "password") or die(mysql_error()); // Connect to database server(localhost) with username and password.
            mysql_select_db("registrations") or die(mysql_error()); // Select registration database.

        ?>
<!-- stop PHP Code -->


</div>
<!-- end wrap div -->
</body>
</html>