<?php

class Signup
{
	private $error = "";
	
	//checks if the values provided are apt or not
	public function evaluate($data)
	{
		foreach ($data as $key => $value)
		{
			if(empty($value))
			{
				$this->error = $this->error . $key . " is empty!<br>";
			}

			if($key == "email")
			{
				//in built php function to validate an email address
				if(!filter_var($value, FILTER_VALIDATE_EMAIL))
				{
					$this->error = $this->error . "Invalid email!<br>";
				}
			}

			if($key == "first_name")
			{
				if(is_numeric($value))
				{
					$this->error = $this->error . "First Name cannot be a number<br>";
				}
				if(strstr($value, " "))
				{
					$this->error = $this->error . "First Name cannot have space<br>";
				}

			}

			if($key == "last_name")
			{
				if(is_numeric($value))
				{
					$this->error = $this->error . "First Name cannot be a number<br>";
				}
				if(strstr($value, " "))
				{
					$this->error = $this->error . "Last Name cannot have space<br>";
				}
			}
		}
		if($this->error == "")
		{
			//no error
			$this->create_user($data);
		}
		else
			return $this->error;
	}

	private function hash_text($text)
	{
		$text = hash("sha1", $text);
		return $text;
	}

	public function create_user($data)
	{
		if($data['password'] != $data['password2'])
		{
			$this->error .= "Password does not match";
			return $this->error;
		}
		else
		{
			$first_name = ucfirst($data['first_name']);
			$last_name = ucfirst($data['last_name']);
			$gender = $data['gender'];
			$email = $data['email'];
			$password = $data['password'];

			$password = $this->hash_text($password);

			//to be created by the php
			$url_address = strtolower($first_name) . "." . strtolower($last_name);
			$userid = $this->create_userid();

			$query = "insert into users (userid, first_name, last_name, gender, email, password, url_address) values ('$userid', '$first_name', '$last_name', '$gender', '$email', '$password', '$url_address')";

			$DB = new Database();
			$DB->save($query);
		}
	}

	private function create_userid()
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
}