<?php

class Settings
{
	public function get_settings($id)
	{
		$DB = new Database();
		$query = "select * from users where userid = $id limit 1";
		$row = $DB->read($query);

		if(is_array($row))
		{
			return $row[0];
		}
	}


	public function save_settings($data, $id)
	{
		$DB = new Database();
		$password = $data['password'];
		if(strlen($password) < 30)
		{
			if($data['password'] == $data['password2'])
			{
				$data['password'] = hash("sha1", $password); 
			}
			else
			{
				unset($data['password']);
			}
		}
		unset($data['password2']);

		$query = "update users set ";
		foreach ($data as $key => $value)
		{
			$query .= $key . "='" . $value ."',";
		}
		$query = trim($query, ",");
		$query .= "where userid = '$id' limit 1";

		$DB->save($query); 

	}

}