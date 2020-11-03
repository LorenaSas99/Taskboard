<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="header.css">
	<script type="text/javascript" src="header.js"></script>
	<link href="https://fonts.googleapis.com/css?family=Merienda+One" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
</head>
<body>
	<nav class="navbar navbar-default navbar-expand-xl navbar-light">
		<div class="navbar-header d-flex col">
			<a class="navbar-brand" href="#"><i class="fa fa-cube"></i>Task<b>Board</b></a>  		
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
				<span class="navbar-toggler-icon"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
		<!-- Collection of nav links, forms, and other content for toggling -->
		<div id="navbarCollapse" class="collapse navbar-collapse justify-content-start">
			<ul class="nav navbar-nav navbar-right ml-auto">
				<li><a href="" class="dropdown-item" onclick="logout()"><i class="fa fa-power-off"></i> Logout</a></li>
				<?php
					include '../db_connection.php';
					session_start();
					if (isset($_SESSION['user_id'])) {
						$userId=$_SESSION['user_id'];
						$sql= "SELECT * FROM $database.TeamMembers WHERE id='$userId'";
						$connection = mysqli_connect($db_hostname, $db_username, $db_password);
						if(!$connection) {
							echo "Database Connection Error...".mysqli_connect_error();
						} else{
							$retval = mysqli_query( $connection, $sql );
							if($retval){
								$user =mysqli_fetch_assoc($retval);
								$role = $user['role'];
								if($role == 'Admin'){
									echo '<li><a href="" class="dropdown-item" onclick="GoToSettings()"><i class="fa fa-cog"></i> Settings</a></li>';
								}
							}
						}
					}
				?>
				
			</ul>
		</div>
	</nav>
</body>
</html>
