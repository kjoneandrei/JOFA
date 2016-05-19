<div class="panel panel-default">
    <div class="panel-heading"
         onclick="$('#msgbody_<?php echo $message->getId() ?>').slideToggle()"><?php echo htmlspecialchars($message->getMsgHeader(), ENT_QUOTES); ?>
    </div>
    <div class="panel-body msgbody"
         id="msgbody_<?php echo $message->getId() ?>"><?php echo htmlspecialchars($message->getMsgBody(), ENT_QUOTES); ?>
    </div>
</div>
