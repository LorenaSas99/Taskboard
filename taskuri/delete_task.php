<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";
//logger("fa ceva");
if($_SERVER["REQUEST_METHOD"] == "POST") {
	//logger("POST");
    $id = $_POST['TaskId'];
    $sql="DELETE FROM $database.Tasks WHERE id='$id'";
	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	echo "delete task: $id";
	if(!$connection) {
		echo "Database Connection Error: ".mysqli_connect_error();
	} else {
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			
			echo "Error access in table Tasks".mysqli_error($connection);
		}
		else{
			echo"Task deleted";
		}
        mysqli_close($connection);
	}
}
?>
<!-- Delete Task Modal -->
<div class="modal fade" id="DeleteTask" tabindex="-1" role="dialog" aria-labelledby="DeleteTaskLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="DeleteTaskLabel" style="font-size: 20px;">Delete Task Dialog</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" class="TaskForm" action="delete_task.php" novalidate>
					<span id="task-name"></span>
					<input style="visibility: hidden;" type="number" name="TaskId" id="TaskIdInput">
					<div class="form-group">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>