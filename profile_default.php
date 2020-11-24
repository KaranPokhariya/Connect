<!DOCTYPE html>
<html>
	<head>
		<title>Connect | Timeline</title>
	</head>
	<body>
			
		<!--friends section -> below menu bar-->
		<div style="display: flex;">
			<div style="min-height: 400px; flex: 1;">
				<div id="friends_bar">
					Friends<br>
					
					<?php

						if($friends)
						{
							foreach ($friends as $friend) {
								$friend_row = $user->get_user($friend['userid']);
								include("user.php");
							}
						}
						
					?>						

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

						if($posts)
						{
							foreach ($posts as $row) {

								$user = new User();
								$row_user = $user->get_user($row['userid']);
								include("post.php");
							}
						}
					?>
				</div>
			</div>
		</div>		
	</body>
</html>