<?php
$db_hostname="127.0.0.1:3306";
$db_username="root";
$db_password="";
$database="taskboard";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['TeamId'];
    $sql="DELETE FROM $database.Teams WHERE id='$id'";
	$connection = mysqli_connect($db_hostname, $db_username, $db_password);
	if(!$connection) {
		echo "Database Connection Error: ".mysqli_connect_error();
	} else {
		$retval = mysqli_query( $connection, $sql );
		if(! $retval ) {
			echo "Error access in table Teams".mysqli_error($connection);
		} else{
            header('location: http://localhost/taskboard/header/settings.php');

        }
        mysqli_close($connection);
	}
}
?>
<!-- Delete Team Modal -->
<div class="modal fade" id="DeleteTeam" tabindex="-1" role="dialog" aria-labelledby="DeleteTeamLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="DeleteTeamLabel" style="font-size: 20px;">Delete Team Dialog</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form method="post" class="TaskForm" action="delete_team.php" novalidate>
				<p id="team-name"></p>
					<input style="visibility: hidden;" type="number" name="TeamId" id="TeamIdInput">
					<div class="form-group">
						<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						<button type="submit" class="btn btn-success">Yes</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>