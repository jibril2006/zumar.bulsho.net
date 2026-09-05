<?php
require_once '_core/init.php';

$user = new User();
$user->logout();

Redirect::to('login.php');

?>