<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

$add_skill_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
    $userid=$_POST['UserId'];
    $skill_name = $_POST['SkillName'];
    $skill_level =$_POST['SkillLevel'];

	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	if(!$connection) {
		echo"Database Connection Error...".mysqli_connect_error();
	} else {
        $sql="SELECT * FROM $database.Skills WHERE skill='$skill_name'";
        $retval = mysqli_query( $connection, $sql );
        if(! $retval ) {
			echo "Error access in table Skills".mysqli_error($connection);
		}
        $skill_id=mysqli_fetch_assoc($retval)["id"];
        $sql="SELECT * FROM $database.SkillLevel WHERE skill_level='$skill_level'";
        $retval = mysqli_query( $connection, $sql );
        if(! $retval ) {
			echo "Error access in table SkillLevel".mysqli_error($connection);
		}
        $skill_level_id=mysqli_fetch_assoc($retval)["id"];
        echo "userid:$userid";
        echo "skill_id=$skill_id";
        echo "skill_level:$skill_level_id";
		$sql="Insert INTO $database.UserSkills(userid,skill_id,skill_level) VALUES ($userid,$skill_id,$skill_level_id)";
        $retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table UserSkills".mysqli_error($connection);
		}else{
			header('location: http://localhost/taskboard/header/settings.php');
		}
		
        mysqli_close($connection);
	}
}
?>
<!-- Add user skill Modal -->
<div class="modal fade" id="AddUserSkill" tabindex="-1" role="dialog" aria-labelledby="AddUserSkillLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddUserSkillLabel" style="font-size: 20px;">Add User Skill Dialog</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form method="post" class="UserSkillForm" action="add_user_skills.php" novalidate>
      <div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-cogs"></i> User Skill</span>
					</span>
					<select class="form-control" id="add_user_skill" name="SkillName">
					<?php
							$connection = mysqli_connect($db_hostname, $db_username, $db_password);
							if(!$connection) {
								echo "Database Connection Error...".mysqli_connect_error();
							} else {
								$sql="SELECT * FROM $database.Skills";
								$retval = mysqli_query( $connection, $sql );
								while($row = mysqli_fetch_assoc($retval)) {
									$skill_name=$row["skill"];
									echo "<option>$skill_name</option>";
								}
								mysqli_close($connection);
							}
						?>
					</select>
				</div>
			</div>
            <div class="form-group">
				<div class="input-group">
					<div class="input-group-prepend">
          				<span class="input-group-text" id="confirmpasswordPrepend" style="width: 9em;"><i class="fa fa-clock-o"> Skill Level</i></span>
        			</div>
					<select class="form-control" name="SkillLevel">
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
            <input style="visibility: hidden;" type="number" name="UserId" id="AddUserIdInput">
			<div id="add_user_skill_error" style="width: 100%; margin-top: .25rem; margin-bottom: .25rem; font-size: 80%; color: #dc3545;"></div>
			<div class="form-group">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Add Skill</button>
            </div>
            
		</form>
      </div>
    </div>
  </div>
  </div>