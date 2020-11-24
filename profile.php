<?php

	include("classes/autoloader.php");
	//print_r($_GET);

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

    //for posting
    if($_SERVER['REQUEST_METHOD'] == "POST")
    {	
    	//for settings menu
    	if(isset($_POST['first_name']))
    	{
    		/*echo "<pre>";
    		print_r($_POST);
    		echo "</pre>";
			*/
    		$settings_class = new Settings();
    		$settings_class->save_settings($_POST, $_SESSION['connect_userid']);
    	}
    	//for normal working
    	else
    	{
			$post = new Post();
	    	$id = $_SESSION['connect_userid'];
	    	$result = $post->create_post($id, $_POST, $_FILES);
	    	
	    	if($result == "")
	    	{
	    		header("Location: profile.php");
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
    }

    //retrieve posts
    $post = new Post() ;
    $id = $user_data['userid'];
    $posts = $post->get_posts($id);

    //retrieve friends
    $user = new User();
    $friends = $user->get_following($user_data['userid'], "user");


    $image_class = new Image();
?>

<!DOCTYPE html>
	<html>
	<head>
		<title>Connect | Profile</title>
		<link rel="stylesheet" href="css/profile.css">
	</head>


	<body style="font-family: tahoma; background-color: #eae7dc;">
		<br>

		<!--top-bar-->
		<?php
			include("header.php");
		?>

		<!--Cover photo area-->
		<div style="width: 800px; margin: auto; min-height: 400px;">
			<div style="background-color: white; text-align: center; color: #116466; padding: 0px">

				<?php

					$image = "images/cover_placeholder.jpg";
					if(file_exists($user_data['cover_image']))
					{
						$image = $image_class->get_thumbnail_cover($user_data['cover_image']);
					}
				?>
				<img src="<?php echo $image; ?>" style="width: 100%;">

				
				<!-- profile image-->
				<span style="font-size: 11px;">
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


					<!--URL query strings -> changing profile and cover images-->
					<a href="change_profile_image.php?change=profile" style="text-decoration: none; color: grey;">Change Profile Picture</a> |

					<a href="change_profile_image.php?change=cover" style="text-decoration: none; color: grey;">Change Cover Photo</a>
				</span>
				<br>

				<div style="font-size: 20px;">
					<a href="profile.php?id=<?php echo $user_data['userid']; ?>" style="text-decoration: none; color: black;">
						<?php echo $user_data['first_name'] . " " . $user_data['last_name']; ?>
					</a>
					<br>

					<!-- follow and unfollow button-->
					<?php
						$followers_count = $user_data['likes'];
						if($followers_count == 0)
						{
							$followers_count = "";
						}

						elseif($followers_count == 1)
						{
							$followers_count = "(" . $followers_count . " Follower)";
						}
						else
						{
							$followers_count = "(" . $followers_count . " Followers)";
						}
					?>
					<a href="like.php?type=user&id=<?php echo $user_data['userid']; ?>">
						<input id="post_button" type="button" value="Follow <?php echo $followers_count; ?>" style="float: none; padding-left: 10px; width: auto;">
					</a>
					<br>
				</div>


				<!--menu section-->
					<a href="index.php" style="text-decoration: none;"><div id="menu_buttons">Timeline</div></a>
					<a href="profile.php?section=about&id=<?php echo $user_data['userid']; ?>" /><div id="menu_buttons">About</div></a>
					<a href="profile.php?section=followers&id=<?php echo $user_data['userid']; ?>" /><div id="menu_buttons">Followers</div></a>
					<a href="profile.php?section=following&id=<?php echo $user_data['userid']; ?>" /><div id="menu_buttons">Following</div></a>
					<a href="profile.php?section=photos&id=<?php echo $user_data['userid']; ?>" /><div id="menu_buttons">Photos</div></a>
					
					<?php
						if($user_data['userid'] == $_SESSION['connect_userid'])
						{
							echo '<a href="profile.php?section=settings&id='.$user_data['userid'].'"><div id="menu_buttons">Settings</div></a>';
						}
					?>
					</div>

			<!--below menu bar - redirection-->
			<?php
				$section = "default";
				if(isset($_GET['section']))
				{
					$section = $_GET['section'];
				}

				if($section == "default")
				{
					include("profile_default.php");
				}
				elseif($section == "photos")
				{
					include("menu_photos.php");
				}
				elseif($section == "followers")
				{
					include("menu_followers.php");
				}
				elseif($section == "following")
				{
					include("menu_following.php");
				}
				elseif($section == "settings")
				{
					include("menu_settings.php");
				}
				elseif($section == "about")
				{
					include("menu_about.php");
				}
			?>

		</div>
	</body>
</html>