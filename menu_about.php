<!DOCTYPE html>
<html>
<head>
	<title>Connect | About</title>
</head>

<style>
	#aboutme{
		max-width: 450px;
		padding: 10px;
		outline-style: dotted;
		outline-width: 4px;
		outline-color: grey;
		overflow: auto;
		text-align: center;
		margin-top: 20px;
	}

</style>

<body>

	<div style="overflow: auto; width: 100%; margin-top: 20px; background-color: white; text-align: center;">
		<div style="padding: 20px; display: inline-block;">
			<h1 style="text-align: center; font-size: 18px; color: #25274d; font-style: tahoma;">About me</h1>
			<?php
				$DB = new Database();
				$query = "select about from users where userid = '$_GET[id]'";
				$about = $DB->read($query);
				//print_r($about);
				//die;
				if($about[0]['about'])
				{	
					echo "<div id=aboutme>";
					echo $about[0]['about'];
					echo "</div>";
				}
				else
				{
					echo "<span style='color: red;'>Nothing to display</span>";
				}

			?>
		</div>
	</div>

</body>
</html>