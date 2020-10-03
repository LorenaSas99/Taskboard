<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $id=$_POST["EditUserId"];
    $skill_name = $_POST['SkillName'];
    $skill_level= $_POST['SkillLevel'];
    $work_hours= $_POST['WorkingHours'];
    $role= $_POST['Role'];
    $connection = mysqli_connect($db_hostname, $db_username, $db_password);
    
	if(!$connection) {
		echo "Database Connection Error...".mysqli_connect_error();
	} else {
            $sql1 = "SELECT * from $database.Skills WHERE skill='$skill_name'";
            $skill_id=0;
            $retval = mysqli_query( $connection, $sql1 );
            if(! $retval ) {
				echo"Error access in table Skills".mysqli_error($connection);
			}else{
                $result = mysqli_fetch_assoc($retval);
                $skill_id=$result['id'];
            }
            $sql1 = "SELECT * from $database.SkillLevel WHERE skill_level='$skill_level'";
            $skill_level_id=0;
            $retval = mysqli_query( $connection, $sql1 );
            if(! $retval ) {
				echo"Error access in table SkillLevel".mysqli_error($connection);
			}else{
                $result = mysqli_fetch_assoc($retval);
                $skill_level_id=$result['id'];
            }
            $sql1 = "SELECT * from $database.WorkingHours WHERE hour='$work_hours'";
            $work_hours_id=0;
            $retval = mysqli_query( $connection, $sql1 );
            if(! $retval ) {
				echo"Error access in table WorkingHours".mysqli_error($connection);
			}else{
                $result = mysqli_fetch_assoc($retval);
                $work_hours_id=$result['id'];
            }

            $sql = "UPDATE Taskboard.TeamMembers SET skill=$skill_id, skill_level=$skill_level_id, work_hours=$work_hours_id,".
            "role='$role' WHERE id=$id";
			$retval = mysqli_query( $connection, $sql );
			if(! $retval ) {
				echo"Error access in table TeamMembers".mysqli_error($connection);
			}else{
                header('location: http://localhost/taskboard/header/settings.php');
            }
        mysqli_close($connection);
	}
}
?>

<!-- Edit User Modal -->
<div class="modal fade" id="EditUser" tabindex="-1" role="dialog" aria-labelledby="EditUserLabel" aria-hidden="true" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="EditUserLabel" style="font-size: 20px;">Edit User Dialog</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form method="post" class="TaskForm" action="edit_user.php" novalidate>
            <div class="form-group">
                <div class="input-group">
                    <span class="input-group-addon">
                        <span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> First Name</span>
                    </span>
                    <input type="text" id="edit-first-name" class="form-control" name="EditFirstName" placeholder="First Name" disabled>
                </div>
            </div>

            <div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Last Name</span>
					</span>
					<input type="text" id="edit-last-name" class="form-control" name="EditLastName" placeholder="Last Name" disabled>
				</div>
			</div>

			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Skill Name</span>
					</span>
					<select class="form-control" id="edit-skill-name" name="SkillName">
                        <?php
                        $sql="SELECT * FROM $database.Skills";
                        $connection = mysqli_connect($db_hostname, $db_username, $db_password);
	                    if(!$connection) {
		                    echo "Database Connection Error...".mysqli_connect_error();
	                    } else {
                            $retval = mysqli_query( $connection, $sql );
						    while($row = mysqli_fetch_assoc($retval)) {
                                $skill=$row["skill"];
                                echo "<option>$skill</option>";
                            }
                        }
                        ?>
					</select>
				</div>
			</div>

            <div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Skill Level</span>
					</span>
					<select class="form-control" id="edit-skill-level" name="SkillLevel">
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
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Work Hours</span>
					</span>
					<select class="form-control" id="edit-work-hours" name="WorkingHours">
						<option>4h/day</option>
						<option>6h/day</option>
						<option>8h/day</option>
					</select>
				</div>
			</div>

            <div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Role</span>
					</span>
					<select class="form-control" id="edit-role" name="Role">
						<option>Operator</option>
						<option>Admin</option>
					</select>
				</div>
			</div>
			<input style="visibility: hidden;" type="number" name="EditUserId" id="edit-user-id">
			<div class="form-group">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Edit User</button>
			</div>
		</form>
      </div>
    </div>
  </div>
  </div>