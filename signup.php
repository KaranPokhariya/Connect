<?php

    //print_r($_POST);
	include("classes/connect_database.php");
	include("classes/signup_class.php");
	
	$first_name = "";
	$last_name = "";
	$gender = "Select Gender";
	$email = "";

	//print_r($_SERVER);

	if($_SERVER['REQUEST_METHOD'] == "POST")
	{
        /*echo "<pre>";
        print_r($_POST);
        echo "</pre>";*/
		$signup = new Signup();
		$result = $signup->evaluate($_POST);

		if($result != "")
		{
			echo "<div style='text-align: center; font-size: 14px; color: white; background-color: #25274d;'>";
			echo "<br>Following errors occured:<br><br>";
			echo $result;
			echo "</div>";
		}

		else
		{
			/*information that website sends to the server and vice versa and tells various things like what is the content, where to redirect, etc*/
			header("Location: login.php");
			die;
		}

		$first_name = $_POST['first_name'];
		$last_name = $_POST['last_name'];
		$gender = $_POST['gender'];
		$email = $_POST['email'];
	}
?>

<html>
<head>
    <title>Connect | Signup</title>
    <link rel="stylesheet" href="css/signup.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>
    <div id="bar">
        <div style="font-size: 40px;">Connect</div>
        <a href="login.php" style="text-decoration: none; color: #c5c6c7;">
            <div id="login_button">Log In</div>
        </a>
    </div>

    <div class="signup-box">
	    <form method="post" action="#" id="form">
            <h1>Create your account</h1>

            <i class="fa fa-user"></i>
	        <input value="<?php echo $first_name ?>" name="first_name" type="text" id="fist_name" placeholder="Enter First Name">
            <br>

            <i class="fa fa-user"></i>
	        <input value="<?php echo $last_name ?>" name="last_name" type="text" id="last_name" placeholder="Enter Last Name">
            <br><br>
	        
	        <select id="gender" class="gender-select" name="gender">
                
	            <option><?php echo "$gender" ?></option>
	            <option>Male</option>
	            <option>Female</option>
	        </select>
            <br><br>

            <i class="fa fa-envelope"></i>
	        <input value="<?php echo $email ?>" name="email" type="text" id="email" placeholder="Enter Email Address">
            <br>

            <i class="fa fa-key"></i>
	        <input name="password" type="password" id="password" placeholder="Enter Password">
            <br>

            <i class="fa fa-key"></i>
	        <input name="password2" type="password" id="password2" placeholder="Confirm Password">
            <br>

	        <input type="submit" id="button" value="Sign Up">
        </form>
    </div>

</body>
</html>
