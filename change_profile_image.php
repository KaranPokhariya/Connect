<?php

	include("classes/autoloader.php");

    $login = new Login();
    $user_data = $login->check_login($_SESSION['connect_userid']);


    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
    	//echo "<pre>";
    	//print_r($_POST);
    	//print_r($_FILES);
    	//echo "</pre>";

    	if(isset($_FILES['file']['name']) && ($_FILES['file']['name']) != "")
    	{
    		/*
    		echo "<pre>";
    		print_r($_FILES);
    		echo "</pre>";
    		die;
    		*/

    		if($_FILES['file']['type'] == "image/jpeg")
    		{
    			$allowed_size = (1024 * 1024) * 5;
    			if($_FILES['file']['size'] <= $allowed_size)
    			{
    				//creating folder for individual user adn uploading files/images
    				$folder = "uploads/" . $user_data['userid'] . "/";

    				//create folder
    				//1-execute, 2-write 4-read
    				if(!file_exists($folder))
    				{
    					mkdir($folder, 0777, true);
    				}

    				$image = new Image();

    				$filename = $folder . $image->generate_filename(15) . ".jpg";
		    		move_uploaded_file($_FILES['file']['tmp_name'], $filename);

		    		$change = "profile";

	    			//check for change mode (cover image/profile image)
	    			if(isset($_GET['change']))
	    			{
	    				$change = $_GET['change'];
	    			}

		    		if($change == "cover")
		    		{
		    			if(file_exists($user_data['cover_image']))
		    			{
		    				unlink($user_data['cover_image']);
		    			}
		    			$image->resize_image($filename, $filename, 1500, 1500);
		    		}else
		    		{
		    			if(file_exists($user_data['profile_image']))
		    			{
		    				unlink($user_data['profile_image']);
		    			}
		    			$image->resize_image($filename, $filename, 1500, 1500);
		    		}
		    		

		    		if(file_exists($filename))
		    		{
		    			$userid = $user_data['userid'];

		    			//cover image update
		    			if($change == "cover")
		    			{
		    				$query = "update users set cover_image = '$filename' where userid = $userid limit 1";
		    				$_POST['is_cover_image'] = 1;
		    			}else
		    			{
		    				//profile image update
		    				$query = "update users set profile_image = '$filename' where userid = $userid limit 1";
		    				$_POST['is_profile_image'] = 1;
		    			}

		    			$DB = new Database();
		    			$DB->save($query);

		    			//profile pic/cover pic update post
		    			$post = new Post();
				    	$post->create_post($userid, $_POST, $filename);

		    			header("Location: profile.php");
		    			die;
		    		}
    			}else
    			{
    				echo "<div style='text-align: center; font-size: 14px; color: white; background-color: grey;'>";
            		echo "<br>Only images of size 5Mb or lower are allowed<br><br>";
            		echo "</div>";
    			}
    		}else
    		{
    			echo "<div style='text-align: center; font-size: 14px; color: white; background-color: grey;'>";
            	echo "<br>Only .jpeg files are allowed<br><br>";
            	echo "</div>";
    		}

    	}else
    	{
    		echo "<div style='text-align: center; font-size: 14px; color: white; background-color: grey;'>";
            echo "<br>Please add a valid image<br><br>";
            echo "</div>";
    	}
    	
    }
?>


<!DOCTYPE html>
	<html>
	<head>
		<title>Connect | Change Profile Picture</title>
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
		#change_button{
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

			
			<!--post section-->	
				<div style="min-height: 400px; flex: 2.5; padding: 20px; padding-right: 0px;">
					
					<!-- enctype - specifies how the form-data should be encoded when submitting it to the server. can be used only if method="post"

					multipart/form-data - No characters are encoded. This value is required when you are using forms that have a file upload control
					-->
					<form method="post" enctype="multipart/form-data">
						<div style="border: solid thin #aaa; padding: 10px; background-color: white;">
							
							<input type="file" name="file">
							<input id="change_button" type="submit" value="Change">
							<br>

							<div style="text-align: center;">
								<br><br>
								<?php

									if(isset($_GET['change']) && $_GET['change'] == "cover")
					    			{
					    				$change = "cover";
					    				echo "<img src='$user_data[cover_image]' style='max-width: 500px;'>";
					    			}else
					    			{
					    				echo "<img src='$user_data[profile_image]' style='max-width: 500px;'>";
					    			}

					    		?>
				    		</div>
						</div>
					</form>
					
			</div>
		</div>
	</body>
</html>