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
    $row = false;
    $post = new Post();
    if(isset($_GET['id']))
    {
    	$row = $post->get_selected_post($_GET['id']);
	}
	else
	{
		$error = "No such image was found!";
	}

?>


<!DOCTYPE html>
	<html>
	<head>
		<title>Connect | Comment</title>
		<link rel="stylesheet" href="css/full_image.css">
	</head>
		
	<body>
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
								echo "<img src='$row[image]' style=width:100%; ";
							}

						?>
						<br style="clear: both;">
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
