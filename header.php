<!--Top bar-->
<?php
	
	$corner_image = "images/user_male.jpg";
	if(isset($USER))
	{
		if(file_exists($USER['profile_image']))
		{
			$image_class = new Image();
			$corner_image = $image_class->get_thumbnail_profile($USER['profile_image']);
		}
		elseif ($USER['gender'] == "Female")
			$corner_image = "images/user_female.jpg";
	}
?>

<div id="nav-bar">
	<form method="get" action="search.php">
		<div style="width: 800px; margin: auto; font-size: 30px;">
			
			<!-- clicking on Connect logo-->
			<span style="padding: auto;"><a href="index.php" style="color: #c5c6c7; text-decoration: none;">Connect</a></span>

			<!-- search bar -->
			&nbsp &nbsp <input type="text" id="search_box" name="find" placeholder="Search for people">
			
			<!-- profile image on header -->
			<a href="profile.php">
				<img src="<?php echo $corner_image ?>" style="width: 50px; float: right; ">
			</a>
			
			<!-- Logout button -->
			<a href="logout.php">
			<span style="font-size: 11px; float: right; margin: 10px; color: #c5c6c7;">Logout</span></a>
		</div>
	</form>
</div>
