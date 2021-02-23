<?php
    include "../db_connection.php";


    function logger2($logMsg="logger", $filename="logger", $logData=""){     
		$log  = date("j.n.Y h:i:s")." || $logMsg : ".print_r($logData,1).PHP_EOL .                  
		"-------------------------".PHP_EOL;
		file_put_contents('./'.$filename.date("j.n.Y").'.log', $log, FILE_APPEND);                      
    }
    
    class User{

    }

    $connection = mysqli_connect($db_hostname, $db_username, $db_password);
    if(!$connection) {
        logger2(" user - Database Connection Error: ".mysqli_connect_error());
    } else {
        $sql="SELECT * FROM $database.TeamMembers";
        $retval = mysqli_query( $connection, $sql );
        if(! $retval){
            logger2("user - Error in access table TeamMembers: ".mysqli_error($connection));
        }
        $users = [];
        $skill = array();
        
        while($row = mysqli_fetch_assoc($retval)) {
            $first_name = $row["first_name"];
            $last_name = $row["last_name"];
            $work_hours = $row["work_hours"];
            $id = $row["id"];

            $sql = "SELECT * FROM $database.UserSkills WHERE userid=$id";
            $retval1 = mysqli_query( $connection, $sql );
            if(! $retval1){
                logger2("user - Error in access table UserSkills: ".mysqli_error($connection));
            }
            $skill_id = 0;
            $skill_level_id = 0;
            while($row1 = mysqli_fetch_assoc($retval1)){
                $skill_id = $row1["skill_id"];
                $skill_level_id = $row1['skill_level'];
            }

            $sql="SELECT * FROM $database.Skills WHERE id=$skill_id";
            $retval1 = mysqli_query( $connection, $sql );
            if(! $retval1){
                logger2("user - Error in access table Skills: ".mysqli_error($connection));
            }
            
            while($row1 = mysqli_fetch_assoc($retval1)){
                array_push($skill, $row1["skill"]);
            }

            $sql = "SELECT * FROM $database.SkillLevel WHERE id=$skill_level_id";
            $retval1 = mysqli_query( $connection, $sql );
            if(! $retval1){
                logger2("user - Error in access table SkillLevel: ".mysqli_error($connection));
            }
            $skill_level="";
            while($row1 = mysqli_fetch_assoc($retval1)){
                $skill_level = $row1["skill_level"];
            }

            $sql = "SELECT * FROM $database.WorkingHours WHERE id=$work_hours";
            $retval1 = mysqli_query( $connection, $sql );
            if(! $retval1){
                logger2("user - Error in access table WorkingHours: ".mysqli_error($connection));
            }
            $hours = "";
            while($row1 = mysqli_fetch_assoc($retval1)){
                $hours = $row1["hour"];
            }

            $user = new User;
            $user->first_name = $first_name;
            $user->last_name = $last_name;
            $user->skill = $skill;
            $user->level = $skill_level;
            array_push($users, $user);
        }
        mysqli_close($connection);

        $usersJSON = json_encode($users);
        echo $usersJSON;
    }
?>