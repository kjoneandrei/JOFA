<?php if ($user->isBanned())
{
    $target = '?controller=admins&action=unBan';
    $bantext = 'Unban';
} else
{
    $target = '?controller=admins&action=ban';
    $bantext = 'Ban';
} ?>
<form method="POST" action="<?php echo $target ?>">
    <?php formToken() ?>
    <input type="hidden" name="userid" value="<?php echo $user->getId() ?>"/>
    <button type="submit" class="btn btn-danger"><?php echo $bantext; ?></button>
</form>
