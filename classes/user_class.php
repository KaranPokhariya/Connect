<?php

class User
{

	public function get_data($id)
	{
		$query = "select * from users where userid = '$id' limit 1"; 

		$DB = new Database();
		$result = $DB->read($query);

		if($result)
		{
			$row = $result[0];
			return $row;
		}
		else
		{
			return false;
		}
	}

	public function get_user($id)
	{
		$query = "select * from users where userid = $id limit 1";

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

	public function get_friends($id)
	{
		$query = "select * from users where userid != $id";

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


	public function get_following($id, $type)
	{	
		//get following details
		$DB = new Database();
		$query = "select following from likes where type = '$type' && url_id = '$id' limit 1";
		$result = $DB->read($query);

		if(is_array($result))
		{
			$following = json_decode($result[0]['following'], true);
			return $following;
		}
		
		return false;
	}


	public function follow_user($id, $type, $connect_userid)
	{
		$DB = new Database();

		$query = "select following from likes where type = '$type' && url_id = '$connect_userid' limit 1";
		$result = $DB->read($query);

		//is not the first like
		if(is_array($result))
		{
			$liked_by = json_decode($result[0]['following'], true);
			$user_ids = array_column($liked_by, "userid");

			if(!in_array($id, $user_ids))
			{
				$arr['userid'] = $id;
				$arr['date'] = date("Y-m-d H:i:s");
				//appending
				$liked_by[] = $arr;
				$liked_by_str = json_encode($liked_by);
				$query = "update likes set following = '$liked_by_str' where type = '$type' && url_id = '$connect_userid' limit 1";
				$DB->save($query);
			}
			else
			{
				$key = array_search($id, $user_ids);
				unset($liked_by[$key]);
				$liked_by_str = json_encode($liked_by);
				$query = "update likes set following = '$liked_by_str' where type = '$type' && url_id = '$connect_userid' limit 1";
				$DB->save($query);

			}
		}
		else
		{
			$arr['userid'] = $id;  
			$arr['date'] = date("Y-m-d H:i:s");
			//appending
			$arr2[] = $arr;
			$following = json_encode($arr2);
			$query = "insert into likes (type, url_id, following) values ('$type', '$connect_userid', '$following')";
			$DB->save($query);
		}
	}
}