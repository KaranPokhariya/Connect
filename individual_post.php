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
    		header("Location: individual_post.php?id=$_GET[id]");
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
    
    $error = "";
    $row = false;
    $post = new Post();
    if(isset($_GET['id']))
    {
    	$row = $post->get_selected_post($_GET['id']);
	}
	else
	{
		$error = "No such post was found!";
	}

?>


<!DOCTYPE html>
	<html>
	<head>
		<title>Connect | Comment</title>
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

							if(is_array($row))
							{
								$row_user = $user->get_user($row['userid']);
								include("post.php");
							}

						?>
						<br style="clear: both;">

						<div style="border: solid thin #aaa; padding: 10px; background-color: white; ">

							<form method="post" action="" enctype="multipart/form-data">
								<textarea name="post" style="width: 100%; border: none; font-size: 14px;" placeholder="Post a comment..."></textarea>
								<input type="hidden" name="parent" value="<?php echo $row['postid']; ?>">
								<input type="file" name="file">
								<input id="post_button" type="submit" value="Post">
								<br>
							</form>

						</div>

							<?php
								$comments = $post->get_comments($row['postid']);
								if(is_array($comments))
								{
									foreach ($comments as $comment) {
										include("comment.php");
									}
								}
							?>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>