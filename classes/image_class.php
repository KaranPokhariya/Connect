<?php

class Image
{

	public function crop_image($original_filename, $cropped_filename, $max_width, $max_height)
	{

		if(file_exists($original_filename))
		{
			$orginal_image = imagecreatefromjpeg($original_filename);

			$orginal_width = imagesx($orginal_image);
			$orginal_height = imagesy($orginal_image);

			if($orginal_height > $orginal_width)
			{
				//make the width equal to max_width
				$ratio = $max_width / $orginal_width;

				$new_width = $max_width;
				$new_height = $orginal_height * $ratio;

			}else
			{
				//make the height equal to max_height
				$ratio = $max_height / $orginal_height;

				$new_height = $max_height;
				$new_width = $orginal_width * $ratio;

			}

		}

		//adjust in case max_width and max_width are different (for cover image)
		
		if($max_height != $max_width)
		{	
			if($max_height >$max_width)
			{
				if($max_height > $new_height)
				{
					$adjustment = ($max_height / $new_height);
				}else
				{
					$adjustment = ($new_height / $max_height);
				}

				$new_width = $new_width * $adjustment;
				$new_height = $new_height * $adjustment;

			}else
			{
				if($max_width > $new_width)
				{
					$adjustment = ($max_width / $new_width);
				}else
				{
					$adjustment = ($new_width / $max_width);
				}

				$new_height = $new_height * $adjustment;
				$new_width = $new_width * $adjustment;
			}
		}

		$new_image = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($new_image, $orginal_image, 0, 0, 0, 0, $new_width, $new_height, $orginal_width, $orginal_height);

		imagedestroy($orginal_image);

		if($max_height != $max_width)
		{
			if($max_width > $max_height)
			{
				$diff = ($new_height - $max_height);
				if($diff < 0){
					$diff = $diff * -1;
				}
				$y = round($diff / 2);
				$x = 0;
			}else
			{
				$diff = ($new_width - $max_width);
				if($diff < 0){
					$diff = $diff * -1;
				}
				$x = round($diff / 2);
				$y = 0;
			}
		}else
		{
			if($new_height > $new_width)
			{
				$diff = ($new_height - $new_width);
				$y = round($diff / 2);
				$x = 0;
			}else
			{
				$diff = ($new_width - $new_height);
				$x = round($diff / 2);
				$y = 0;
			}
		}

		$new_cropped_image = imagecreatetruecolor($max_width, $max_height);
		imagecopyresampled($new_cropped_image, $new_image, 0, 0, $x, $y, $max_width, $max_height, $max_width, $max_height);
		
		imagedestroy($new_image);

		imagejpeg($new_cropped_image, $cropped_filename, 90);
		imagedestroy($new_cropped_image);
	}


	//generate array which we are using to make the path of the images(profile/cover)
	public function generate_filename($length)
	{	
		$arr = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F", "G", "H", "I", "J", "K", "L", "M", "N", "O", "P", "Q", "R", "S", "T", "U", "V", "W", "X", "Y", "Z", "a", "b", "c", "d", "e", "f", "g", "h", "i", "j", "k", "l", "m", "n", "o", "p", "q", "r", "s", "t", "u", "v", "w", "x", "y", "z");
		$text = "";

		for ($i=0; $i < $length; $i++)
		{ 
			$random = rand(0, 61);
			$text .= $arr[$random];
		}

		return $text;
	}


	//resize the image (profile/cover)
	public function resize_image($original_filename, $resized_filename, $max_width, $max_height)
	{

		if(file_exists($original_filename))
		{
			$orginal_image = imagecreatefromjpeg($original_filename);

			$orginal_width = imagesx($orginal_image);
			$orginal_height = imagesy($orginal_image);

			if($orginal_height > $orginal_width)
			{
				//make the width equal to max_width
				$ratio = $max_width / $orginal_width;

				$new_width = $max_width;
				$new_height = $orginal_height * $ratio;

			}else
			{
				//make the height equal to max_height
				$ratio = $max_height / $orginal_height;

				$new_height = $max_height;
				$new_width = $orginal_width * $ratio;

			}

		}

		//adjust in case max_width and max_width are different (for cover image)
		
		if($max_height != $max_width)
		{	
			if($max_height >$max_width)
			{
				if($max_height > $new_height)
				{
					$adjustment = ($max_height / $new_height);
				}else
				{
					$adjustment = ($new_height / $max_height);
				}

				$new_width = $new_width * $adjustment;
				$new_height = $new_height * $adjustment;

			}else
			{
				if($max_width > $new_width)
				{
					$adjustment = ($max_width / $new_width);
				}else
				{
					$adjustment = ($new_width / $max_width);
				}

				$new_height = $new_height * $adjustment;
				$new_width = $new_width * $adjustment;
			}
		}

		$new_image = imagecreatetruecolor($new_width, $new_height);
		imagecopyresampled($new_image, $orginal_image, 0, 0, 0, 0, $new_width, $new_height, $orginal_width, $orginal_height);

		imagedestroy($orginal_image);

		imagejpeg($new_image, $resized_filename, 90);
		imagedestroy($new_image);
	}


	//create thumbnail for cover image
	public function get_thumbnail_cover($filename)
	{
		$thumbnail = $filename . "_cover_thumb.jpg";
		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}

		$this->crop_image($filename, $thumbnail, 1366, 488);

		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}else
		{
			return $filename;
		}
	}

	//create thumbnail for profile image
	public function get_thumbnail_profile($filename)
	{
		$thumbnail = $filename . "_profile_thumb.jpg";
		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}

		$this->crop_image($filename, $thumbnail, 800, 800);

		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}else
		{
			return $filename;
		}
	}


	//create thumbnail for post image
	public function get_thumbnail_post($filename)
	{
		$thumbnail = $filename . "_post_thumb.jpg";
		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}

		$this->crop_image($filename, $thumbnail, 1500, 1500);

		if(file_exists($thumbnail))
		{
			return $thumbnail;
		}else
		{
			return $filename;
		}
	}


}