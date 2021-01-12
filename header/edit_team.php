<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

if($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $id=$_POST["EditUserId"];
    $work_hours= $_POST['WorkingHours'];
    $role= $_POST['Role'];
    $connection = mysqli_connect($db_hostname, $db_username, $db_password);
    
	if(!$connection) {
		echo "Database Connection Error...".mysqli_connect_error();
	} else {
            $sql1 = "SELECT * from $database.WorkingHours WHERE hour='$work_hours'";
            $work_hours_id=0;
            $retval = mysqli_query( $connection, $sql1 );
            if(! $retval ) {
				echo"Error access in table WorkingHours".mysqli_error($connection);
			}else{
                $result = mysqli_fetch_assoc($retval);
                $work_hours_id=$result['id'];
            }

            $sql = "UPDATE Taskboard.TeamMembers SET work_hours=$work_hours_id,".
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