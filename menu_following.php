<div style="overflow: auto; width: 100%; margin-top: 20px; background-color: white; text-align: center;">
	
	<div style="padding: 10px;">				
		<?php
			$image_class = new Image();
			$user_class = new User();
			$post_class = new Post();
			$following = $user_class->get_following($user_data['userid'],"user");

			if(is_array($following))
			{
				foreach ($following as $following_row) {
					$friend_row = $user_class->get_user($following_row['userid']);
					include("user.php");
				}
			}
			else
			{
				echo "User is not following anyone";
			}
		?>
	</div>
</div>