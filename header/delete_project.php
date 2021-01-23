<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['ProjectId'];
    $sql="DELETE FROM $database.Projects WHERE id='$id'";
	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	if(!$connection) {
		echo "Database Connection Error: ".mysqli_connect_error();
	} else {
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table Projects".mysqli_error($connection);
		} else{
            header('location: http://localhost/taskboard/header/settings.php');

        }
        mysqli_close($connection);
	}
}
?>
<!-- Delete Project Modal -->
<div class="modal fade" id="DeleteProject" tabindex="-1" role="dialog" aria-labelledby="DeleteProjectLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="DeleteProjectLabel" style="font-size: 20px;">Delete Project Dialog</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" class="TaskForm" action="delete_project.php" novalidate>
				<p id="project-name"></p>
					<input style="visibility: hidden;" type="number" name="ProjectId" id="ProjectIdInput">
					<div class="form-group">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>