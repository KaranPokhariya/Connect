<?php

/*a session is a way to store information (in variables) to be used across multiple pages.
Lets say, we are logging in Google. Server at Google is going to register my browser as the user and then it is going to assign a session to me to my particular browser to access Google, it's still going to know that it's me.
Suppose, after logging in I browsed something else on different page. And then, when I'll come back to Google, I'll not have to login again. Google is going to know that it's still me.
This way we maintain information between page
*/

if (session_status() == PHP_SESSION_NONE) {
  session_start();
}

class Login
{
	private $error = "";

	private function hash_text($text)
	{
		$text = hash("sha1", $text);
		return $text;
	}
	
	public function validate($data)
	{
		$email = addslashes($data['email']);
		$password = addslashes($data['password']);

		//limiting it to one response. return the first fetched value
		$query = "select * from users where email = '$email' limit 1";

		$DB = new Database();
		$result = $DB->read($query);

		//print_r($result);

		if($result)
		{
			$row = $result[0];

			if($this->hash_text($password) == $row['password'])
			{
				//create session data - associative array of information
				$_SESSION['connect_userid'] = $row['userid'];		
			}
			else
			{
				$this->error .= "Invalid credentials<br>";
			}
		}
		else
		{
			$this->error .= "Invalid credentials<br>";
		}
		return $this->error;
	}

	public function check_login($id)
	{
		if(is_numeric($id))
	    {	
			$query = "select * from users where userid = $id limit 1";

			$DB = new Database();
			$result = $DB->read($query);

			if($result)
			{
				$user_data = $result[0];
				return $user_data;
			}else
		    {
		    	header("Location: login.php");
		    	die;
		    }
		}else
		{
		    header("Location: login.php");
		    die;
		}
	}
}