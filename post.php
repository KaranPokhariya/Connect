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

<div id="post">
	<div>
		<?php 

			$image = "images/user_male.jpg";
			if($row_user['gender'] == "Female")
			{
				$image = "images/user_female.jpg";
			}

			if(file_exists($row_user['profile_image']))
			{
				$image = $image_class->get_thumbnail_profile($row_user['profile_image']);
			}
			

		?>
	
		<img src="<?php echo $image; ?>" style="width: 75px; margin: 4px; border-radius: 50%">
	</div>
	<div style="width: 100%;">
		<!-- name and profile photo on the post-->
		<div style="font-weight: bold; color:#25274d; width:100%">
			<br>
			<?php 
				echo "<a href='profile.php?id=$row[userid]' >";
				echo htmlspecialchars($row_user['first_name']) . " " . htmlspecialchars($row_user['last_name']);
				echo "</a>";

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

		<br><br>

		<!--like and commment-->
		<?php
			$like_status = "Like";
			$likes_count = "";
			$likes_count = ($row['likes'] > 0) ? "(" . $row['likes'] . ")" : "";
		?>
		
		
		<!--. <a href="">Comment</a> .
		-->


		<!-- Like and Unlike  -->
		<?php

			if(isset($_SESSION['connect_userid']))
				{
					$i_liked = false;
					$DB = new Database();
					$query = "select liked_by from likes where type = 'post' && url_id = '$row[postid]' limit 1";
					$result = $DB->read($query);
					

					if(is_array($result))
					{
						
						$liked_by = json_decode($result[0]['liked_by'], true);
						$user_ids = array_column($liked_by, "userid");

						if(in_array($_SESSION['connect_userid'], $user_ids))
						{
							$i_liked = true;
							$like_status = "Unlike";
							echo "<a href='like.php?type=post&id=$row[postid]' style='color= #25274d;'> $like_status" ;
							echo $likes_count . "</a>";
						}
					}
				}

			if(!$i_liked)
			{
				echo "<a href='like.php?type=post&id=$row[postid]' style='color= #25274d;'>";
				echo $like_status;
				echo $likes_count . "</a>";
			}

		?>

		<!-- Commment -->
		<?php
			$comments = "";
			if($row['comments'] > 0)
			{
				$comments = "(" . $row['comments'] . ")";
			}
		?>
		. <a href="individual_post.php?id=<?php echo $row['postid']; ?>">Comment<?php echo $comments; ?></a> . 

		<span style="color: #aaa;">
			<?php echo $row['date'] ?>
		</span>

		<!-- for full view of the image-->
		<?php
			if($row['has_image'])
			{
				echo ". " . "<a href='view_full_image.php?id=$row[postid]' >";
				echo "View Full Image";
				echo "</a>";
			}

		?>


		<!-- Edit and Delete -->
		<span style="color: #aaa; float: right;">
		<?php
			$post = new Post();
			if($post->post_user_check($row['postid'], $_SESSION['connect_userid']))
			{
				echo "
				<a href='edit.php?id=$row[postid]' style='color= #25274d;'>
					Edit
				</a> . 

				<a href='delete.php?id=$row[postid]' style='color= #25274d;'>
				Delete
				</a>";
			}
			
		?>
		</span>



		<!-- Who all liked the post? -->
		<?php
			
			if(isset($_SESSION['connect_userid']))
			{
				$i_liked = false;
				$DB = new Database();
				$query = "select liked_by from likes where type = 'post' && url_id = '$row[postid]' limit 1";
				$result = $DB->read($query);
				

				if(is_array($result))
				{
					
					$liked_by = json_decode($result[0]['liked_by'], true);
					$user_ids = array_column($liked_by, "userid");

					if(in_array($_SESSION['connect_userid'], $user_ids))
					{
						$i_liked = true;
					}
				}

				echo "<br>";
				echo  "<a href='liked_by.php?type=post&id=$row[postid]'>";			
				if($row['likes'] == 1)
				{
					if($i_liked)
					{
						echo "<span style='float:left; color: blue; text-decoration: underline;'>You liked this post</span>";
					}
					else
					{
						echo "<span style='float:left; color: blue; text-decoration: underline;'>1 person liked this post </span>";
					}
				}
				else if($row['likes'] > 1)
				{
					if($i_liked)
					{
						if($row['likes'] == 2)
						{
							echo "<span style='float:left; color: blue; text-decoration: underline;'>You and 1 other person liked this post </span>";
						}
						else
						{
							echo "<span style='float:left; color: blue; text-decoration: underline;'>You and " . ($row['likes'] - 1). " people liked this post </span>";
						}
					}
					else
					{
						echo "<span style='float:left; color: blue; text-decoration: underline;'>" . $row['likes'] . " people liked this post </span>";
					}
				}
				echo "</a>";
			}
		?>
	</div>
</div>