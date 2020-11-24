<?php

	include("classes/autoloader.php");
	
	$login = new Login();
    $user_data = $login->check_login($_SESSION['connect_userid']);
    /*echo $_GET;
    echo "<pre>";
    print_r($_GET);
    echo "</pre>";
    */
	if(isset($_SERVER['HTTP_REFERER']))
		$return_to = $_SERVER['HTTP_REFERER'];
	else
		$return_to = "profile.php";
	
	if(isset($_GET['id']) && isset($_GET['type']))
	{
		//postid
		if(is_numeric($_GET['id']))
		{	
			//echo "YES";
			$allowed[] = 'post';
			$allowed[] = 'user';
			$allowed[] = 'comment';

			if(in_array($_GET['type'], $allowed))
			{
				//need to know: who liked it? the type?
				$post = new Post();
				$user_class = new User();
				$post->click_like($_GET['id'], $_GET['type'], $_SESSION['connect_userid']);

				if($_GET['type'] == "user")
				{
					$user_class->follow_user($_GET['id'], $_GET['type'], $_SESSION['connect_userid']);
				}
			} 
		}
	}

	header("Location: " . $return_to);
	die;
	