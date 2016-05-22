<?php if ($user->isBanned())
{
    $target = 'href="?controller=admins&action=unban&userid=' . $user->getId();
    $bantext = 'Unban';
} else
{
    $target = 'href="?controller=admins&action=ban&userid=' . $user->getId();
    $bantext = 'Ban';
} ?>
<a <?php echo $target . '&csrf=' . $_SESSION[TOKEN]; ?>">
<button class="btn btn-danger"><?php echo $bantext; ?></button>
</a>
