<?php

    include("classes/connect_database.php");
    include("classes/login_class.php");

    $email = "";
    $password = "";

    //print_r($_SERVER);

    if($_SERVER['REQUEST_METHOD'] == "POST")
    {
        $login = new Login();
        $result = $login->validate($_POST);

        if($result != "")
        {
            echo "<div style='text-align: center; font-size: 14px; color: white; background-color: #25274d; padding: 4px;'>";
            //echo "<br>Following errors occured:<br><br>";
            echo $result;
            echo "</div>";
        }

        else
        {
            header("Location: index.php");
            die;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
    }
?>

<html>
<head>
    <title>Connect | Log In</title>
    <meta charset="utf-8">
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>

<body>  
    <div id="bar">
        <div style="font-size: 40px;">Connect</div>
        <a href="signup.php" style="text-decoration: none; color: #c5c6c7;">
            <div id="signup_button">Sign Up</div>
        </a>
    </div>

    <div class="login-box">
    	<img src="images/icons/login.png" class="avatar">
        <form method="post" action="">
            <h1>Log In with Connect</h1><br><br>

            <i class="fa fa-envelope"></i>
            <input value="<?php echo $email ?>" name="email" type="text" id="text" placeholder="Enter Username/Email">
            <br>

            <i class="fa fa-key"></i>
            <input name="password" type="password" id="text" placeholder="Enter Password"><br><br>

            <input type="submit" id="button" onclick="" value="Log In">
            <a href="#" class="forgot_password">Forgot Password?</a>
        </form>

    </div>

</body>
</html>
