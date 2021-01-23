<?php

	include "../db_connection.php";
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	require 'C:/Users/LORENA/vendor/phpmailer/phpmailer/src/Exception.php';
	require 'C:/Users/LORENA/vendor/phpmailer/phpmailer/src/PHPMailer.php';
	require 'C:/Users/LORENA/vendor/phpmailer/phpmailer/src/SMTP.php';

	$register_err = "";
	if($_SERVER["REQUEST_METHOD"] == "POST") {
		session_start();
		$first_name = $_POST['First_Name'];
		$last_name = $_POST['Last_Name'];
		$password = $_POST['Password'];
		$email= $_POST['Email'];
		$work_hours = $_POST['WorkingHours'];
		$role= "Operator";
		$team= $_POST['Team'];

		$work_hours_id = 0;
		$team_name_id = 0;

		$connection = mysqli_connect($db_hostname, $db_username, $db_password);
		if(!$connection) {
			echo"Database Connection Error...".mysqli_connect_error();
		} else {
			$sql="SELECT * FROM Taskboard.WorkingHours WHERE hour='$work_hours'";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo"Error access in table WorkingHours".mysqli_error($connection);
			}
			if (mysqli_num_rows($retval) == 1) {
				while($row = mysqli_fetch_assoc($retval)) {
					$work_hours_id=$row["id"];
				}
			}
			$sql="SELECT * FROM Taskboard.Teams WHERE team='$team_name'";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo"Error access in table Teams".mysqli_error($connection);
			}
			if (mysqli_num_rows($retval) == 1) {
				while($row = mysqli_fetch_assoc($retval)) {
					$team_name_id=$row["id"];
				}
			}
			$sql = "SELECT * FROM Taskboard.TeamMembers";
			$retval = mysqli_query($connection, $sql);
			if($retval){
				if(mysqli_num_rows($retval) == 0){
					//nu exista user inregistrat in BD
					//primul user va fi mereu admin
					$role = 'Admin';
				}
			}

			$sql= "SELECT * FROM Taskboard.TeamMembers WHERE email= '$email'";
			$retval= mysqli_query($connection, $sql);
			if(! $retval ) {
				echo"Error access in table TeamMembers2: ".mysqli_error($connection);
			}
			
			if (mysqli_num_rows($retval) == 0) {
				$sql= "INSERT INTO Taskboard.TeamMembers (first_name,last_name,email,email_confirmed,password,work_hours,role,team) ".
				"VALUES ('$first_name','$last_name','$email',false,'$password',$work_hours_id,'$role',$team_name_id)";
				$retval= mysqli_query($connection, $sql);
				if(!$retval ) {
					echo "Error access in table TeamMembers: ".mysqli_error($connection);
				} else {
					//send confirmation email
					$sql = "SELECT * FROM Taskboard.TeamMembers WHERE email= '$email'";
					$retval = mysqli_query($connection, $sql);
					$id = 0;
					if($retval){
						$user = mysqli_fetch_assoc($retval);
						$id = $user['id'];
					}

					$mail = new PHPMailer(true);
					try {
						//Server settings
						$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
						$mail->isSMTP();                                            // Send using SMTP
						$mail->Host       = "smtp.gmail.com";                   // Set the SMTP server to send through
						$mail->SMTPAuth   = true;                                   // Enable SMTP authentication
						$mail->SMTPSecure = "tls";
						$mail->Username   = "taskboard7@gmail.com";                    // SMTP username
						$mail->Password   = "aplicatie123456";                               // SMTP password
						//$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Enable TLS encryption; `PHPMailer::ENCRYPTION_SMTPS` encouraged
						$mail->Port       = 587;                                    // TCP port to connect to, use 465 for `PHPMailer::ENCRYPTION_SMTPS` above
					
						//Recipients
						$mail->setFrom('taskboard7@gmail.com', 'TaskBoard');
						$mail->addAddress($email, $first_name);     // Add a recipient
					
						// Content
						$mail->isHTML(true);                                  // Set email format to HTML
						$mail->Subject = 'TaskBoard confirm email ';
						$mail->Body    = '<p>Pentru a confirma email-ul, dati click pe link-ul urmator:</p>'.
							"<a href='http://localhost/taskboard/header/validare.php?id=$id'>Confirm email</a>";
					
					
						$mail->send();
						echo 'Message has been sent';
						header("location: http://localhost/taskboard/header/login.php");
					} catch (Exception $e) {
						echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
					}
					
				}
			} else {
				$register_err = "User already exists";
			}
		}
		mysqli_close($connection);
	}
