<?php /** @var User $user */ ?>
<tr>
    <td class="col-xs-2">
        <img src="uploads/<?php echo $user->getImgPath(); ?>" alt="">
        <a href="#" class="user-link"></a>
        <span class="user-subhead"></span>
    </td>
    <td class="col-xs-2"><?php echox($user->getUsername()); ?></td>
    <td class="col-xs-2"><?php echo $user->isAdmin() ? 'Admin' : 'User'; ?></td>
    <td class="col-xs-2 text-center">
        <?php require 'views/admins/userstatus.php' ?>
    </td>
    <td class="col-xs-2">
        <a href="#"><?php echox($user->getEmail()); ?></a>
    </td>
    <td class="col-xs-2">
        <?php require 'views/admins/userban.php'?>
    </td>
</tr>