<style>
	a:link{
	  text-decoration: none;
	}

	a:visited{
	  text-decoration: none;
	}

	a:hover{
	  text-decoration: underline;
	}

	a:active{
	  text-decoration: underline;
	}
</style>

<!DOCTYPE html>
<html>
<head>
	<title>Connect | Delete Post</title>
</head>

	<body>
		<div id="post">
			<div>
				<?php 

					$image = "images/user_male.jpg";
					if($row_user['gender'] == "Female")
					{
						$image = "images/user_female.jpg";
					}

					$image_class = new Image();
					if(file_exists($row_user['profile_image']))
					{
						$image = $image_class->get_thumbnail_profile($row_user['profile_image']);
					}
					

				?>
			
				<img src="<?php echo $image; ?>" style="width: 75px; margin: 4px; border-radius: 50%">
			</div>

			<div style="width: 100%;">
				<!-- name on the post-->
				<div style="font-weight: bold; color:#25274d; width:100%">
					<?php 
						echo htmlspecialchars($row_user['first_name']) . " " . htmlspecialchars($row_user['last_name']);
						if($row['is_profile_image'])
						{
							$pronoun = "his";
							if($row_user['gender'] == "Female")
								$pronoun = "her";
							echo "<span style='font-weight:normal; color:#aaa;'> updated $pronoun profile picture</span>";
						}

						if($row['is_cover_image'])
						{
							$pronoun = "his";
							if($row_user['gender'] == "Female")
								$pronoun = "her";
							echo "<span style='font-weight:normal; color:#aaa;'> updated $pronoun cover photo</span>";
						}
					?>
				</div>
				
				<!--post content-->

				<!-- htmlspecialchars: for security - Convert the predefined characters "<" (less than) and ">" (greater than) to HTML entities-->
				<?php echo htmlspecialchars($row['post']) ?>

				<!-- post image-->
				<br><br>
				<?php 
					if(file_exists($row['image']))
						{
							$post_image = $image_class->get_thumbnail_post($row['image']);
							echo "<img src='$post_image' style='width:80%;'>";
						}
				?>
			</div>
		</div>
	</body>
</html>