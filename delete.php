<?php

	include("classes/autoloader.php");
	
    $login = new Login();
    $user_data = $login->check_login($_SESSION['connect_userid']);
    $USER = $user_data;

    //white listing - selecting very particular things
    if(isset($_GET['id']) && is_numeric($_GET['id']))
    {
    	$profile = new Profile();
        $profile_data = $profile->get_profile($_GET['id']);
    
        if(is_array($profile_data))
        {
        	$user_data = $profile_data[0];
    	}
    }

    $error = "";
    //print_r($_GET['id']);
    $post = new Post();

    if(isset($_SERVER['HTTP_REFERER']) && !strstr($_SERVER['HTTP_REFERER'], "delete.php"))
		$_SESSION['return_to'] = $_SERVER['HTTP_REFERER'];

    if(isset($_GET['id']))
    {
    	$row = $post->get_selected_post($_GET['id']);

    	if(!$row)
    	{
    		$error = "No such post was found!";
    	}
    	elseif($row['userid'] != 
		$_SESSION['connect_userid'])
		{
			$error = "Access denied! You are not authorized to delete this file!";
		}
	}
	else
	{
		$error = "No such post was found!";
	}

	//validating and deleting post
	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
		$post->delete_post($_POST['postid']);
		header("Location: " . $_SESSION['return_to']);
		die;
	}

?>


<!DOCTYPE html>
	<html>
	<head>
		<title>Connect | Delete</title>
	</head>

	<style>
		#nav-bar{
			height: 50px;
			background-color: #25274d;
			color: #c5c6c7;
		}
		#profile_pic{
			width: 150px;
			border-radius: 50%;
			border: solid 2px white;
		}
		#search_box{
			width: 400px;
			height: 20px;
			border-radius: 5px;
			border: none;
			padding: 4px;
			font-size: 14px;
			background-image: url(search.png);
			background-repeat: no-repeat;
			background-position: right;
		}
		#post_button{
			float: right;
			background-color: #25274d;
			border: none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 100px; 
		}
		#post_bar{
			margin-top: 20px;
			background-color: white;
			padding-right: 10px;
		}
		#post{
			padding: 4px;
			font-size: 14px;
			margin-bottom: 20px;
			display: flex;
		}

	</style>

	<body style="font-family: tahoma; background-color: #eae7dc;">
		<br>
		<!--Top bar-->
		<?php
			include("header.php");
		?>

		<!--Cover photo area-->
		<div style="width: 800px; margin: auto; min-height: 400px;">

			<div style="display: flex;">
			
			<!--post section-->	
				<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
					

					<div style="border: solid thin #aaa; padding: 10px; background-color: white;">

						<form method="post" action="">
							
							<?php
								if($error != "")
								{
									echo $error;
								}
								else
								{
									echo "Are you sure you want to delete this post?<br><br>";
								
									$user = new User();
									$row_user = $user->get_user($row['userid']);
									include("post_delete.php");	

									echo "<input name='postid' type='hidden' value='$row[postid]'>";
									echo "<input id='post_button' type='submit' value='Delete'>";
								}
							?>
							
							
							<br>
						</form>

					</div>
				</div>
			</div>
		</div>
	</body>
</html>