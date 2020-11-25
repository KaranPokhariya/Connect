<?php

class Profile
{
	public function get_profile($id)
	{
		//addslashes - variable escaping - special charaters becomes part of the string
		$id = addslashes($id);
		$query = "select * from users where userid = $id limit 1";

		$DB = new Database;
		return $DB->read($query);
	}
}