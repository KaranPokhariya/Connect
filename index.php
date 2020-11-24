<!-- Timeline-->

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

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
    	$post = new Post();
    	$id = $_SESSION['connect_userid'];
    	$result = $post->create_post($id, $_POST, $_FILES);
    	
    	if($result == "")
    	{
    		header("Location: index.php");
    		die;
    	}
    	else
    	{
            echo "<div style='text-align: center; font-size: 14px; color: white; background-color: grey;'>";
            echo "<br>Following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }
    }

?>


<!DOCTYPE html>
	<html>
	<head>
		<title>Connect | Timeline</title>
	</head>

	<style>
		#nav-bar{
			height: 50px;
			background-color: #25274d;
			color: #c5c6c7;
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
		#profile_pic{
			width: 150px;
			border-radius: 50%;
			border: solid 2px white;
		}
		#menu_buttons{
			width: 100px;
			display: inline-block;
			margin: 2px;
		}
		#friends_bar{
			min-height: 400px;
			margin-top: 20px;
			color: #25274d;
			padding: 8px;
			text-align: center;
			font-size: 20px;
		}
		#friends{
			clear: both;
			font-size: 12px;
			font-weight: bold;
			color: #25274d;
		}
		#friends_img{
			width: 75px;
			float: left;
			margin: 8px;
		}
		textarea{
			width: 100%;
			border: none;
			font-family: tahoma;
			font-size: 14px;
			height: 60px;
		}
		#post_button{
			float: right;
			background-color: #25274d;
			border: none;
			color: white;
			padding: 4px;
			font-size: 14px;
			border-radius: 2px;
			width: 50px; 
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

			<!--friends section-->
			<div style="display: flex;">
				<div style="min-height: 400px; flex: 1;">
					<div id="friends_bar">
						
						<?php
							$image = "images/user_male.jpg";
							if($user_data['gender'] == "Female")
							{
								$image = "images/user_female.jpg";
							}
							if(file_exists($user_data['profile_image']))
							{
								$image = $image_class->get_thumbnail_profile($user_data['profile_image']);
							}
						?>
						<img id="profile_pic" src="<?php echo $image; ?>"><br>

						<a href="profile.php" style="text-decoration: none; color: #25274d;">
							<?php echo $user_data['first_name'] . " " . $user_data['last_name'];
							?>

						</a>

					</div>
				</div>


			<!--post section-->	
			<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
				
				<div style="border: solid thin #aaa; padding: 10px; background-color: white;">
					<form method="post" action="" enctype="multipart/form-data">
						<textarea name="post" placeholder="Whats on your mind?"></textarea>
						<input type="file" name="file">
						<input id="post_button" type="submit" value="Post">
						<br>
					</form>
				</div>


				<!--posts-->
				<div id="post_bar">
						<?php

							$DB = new Database();
							$user = new User();
							$image_class = new Image();

							$following = $user->get_following($_SESSION['connect_userid'], "user");
							$following_ids = false;
							if(is_array($following))
							{
								$following_ids = array_column($following, "userid");
								//takes all the values from an array and connect them together in one line to make a single string.
								//glue - text in between those values and pieces - array itself
								$following_ids = implode("','", $following_ids);
							}
							$posts = false;
							if($following_ids)
							{
								$my_userid = $_SESSION['connect_userid'];
								$query = "select * from posts where parent = 0 && userid = '$my_userid' || userid in('" . $following_ids . "') order by id desc limit 30";
								$posts = $DB->read($query);
							}
							
							if($posts)
							{
								foreach ($posts as $row)
								{
									$row_user = $user->get_user($row['userid']);
									echo "<span>";
									include("post.php");
									echo "</span>";
								}
							}
							
						?>
				</div>
			</div>
		</div>
	</body>
</html>