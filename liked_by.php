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
    $liked_by_details = false;
    $post = new Post();
    if(isset($_GET['id']) && isset($_GET['type']))
    {
    	$liked_by_details = $post->get_likes($_GET['id'], $_GET['type']);
	}
	else
	{
		$error = "No such post was found!";
	}

?>


<!DOCTYPE html>
	<html>
	<head>
		<title>Connect | Liked By</title>
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
		#friends{
			clear: both;
			font-size: 12px;
			font-weight: bold;
			color: #25274d;
		}
		#friends_img{
			width: 45px;
			float: left;
			margin: 8px;
			border-radius: 50%;
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

						<?php
							$user = new User();
							$image_class = new Image();

							if($liked_by_details)
							{
								foreach ($liked_by_details as $row)
								{
									$friend_row = $user->get_user($row['userid']);
									include("user.php");
								}
							}

						?>
						<br style="clear: both;">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>