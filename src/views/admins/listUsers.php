<?php
/**
 * Created by PhpStorm.
 * User: Ferenc_S
 * Date: 5/16/2016
 * Time: 5:19 PM
 */
?>
<table class="table user-list">
    <thead>
    <tr>
        <th><span>User</span></th>
        <th><span>Name</span></th>
        <th><span>Role</span></th>
        <th class="text-center"><span>Status</span></th>
        <th><span>Email</span></th>
        <th>&nbsp;</th>
    </tr>
    </thead>
    <tbody>

    <?php
    foreach ($users as &$user) {
        require 'views/admins/user.php';
    } ?>
    </tbody>
</table>
