<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse"
                   href="##msg_<?php echo $message->getId() ?>"><?php echo htmlspecialchars($message->getMsgHeader(), ENT_QUOTES); ?></a>
            </h4>
        </div>
        <div id="msg_<?php echo $message->getId();?>"
             class="panel-collapse collapse">
            <div class="panel-body" style="padding:5px">
                <?php echo 'From: ' . htmlspecialchars($message->getSender()->getUserName()); ?>
            </div>
            <div class="panel-body"  style="padding:5px">
                <?php echo ' To: ' . htmlspecialchars($message->getRecipient()->getUserName()); ?>
            </div>
            <div class="panel-body"><?php echo htmlspecialchars($message->getMsgBody(), ENT_QUOTES); ?></div>
        </div>
    </div>
</div>
