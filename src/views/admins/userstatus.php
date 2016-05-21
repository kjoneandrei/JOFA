<?php /** @var User $user */
if (!$user->isActive()) {
    $labeltype = 'primary';
    $labelcode = 'inactive';
} else if ($user->isBanned()) {
    $labeltype = 'danger';
    $labelcode = 'banned';
} else {
    $labeltype = 'success';
    $labelcode = 'active';
}

?>
<span class="label label-<?php echo $labeltype . '">'; echo $labelcode; ?></span>