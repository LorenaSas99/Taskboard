<html>
<head>
	<title>TaskBoard</title>
	<?php
		session_start();
		include 'db_connection.php';
		initializeDatabase();
		if (!isset($_SESSION['user_id'])) {
			header("location: http://localhost/taskboard/header/login.php");
		}
		
	?>
</head>
	<frameset rows="50px,*" border="0">
		<frame name="header" src="header/header.php"> </frame>
		<frame name="content" src="content.php"> </frame>
	</frameset>
</html>