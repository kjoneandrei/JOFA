<div class="panel panel-default">
    <div class="panel-heading" onclick="$('#msgbody_<?php echo $message->getId() ?>').slideToggle()"><?php echo $message->getMsgHeader() ?></div>
    <div class="panel-body msgbody" id="msgbody_<?php echo $message->getId() ?>"><?php echo $message->getMsgBody() ?></div>
</div>
