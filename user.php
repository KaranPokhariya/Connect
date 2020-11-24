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

<div id="friends">

	<?php 
		//placing placeholder till the time user has not placed his/her profile image

		$image = "images/user_male.jpg";
		if($friend_row['gender'] == "Female")
		{
			$image = "images/user_female.jpg";
		}

		if(file_exists($friend_row['profile_image']))
		{
			$image = $image_class->get_thumbnail_profile($friend_row['profile_image']);
		}

	?>

	<!-- making the friends img and name clickable-->
	<a href="profile.php?id=<?php echo $friend_row['userid']; ?>">
		<img id="friends_img" src="<?php echo $image; ?>">
		<br><br>
		<?php echo "<span style='float: left;'>" . $friend_row['first_name'] . " " . $friend_row['last_name'] . "</span>"; ?>
	</a>
</div>