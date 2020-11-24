<div style="overflow: auto; width: 100%; margin-top: 20px; background-color: white; text-align: center;">
	
	<div style="padding: 10px;">				
		<?php
			$image_class = new Image();
			$user_class = new User();
			$post_class = new Post();
			$followers = $post_class->get_likes($user_data['userid'],"user");

			if(is_array($followers))
			{
				foreach ($followers as $follower) {
					$friend_row = $user_class->get_user($follower['userid']);
					include("user.php");
				}
			}
			else
			{
				echo "No followers were found!";
			}
		?>
	</div>
</div>