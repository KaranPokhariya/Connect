<div style="overflow: auto; width: 100%; margin-top: 20px; background-color: white; text-align: center;">
	
	<div style="padding: 10px;">				
		<?php
			$DB = new Database();
			$query = "select image, postid from posts where has_image = 1 && userid = $user_data[userid] order by id desc limit 30";
			$images = $DB->read($query);

			$image_class = new Image();

			if(is_array($images))
			{
				foreach ($images as $images_row) {
					echo "<a href='individual_post.php?id=$images_row[postid]' >";
					echo "<img src='" . $image_class->get_thumbnail_post($images_row['image']) . "' style='width: 200px; margin:10px;' />";
					echo "</a>";
				}
			}
			else
			{
				echo "No photos were found!";
			}

		?>
	</div>
</div>