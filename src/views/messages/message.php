<div class="panel-group">
    <div class="panel panel-default">
        <div class="panel-heading">
            <h4 class="panel-title">
                <a data-toggle="collapse"
                   href="##msg_<?php echo $message->getId() ?>"><?php echox($message->getMsgHeader()); ?></a>
            </h4>
        </div>
        <div id="msg_<?php echo $message->getId(); ?>"
             class="panel-collapse collapse">
            <div class="panel-body" style="padding:5px">
                <?php echox('From: ' . $message->getSender()->getUserName()); ?>
            </div>
            <div class="panel-body" style="padding:5px">
                <?php echox(' To: ' . $message->getRecipient()->getUserName()); ?>
            </div>
            <div class="panel-body"><?php echox($message->getMsgBody()); ?></div>
        </div>
    </div>
</div>
