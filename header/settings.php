<html>
<head>
	<meta charset="utf-8"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="settings.css">
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto|Varela+Round|Open+Sans">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Merienda+One" rel="stylesheet">
	<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
	
</head>
<body>
	<div class="container" style="padding: 0;">
	<ul class="nav nav-tabs">
  		<li class="nav-item">
		  <a class="nav-link active" data-toggle="tab" href="#User-Manager">Users</a></li>
  		<li class="nav-item">
		  <a class="nav-link" data-toggle="tab" href="#Skill-Manager">Skills</a></li>
	</ul>
	<div class="tab-content">
  		<div id="User-Manager" class="tab-pane container active">
    		<div class="table-wrapper">
				<div class="table-title">
					<div class="row">
						<div class="col-sm-8"><h2><b>Users Management</b></h2></div>

					</div>
				</div>
				<table class="table table-bordered">
					<thead>
						<tr>
							<th style="width: 3em;">#</th>
							<th style="width: 10em;">First Name</th>
							<th style="width: 10em;">Last Name</th>
							<th style="width: 15em;">Email</th>
							<th style="width: 15em;">Skills</th>
							<th style="width: 6em;">Work Hours</th>
							<th style="width: 6em;">Role</th>
							<th style="width: 9em;">Actions</th>	
						</tr>
					</thead>
                	<tbody>
						<?php
							include "../db_connection.php";
							include "./edit_user.php";
							include "./delete_user.php";
							include "./add_user_skills.php";
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo"Database Connection Error...".mysqli_connect_error();
							} else {
								$sql="SELECT * FROM $database.TeamMembers";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$id=$row["id"];
									$first_name=$row["first_name"];
									$last_name=$row["last_name"];
									$email=$row["email"];
									$work_hours=$row["work_hours"];
									$role=$row["role"];
										
										$sql3="SELECT * FROM $database.WorkingHours WHERE id=' $work_hours'";
										$retval2 = mysqli_query( $connection, $sql3 );
										if(! $retval2 ) {
											echo "Error accessing table WorkingHours: ".mysqli_error($connection);
										}
										$row= mysqli_fetch_assoc($retval2);
										$work_hours=$row["hour"];

										echo "<tr>".
										"<td>$id</td>".
										"<td>$first_name</td>".
										"<td>$last_name</td>".
										"<td>$email</td>";
										$sql="SELECT * FROM $database.UserSkills WHERE userid= '$id'";
										$retval3=mysqli_query($connection,$sql);
										if(! $retval3 ) {
											echo "Error accessing table UserSkills: ".mysqli_error($connection);
										}
										echo "<td> <select>";
										while($row = mysqli_fetch_assoc($retval3)){
											$skill_id=$row["skill_id"];
											$skill_level=$row["skill_level"];
											$sql4="SELECT * FROM $database.Skills WHERE id='$skill_id'";
											$retval4=mysqli_query($connection,$sql4);
											$skill_name=mysqli_fetch_assoc($retval4)["skill"];
											$sql5="SELECT * FROM $database.SkillLevel WHERE id='$skill_level'";
											$retval5=mysqli_query($connection,$sql5);
											$skill_level_name=mysqli_fetch_assoc($retval5)["skill_level"];
											echo "<option> $skill_name - $skill_level_name </option>";

										}
										echo "</select> </td>";


										echo "<td>$work_hours</td>".
										"<td>$role</td>".
										"<td>".
										"<a class=\"edit\" title=\"Edit\" data-toggle=\"modal\" data-target=\"#EditUser\" ".
										"data-skill-id=\"$id\" data-first-name=\"$first_name\" data-last-name=\"$last_name\" data-work-hours=\"$work_hours\" data-role=\"$role\">".
										"<i class=\"material-icons\">&#xE254;</i></a>".
										"<a class=\"delete\" title=\"Delete\" data-toggle=\"modal\" data-target=\"#DeleteUser\" ".
										"data-user-id=\"$id\" data-user-name=\"$first_name $last_name\"><i class=\"material-icons\">&#xE872;</i></a>".
										"<a  title=\"Add\" data-toggle=\"modal\" data-target=\"#AddUserSkill\" ".
										"data-user-id=\"$id\"><i class=\"fa fa-plus\"></i></a>".
										"</td>".
										"</tr>" ;


								}
							}
						?>
					</tbody>
				</table>
			</div>
  		</div>
  		<div id="Skill-Manager" class="tab-pane container fade">
    		<div class="table-wrapper">
            <div class="table-title">
                <div class="row">
                    <div class="col-sm-8"><h2><b>Skills Management</b></h2></div>
                    <div class="col-sm-4">
					<button type="button" class="btn btn-info add-new" data-toggle="modal" 
					data-target="#AddSkill"><i class="fa fa-plus"></i> Add Skill</button></div>
                </div>
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
						<th style="width: 3em;">#</th>
                        <th style="width: 10em;">Skill Name</th>
						<th style="width: 6em;">Actions</th>
                        
                    </tr>
                </thead>
                <tbody>
				<?php
					include "./edit_skill.php";
					include "./add_skill.php";
					include "./delete_skill.php";
					$connection = mysqli_connect($db_hostname, $db_username, $db_password);
					if(!$connection) {
						echo"Database Connection Error...".mysqli_connect_error();
					} else {
						$sql="SELECT * FROM $database.Skills";
						$retval = mysqli_query( $connection, $sql );
						while($row = mysqli_fetch_assoc($retval)) {
							$id = $row["id"];
							$skill_name=$row["skill"];
							$role="";
							if (isset($_SESSION['user_id'])) {
								$userId = $_SESSION['user_id'];
								$sql = "SELECT * FROM $database.TeamMembers WHERE id = '$userId'";
								$retval2 = mysqli_query( $connection, $sql );
								if(! $retval2 ) {
									echo "Error accessing table TeamMembers: ".mysqli_error($connection);
								}
								while($row = mysqli_fetch_assoc($retval2)) {
									$role= $row["role"];
								}
								}
							//if($role == 'Admin'){
							echo "<tr>".
								"<td>$id</td>".
								"<td><b>$skill_name</b></td>".
								"<td>".
								"<a class=\"edit\" title=\"Edit\" data-toggle=\"modal\" data-target=\"#EditSkill\" ".
								"data-skill-id=\"$id\" data-skill-name=\"$skill_name\"><i class=\"material-icons\">&#xE254;</i></a>".
								"<a class=\"delete\" title=\"Delete\" data-toggle=\"modal\" data-target=\"#DeleteSkill\" ".
								"data-skill-id=\"$id\" data-skill-name=\"$skill_name\"><i class=\"material-icons\">&#xE872;</i></a>";
			
							"</td>".
							"</tr>" ;
						//}
						}

					}
					mysqli_close($connection);
				?>
                </tbody>
            </table>
        	</div>
    		</div>
  		</div>
	</div>
	

	<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
	<script type="text/javascript" src="settings.js"></script>
</body>
</html>
