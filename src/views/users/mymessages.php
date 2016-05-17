<div class="panel-group">
    <?php
    if (isset($messages)) {
        foreach ($messages as &$message) {
            require 'views/users/message.php';
        }
    } else echo 'no messages sadly';
    ?>
</div>