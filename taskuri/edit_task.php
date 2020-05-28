<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	session_start();
	$id = "";
	$task_name = "";
	$skill = "";
	$skill_level = "";
	$duration = "";
	$assigned_to ="";
	$status ="";
	$role="";
	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	if (isset($_SESSION['user_id'])) {
		$userId = $_SESSION['user_id'];
		$sql = "SELECT * FROM $database.TeamMembers WHERE id = '$userId'";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error accessing table TeamMembers0: ".mysqli_error($connection);
		}
		while($row = mysqli_fetch_assoc($retval)) {
			$role= $row["role"];
			if($role == 'Admin'){
				$id = $_POST['EditTaskId'];
				$task_name = $_POST['EditTaskName'];
				$skill = $_POST['EditSkill'];
				$skill_level = $_POST['EditSkillLevel'];
				$duration = $_POST['EditDuration'];
				$assigned_to = $_POST['EditAssignedTo'];
				$status = $_POST['EditStatus'];
			}
			else {
				$id = $_POST['EditTaskId'];
				$duration = $_POST['EditDuration'];
				$status = $_POST['EditStatus'];
			}

		}
	}

	$skill_id = 0;
	$level_id = 0;
	$status_id = 0;

	if(!$connection) {
		echo "Database Connection Error...".mysqli_connect_error();
	} else {
		$sql="SELECT * FROM $database.TaskStatus WHERE task_status='$status'";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table TaskStatus".mysqli_error($connection);
		}
		if (mysqli_num_rows($retval) == 1) {
			while($row = mysqli_fetch_assoc($retval)) {
				$status_id = $row["id"];
			}
		}

		if ($role == 'Admin') {
			$sql="SELECT * FROM $database.Skills WHERE skill='$skill'";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo "Error access in table Skills".mysqli_error($connection);
			}
			if (mysqli_num_rows($retval) == 1) {
				while($row = mysqli_fetch_assoc($retval)) {
					$skill_id = $row["id"];
				}
			}
			$sql="SELECT * FROM $database.SkillLevel WHERE skill_level='$skill_level'";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo "Error access in table SkillLevel".mysqli_error($connection);
			}
			if (mysqli_num_rows($retval) == 1) {
				while($row = mysqli_fetch_assoc($retval)) {
					$level_id = $row["id"];
				}
			}
			$pieces = explode(" ", $assigned_to);
			$first_name = $pieces[0];
			$last_name = $pieces[1];
			$sql = "SELECT * FROM $database.TeamMembers WHERE first_name='$first_name' AND last_name='$last_name'";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo "Error access in table TeamMembers".mysqli_error($connection);
			}
			if (mysqli_num_rows($retval) == 1) {
				while($row = mysqli_fetch_assoc($retval)) {
					$user_id = $row["id"];
				}
			}
			$sql = "UPDATE Taskboard.Tasks SET task_name='$task_name',skill_required=$skill_id,level_required=$level_id,duration=$duration,".
					"task_status=$status_id,assigned_member=$user_id WHERE id=$id";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo"Error access in table TeamMembers".mysqli_error($connection);
			}
		} else {
			$sql = "UPDATE Taskboard.Tasks SET duration=$duration,task_status=$status_id WHERE id=$id";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo"Error access in table TeamMembers".mysqli_error($connection);
			}
		}
        mysqli_close($connection);
	}
}
?>

