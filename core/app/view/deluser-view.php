<?php

$user = UserData::getById($_GET["id"]);
$user->del();
Core::redir("./index.php?view=users");

?>