<?php

class Post
{
	private $error = "";

	//to retrieve images uploaded in a post
	public function create_post($userid, $data, $files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image']))
		{
			$post_image = "";
			$has_image = 0;
			$is_cover_image = 0;
			$is_profile_image = 0;

			if(isset($data['is_profile_image']) || isset($data['is_cover_image']))
			{
				$post_image = "$files";
				$has_image = 1;

				if(isset($data['is_cover_image']))
				{
					$is_cover_image = 1;
				}
				
				if(isset($data['is_profile_image']))
				{
					$is_profile_image = 1;
				}
			}
			else if(!empty($files['file']['name']))
			{	
				$folder = "uploads/" . $userid . "/";

				//create folder
				//1-execute, 2-write 4-read
				if(!file_exists($folder))
				{
					mkdir($folder, 0777, true);
					file_put_contents($folder . "index.php", "");
				}

				$image_class = new Image();
				
				$post_image  = $folder . $image_class->generate_filename(15) . ".jpg";
	    		move_uploaded_file($_FILES['file']['tmp_name'], $post_image);

	    		$image_class->resize_image($post_image, $post_image, 1500, 1500);
				$has_image = 1;
			}

			$post = "";
			if(isset($data['post']))
			{
				$post = addslashes($data['post']);
			}

			$postid = $this->create_postid();
			$parent = 0;
			$DB = new Database();

			if(isset($data['parent']) && is_numeric($data['parent']))
			{
				$parent = $data[parent];
				$query = "update posts set comments = comments + 1 where postid = '$parent' limit 1";
				$DB->save($query);
			}

			$query = "insert into posts (userid, postid, post, image, has_image, is_profile_image, is_cover_image, parent) values ('$userid', '$postid', '$post', '$post_image', '$has_image', $is_profile_image, $is_cover_image, '$parent')";

			
			$DB->save($query);
		}
		else
		{
			$this->error .= "Please type something to post!<br>";
		}
		return $this->error;
	}

	//to retrieve posts
	public function get_posts($id)
	{
		$query = "select * from posts where parent = 0 && userid = $id order by id desc limit 10";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}

	//generating a postid for a post
	private function create_postid()
	{
		$length = rand(4, 19);
		$number = "";
		for ($i=1; $i < $length; $i++)
		{
			$new_rand = rand(0,9);
			$number = $number . $new_rand; 
		}
		return $number;
	}

	//to retrieve a particular post
	public function get_selected_post($postid)
	{
		if(!is_numeric($postid))
		{
			return false;
		}

		$query = "select * from posts where postid = $postid limit 1";
		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result[0];
		}
		else
		{
			return false;
		}
	}

	//checks valid post and delete it
	public function delete_post($postid)
	{
		if(!is_numeric($postid))
		{
			return false;
		}
		$DB = new Database();
		$query = "select parent from posts where postid = $postid limit 1";
		$DB->read($query);

		if(is_array($result))
		{
			if($result[0]['parent'] > 0)
			{
				$parent = $result[0][parent];
				$query = "update posts set comments = comments - 1 where postid = '$parent' limit 1";
				$DB->save($query);
			}
		}
		$query = "delete from posts where postid = $postid limit 1";
		
		$DB->save($query);
	}

	//for hiding the like and delete button from other's timeline/posts
	public function post_user_check($postid, $connect_userid)
	{
		if(!is_numeric($postid))
		{
			return false;
		}

		$query = "select * from posts where postid = $postid limit 1";
		$DB = new Database();
		$result = $DB->read($query);

		if(is_array($result))
		{
			if($result[0]['userid'] == $connect_userid)
				return true;
		}
		
		return false;
	}


	//for likes in post, profile, comment
	public function click_like($id, $type, $connect_userid)
	{
		$DB = new Database();

		$query = "select liked_by from likes where type = '$type' && url_id = '$id' limit 1";
		$result = $DB->read($query);

		//is not the first like
		if(is_array($result))
		{
			//true - to make it an array
			//if we don't mention true. it will convert it into an object rather than array
			$liked_by = json_decode($result[0]['liked_by'], true);
			//retrieve the url_id coloumn from table likes
			$user_ids = array_column($liked_by, "userid");

			//(needle, haystack)
			//if the person has not liked the post before
			if(!in_array($connect_userid, $user_ids))
			{
				$arr['userid'] = $connect_userid;
				$arr['date'] = date("Y-m-d H:i:s");
				//appending
				$liked_by[] = $arr;
				$liked_by_str = json_encode($liked_by);
				$query = "update likes set liked_by = '$liked_by_str' where type = '$type' && url_id = '$id' limit 1";
				$DB->save($query);

				//incremeent the likes in {$type}s table
				$query = "update {$type}s set likes = likes + 1 where {$type}id = '$id' limit 1";
				$DB->save($query);
			}
			else
			{
				$key = array_search($connect_userid, $user_ids);
				unset($liked_by[$key]);
				$liked_by_str = json_encode($liked_by);
				$query = "update likes set liked_by = '$liked_by_str' where type = '$type' && url_id = '$id' limit 1";
				$DB->save($query);

				//incremeent the likes in {$type}s table
				$query = "update {$type}s set likes = likes - 1 where {$type}id = '$id' limit 1";
				$DB->save($query);
			}
		}
		//first like
		else
		{
			$arr['userid'] = $connect_userid;  
			$arr['date'] = date("Y-m-d H:i:s");
			//appending
			$arr2[] = $arr;
			$liked_by = json_encode($arr2);
			$query = "insert into likes (type, url_id, liked_by) values ('$type', '$id', '$liked_by')";
			$DB->save($query);

			//incremeent the likes in {$type}s table
			$query = "update {$type}s set likes = likes + 1 where {$type}id = '$id' limit 1";
			$DB->save($query);
		}
	}


	public function get_likes($id, $type)
	{	
		//get the details of who liked the post
		$DB = new Database();
		$query = "select liked_by from likes where type = '$type' && url_id = '$id' limit 1";
		$result = $DB->read($query);

		if(is_array($result))
		{
			$liked_by = json_decode($result[0]['liked_by'], true);
			return $liked_by;
		}
		
		return false;
	}


	//edit the post
	public function edit_post($data, $files)
	{
		if(!empty($data['post']) || !empty($files['file']['name']))
		{
			$post_image = "";
			$has_image = 0;

			if(!empty($files['file']['name']))
			{	
				$folder = "uploads/" . $userid . "/";

				if(!file_exists($folder))
				{
					mkdir($folder, 0777, true);
					file_put_contents($folder . "index.php", "");
				}

				$image_class = new Image();
				
				$post_image  = $folder . $image_class->generate_filename(15) . ".jpg";
	    		move_uploaded_file($_FILES['file']['tmp_name'], $post_image);

	    		$image_class->resize_image($post_image, $post_image, 1500, 1500);
				$has_image = 1;
			}

			$post = "";
			if(isset($data['post']))
			{
				$post = addslashes($data['post']);
			}

			$postid = addslashes($_GET['id']);

			if($has_image)
			{
				$query = "update posts set post = '$post', image = '$post_image' where postid = '$postid' limit 1";
			}
			else
			{
				$query = "update posts set post = '$post' where postid = '$postid' limit 1";
			}

			$DB = new Database();
			$DB->save($query);
		}
		else
		{
			$this->error .= "Please type something to post!<br>";
		}
		return $this->error;
	}

	//to retrieve the comments made on a post
	public function get_comments($id)
	{
		$query = "select * from posts where parent = $id order by id asc limit 20";

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			return $result;
		}
		else
		{
			return false;
		}
	}

}