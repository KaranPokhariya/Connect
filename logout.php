<?php

session_start();

if(isset($_SESSION['connect_userid']))
{
	unset($_SESSION['connect_userid']);
}

header("Location: login.php");
die;

?>