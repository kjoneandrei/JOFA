<h1>Messages you sent</h1>
<div class="panel-group">
    <?php
    if (isset($messages)) {
        foreach ($messages as &$message) {
            require 'views/users/message.php';
        }
    } else echo 'There doesn\'t seem to be anything here';
    ?>
</div>