?>
<!doctype html>
<html lang="en">
<head>
	<!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

	<link rel="stylesheet" type="text/css" href="register.css">
	<script type="text/javascript" src="register.js"></script>
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
</head>
<body>
<nav style="background: #f8f8f8" class="navbar navbar-default navbar-expand-xl navbar-light">
		<div class="navbar-header d-flex col">
			<a class="navbar-brand" href="#"><i class="fa fa-cube"></i>Task<b>Board</b></a>  		
			<button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle navbar-toggler ml-auto">
				<span class="navbar-toggler-icon"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
		</div>
</nav>
	<div class="signup-form">
		<form method="post" class="needs-validation" action="" novalidate>
		<h2 class="text-center">Sign Up</h2>
			<!-- First name -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="firstnamePrepend" style="display: inline-block; width: 3em;"><i class="fa fa-user"></i></span>
        			</div>
					<input type="text" class="form-control" name="First_Name" placeholder="First name..."
						id="username" aria-describedby="firstnamePrepend" minlength="3" required>
					<div class="valid-feedback">
        				Looks good!
      				</div>
					<div class="invalid-feedback">
        				The minimum length of First name must be 3!
      				</div>
				</div>
			</div>
			<!-- Last name -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="lastnamePrepend" style="display: inline-block; width: 3em;"><i class="fa fa-user"></i></span>
        			</div>
					<input type="text" class="form-control" name="Last_Name" placeholder="Last name..."
						id="username" aria-describedby="lastnamePrepend" minlength="3" required>
					<div class="valid-feedback">
        				Looks good!
      				</div>
					<div class="invalid-feedback">
        				The minimum length of Last name must be 3!
      				</div>
				</div>
			</div>
			<!-- Email address -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="emailPrepend" style="display: inline-block; width: 3em;"><i class="fa fa-user"></i></span>
        			</div>
					<input type="text" class="form-control" name="Email" placeholder="Email.."
						id="username" aria-describedby="emailPrepend" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,3}$" required>
					<div class="valid-feedback">
        				Looks good!
      				</div>
					<div class="invalid-feedback">
        				Please enter a proper email address!
      				</div>
				</div>
			</div>
			<!-- Password -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="passwordPrepend" style="display: inline-block; width: 3em;"><i class="fa fa-lock"></i></span>
        			</div>
					<input type="password" class="form-control" name="Password" placeholder="Password.."
						aria-describedby="passwordPrepend" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
					<div class="valid-feedback">
        				Looks good!
      				</div>
					<div class="invalid-feedback">
        				The password must contain at least a lowercase letter, a capital (uppercase) letter, a number, and minimum 8 characters!
      				</div>
				</div>
			</div>
			<!-- Confirm Password -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="confirmpasswordPrepend" style="display: inline-block; width: 3em;"><i class="fa fa-lock"></i></span>
        			</div>
					<input type="password" class="form-control" name="Confirm_Password" placeholder="Confirm password.."
						aria-describedby="confirmpasswordPrepend" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" required>
					<div class="valid-feedback">
        				Looks good!
      				</div>
					<div class="invalid-feedback">
        				The password must contain at least a lowercase letter, a capital (uppercase) letter, a number, and minimum 8 characters!
      				</div>
				</div>
			</div>
			<!-- Working Hours -->
			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="confirmpasswordPrepend" style="width: 9em;"><i class="fa fa-clock-o"> Working Hours</i></span>
        			</div>
					<select class="form-control" name="WorkingHours">
						<option>4h/day</option>
						<option>6h/day</option>
						<option>8h/day</option>
					</select>
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="teamPrepend" style="width: 9em;"><i class="fa fa-clock-o"> Teams</i></span>
        			</div>
					<select class="form-control" name="Team">
						<?php
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo"Database Connection Error...".mysqli_connect_error();
							} else {
								$sql="SELECT * FROM $database.Teams";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$id=$row["id"];
									$team_name=$row["team_name"];
									
									echo "<option>$team_name</option>";
								}
							}
						?>
					</select>
				</div>
			</div>
			
			<div class="form-group">
				<button type="submit" class="btn btn-primary login-btn btn-block">Sign Up</button>
			</div>
		</form>
		<p class="text-center text-muted small">Already have an account? <a href="http://localhost/Taskboard/header/login.php">Sign in here!</a></p>
	</div>

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
</body>
</html>
