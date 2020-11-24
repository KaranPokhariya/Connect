<!DOCTYPE html>
<html>
<head>
	<title>Connect | Settings</title>
</head>

<body>

	<div style="overflow: auto; width: 100%; margin-top: 20px; background-color: white; text-align: center;">
		
		<div style="padding: 20px; max-width: 350px; display: inline-block;">

			<form method="post">
				<br>	
				<?php
					$settings_class = new Settings();
					$settings = $settings_class->get_settings($_SESSION['connect_userid']);
					if(is_array($settings))
					{
						echo "<span style='color: #25274d'>First Name</span>
							<input type='text' id='textbox' name='first_name' placeholder='First name' value='". htmlspecialchars($settings['first_name']) ."' />";
						echo "<span style='color: #25274d'>Last Name</span>
							<input type='text' id='textbox' name='last_name' placeholder='Last name' value='". htmlspecialchars($settings['last_name']) ."' />";

						echo "<span style='color: #25274d'>Gender</span>
							<select id='textbox' name='gender' style='height:30px;'>
							<option>". htmlspecialchars($settings['gender']) ."</option>
							<option>Male</option>
							<option>Female</option>
						</select>";

						echo "<span style='color: #25274d'>Email Address</span>
							<input type='email' id='textbox' name='email' placeholder='Email' value='". htmlspecialchars($settings['email']) ."' />";
						echo "<span style='color: #25274d'>Password</span>
							<input type='password' id='textbox' name='password' placeholder='Password' value='". htmlspecialchars($settings['password']) ."' />";
						echo "<span style='color: #25274d'>Retype Password</span>
							<input type='password' id='textbox' name='password2' placeholder='Retype-password' value='". htmlspecialchars($settings['password']) ."' />";
						
						echo "<br>About me:<br>
							<textarea id='textbox' name='about'style='height: 200px;'>$settings[about]</textarea>";

						echo '<input id="post_button" type="submit" value="Save Changes" style="width: auto; padding: 10px;">';
					}
				?>
			</form>	
		</div>
	</div>

</body>
</html>