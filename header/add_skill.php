<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

$add_skill_err = "";
if($_SERVER["REQUEST_METHOD"] == "POST") {
	$skill_name = $_POST['SkillName'];

	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	if(!$connection) {
		echo"Database Connection Error...".mysqli_connect_error();
	} else {
		$sql="Insert INTO $database.Skills(skill) VALUES ('$skill_name')";
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table Skills".mysqli_error($connection);
		}else{
			header('location: http://localhost/taskboard/header/settings.php');
		}
		
        mysqli_close($connection);
	}
}
?>
<!-- Add Task Modal -->
<div class="modal fade" id="AddSkill" tabindex="-1" role="dialog" aria-labelledby="AddSkillLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="AddSkillLabel" style="font-size: 20px;">Add Skill Dialog</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
	  <form method="post" class="SkillForm" action="add_skill.php" novalidate>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<span style="display: inline-block; width: 10em; text-align: left;"> <i class="fa fa-list"></i> Skill name</span>
					</span>
					<input type="text" class="form-control" name="SkillName" placeholder="Skill name" required>
				</div>
			</div>
			<div id="add_task_error" style="width: 100%; margin-top: .25rem; margin-bottom: .25rem; font-size: 80%; color: #dc3545;"></div>
			<div class="form-group">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				<button type="submit" class="btn btn-success">Add Skill</button>
			</div>
		</form>
      </div>
    </div>
  </div>
  </div>