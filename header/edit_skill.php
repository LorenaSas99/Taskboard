<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

if($_SERVER["REQUEST_METHOD"] == "POST") {
	session_start();
	$id = "";
	$skill_name = "";
	$role="";
	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	if (isset($_SESSION['user_id'])) {
		$userId = $_SESSION['user_id'];
		$sql = "SELECT * FROM $database.TeamMembers WHERE id = '$userId'";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error accessing table TeamMembers: ".mysqli_error($connection);
		}
		while($row = mysqli_fetch_assoc($retval)) {
			$role= $row["role"];
			if($role == 'Admin'){
				$id = $_POST['EditSkillId'];
				$skill_name = $_POST['EditSkillName'];
			}

		}
	}

	if(!$connection) {
		echo "Database Connection Error...".mysqli_connect_error();
	} else {
		if ($role == 'Admin') {
			$sql = "UPDATE Taskboard.Skills SET skill='$skill_name' WHERE id=$id";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo"Error access in table Skills".mysqli_error($connection);
			}else{
                header('location: http://localhost/taskboard/header/settings.php');
            }
		}
        mysqli_close($connection);
	}
}
?>

<!-- Edit Skill Modal -->
<div class="modal fade" id="EditSkill" tabindex="-1" role="dialog" aria-labelledby="EditSkillLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditSkillLabel" style="font-size: 20px;">Edit Skill Dialog</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form method="post" class="TaskForm" action="edit_skill.php" novalidate>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Skill name</span>
					</span>
					<input type="text" id="edit-skill-name" class="form-control" name="EditSkillName" placeholder="Skill name" required>
				</div>
			</div>
			<input style="visibility: hidden;" type="number" name="EditSkillId" id="edit-skill-id">
			<div class="form-group">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Edit Skill</button>
			</div>
		</form>
      </div>
    </div>
  </div>
  </div>