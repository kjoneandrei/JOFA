<div class="panel panel-default">
    <div class="panel-heading"
         onclick="$('#msgbody_<?php echo $message->getId() ?>').slideToggle()">
        <h3 class="page-header">
            <?php echo 'From: ' . htmlspecialchars($message->getSender()->getUserName()); ?>
            <?php echo ' To: ' . htmlspecialchars($message->getRecipient()->getUserName()); ?>
        </h3>
    </div>
    <div class="panel-body msgbody"
         id="msgbody_<?php echo $message->getId() ?>">
        <h3 class="page-header"><?php echo htmlspecialchars($message->getMsgHeader(), ENT_QUOTES); ?></h3>
        <p><?php echo htmlspecialchars($message->getMsgBody(), ENT_QUOTES); ?></p>
    </div>
</div>