<!-- Edit Task Modal -->
<div class="modal fade" id="EditTask" tabindex="-1" role="dialog" aria-labelledby="EditTaskLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditTaskLabel" style="font-size: 20px;">Edit Task Dialog</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form method="post" class="TaskForm" action="edit_task.php" novalidate>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Task name</span>
					</span>
					<?php
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo "Database Connection Error...".mysqli_connect_error();
							} else {
							
							if (isset($_SESSION['user_id'])) {
								$userId = $_SESSION['user_id'];
								$sql = "SELECT * FROM $database.TeamMembers WHERE id = '$userId'";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$role=$row["role"];
									
									if($role == 'Operator'){
									echo "<input type=\"text\" id=\"edit-task-name\" class=\"form-control\" name=\"EditTaskName\" placeholder=\"Task name\" required disabled>";
									}else{
									echo "<input type=\"text\" id=\"edit-task-name\" class=\"form-control\" name=\"EditTaskName\" placeholder=\"Task name\" required>";
									}
								}
								mysqli_close($connection);
							}
							}
						?>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-cogs"></i> Skill</span>
					</span>
					<?php
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo "Database Connection Error...".mysqli_connect_error();
							} else {
							
							if (isset($_SESSION['user_id'])) {
								$userId = $_SESSION['user_id'];
								$sql = "SELECT * FROM $database.TeamMembers WHERE id = '$userId'";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$role=$row["role"];
									
									if($role == 'Operator'){
									echo "<select id=\"edit-skill\" class=\"form-control\" name=\"EditSkill\" disabled>";
									}else{
										echo "<select id=\"edit-skill\" class=\"form-control\" name=\"EditSkill\">";
									}
								}
								mysqli_close($connection);
							}
							}
						?>
						<option>C</option>
						<option>C++</option>
						<option>Java</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-arrow-up"></i> Skill Level</span>
					</span>
					<?php
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo "Database Connection Error...".mysqli_connect_error();
							} else {
							
							if (isset($_SESSION['user_id'])) {
								$userId = $_SESSION['user_id'];
								$sql = "SELECT * FROM $database.TeamMembers WHERE id = '$userId'";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$role=$row["role"];
									
									if($role == 'Operator'){
									echo "<select id=\"edit-level\" class=\"form-control\" name=\"EditSkillLevel\" disabled>";
									}else{
										echo "<select id=\"edit-level\" class=\"form-control\" name=\"EditSkillLevel\">";
									}
								}
								mysqli_close($connection);
							}
							}
						?>
					
						<option>Level 1</option>
						<option>Level 2</option>
						<option>Level 3</option>
						<option>Level 4</option>
						<option>Level 5</option>
						<option>Level 6</option>
						<option>Level 7</option>
						<option>Level 8</option>
						<option>Level 9</option>
						<option>Level 10</option>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-clock-o"></i> Duration</span>
					</span>
					<input type="number" id="edit-duration" class="form-control" name="EditDuration" placeholder="Duration" min="0" max="1000" required>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-user"></i> Assigned To</span>
					</span>
					<?php
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo "Database Connection Error...".mysqli_connect_error();
							} else {
							
							if (isset($_SESSION['user_id'])) {
								$userId = $_SESSION['user_id'];
								$sql = "SELECT * FROM $database.TeamMembers WHERE id = '$userId'";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$role=$row["role"];
									
									if($role == 'Operator'){
									echo "<select id=\"edit-assigned-to\" class=\"form-control\" name=\"EditAssignedTo\" onclick=\"changed();\" disabled>";
									}else{
										echo "<select id=\"edit-assigned-to\" class=\"form-control\" name=\"EditAssignedTo\" onclick=\"changed();\">";
									}
								}
								mysqli_close($connection);
							}
							}
						?>
					
						<?php
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo "Database Connection Error...".mysqli_connect_error();
							} else {
								$sql="SELECT * FROM $database.TeamMembers";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$first_name=$row["first_name"];
									$last_name=$row["last_name"];
									$role=$row["role"];
									if($role == 'Operator')
									echo "<option>$first_name $last_name</option>";
								}
								mysqli_close($connection);
							}
						?>
					</select>
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-check"></i> Status</span>
					</span>
					<select id="edit-status" class="form-control" name="EditStatus">
						<option>Todo</option>
						<option>In progress</option>
						<option>Done</option>
					</select>
				</div>
			</div>
			<input style="visibility: hidden;" type="number" name="EditTaskId" id="edit-task-id">
			<div class="form-group">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Edit Task</button>
			</div>
		</form>
      </div>
    </div>
  </div>
  </div>