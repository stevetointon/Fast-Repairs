<!--Asa Jacob, Steve Tointon
	COEN 178
	Final Project
	This page updates the status of the machine machine for the database-->

<!-- Will take input from the user regarding the machine-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Update Machine Info</title>

</head>
<h1> Please enter the following information to complete the order form:</h1>
<body>
     <form method="post" action="updateMachine.php">
        <fieldset>

            <!--text field inputs-->
            <legend style="">Machine Status:</legend>
            <label for="machineId"> Machine ID:</label>
            <input type="text" name ="machineId" id = "machineId">
            <br><br>

            <?php
            mysql_connect('hostname', 'username', 'password');
			mysql_select_db('database-name');

			$sql = "SELECT username FROM userregistraton";
			$result = mysql_query($sql);

			echo "<select name='username'>";
			while ($row = mysql_fetch_array($result)) {
   			 echo "<option value='" . $row['username'] ."'>" . $row['username'] ."</option>";
			}
			echo "</select>";
                
            ?>    
            <!--radio button inputs-->
            <legend style ="">Machine Status:</legend>
            <input type="radio" name="machineStatus" id="Ready" value="Ready">
            <label for="machineStatus">Ready</label>

            <input type="radio" name="machineStatus" id="In_progress" value="In_progress">
            <label for="machineStatus">In_Progress</label>
        
        
            <input type="radio" name="machineStatus" id="done" value="done">
            <label for="machineStatus">Done</label>
            <br><br>

            <label for="partsCost"> Cost of Parts: </label>
            $<input type="number" name="partsCost": min="0" step="1" max="3000" value="100" id = "partsCost"i>
        
            <label for="hours"> Hours: </label>
            <input type="number" name="hours": min="0.00" step="0.10" max="3000.00" value="0" id = "hours">
            <br><br> 
            
            <legend style="">Problem Codes:</legend>
            <input type="checkbox" name="problemId" id="HardwareFailure" value="HardwareFailure">
            <label for="HardwareFailure">Hardware Failure</label>
            <input type="checkbox" name="problemId" id="softwareFailure" value="softwareFailure" >
            <label for="softwareFailure">Software Failure</label>
            <input type="checkbox" name="problemId" id="inkLow" value="inkLow" >
            <label for="inkLow">Ink Low</label>
        
        </fieldset>
		<input type="submit" value="Submit">
        	<input type="reset" value="Reset">
		<form>
				<input type="button" value="Home" onclick="window.location.href='finalUI.html'" />
		</form>
<?php

    if($_SERVER["REQUEST_METHOD"] =="POST"){
         
        //get the machineId  
        $machineId = $_POST['machineId']; 

		if (!empty($machineId)){
			$machineId = prepareInput($machineID);	
        
		}
        //get the machine satus 
        $machineSatus = $_POST['machineSatus'];

		//get the cost of parts
		$partsCost = $_POST['partsCost'];

        //get the hours worked
        $hours = $_POST['hours'];
        
        //get problemIds 
        $problemId = array();
		
		foreach($_POST['problemId'] as $check){
			array_push($problemId, $check);
		}

		//calling fucntion to insert machineid, machine satus, partscost, hours

        updatemachine($machineId, $machineStatus, $partsCost, $hours);

		//calling function to insert 
		//into problems table

        insertproblemstable($machineId, $problemId);

    }

	function prepareInput($inputData){
	
		$inputData = trim($inputData);
  		$inputData  = htmlspecialchars($inputData);
  		return $inputData;
	}
	
    
    function updatemachine($machineId, $machineStatus, $partsCost, $hours)
    {
        $conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu');
		if(!$conn) {
	     	print "<br> connection failed:";       
        	exit;
			}		
		//need to make a count and crate a new cust id for each new customer inserted 
		$query = oci_parse($conn, " update repairJob
									set status = :machineStatus
									where machineId = :machineId");	
		$query2 = oci_parse($conn, "insert customerBill(")
	
		oci_bind_by_name($query, ':machineId', $machineId);
		oci_bind_by_name($query, ':machineStatus', $machineStatus);
		oci_bind_by_name($query, ':partsCost', $partsCost);
		oci_bind_by_name($query, ':hours', $hours);
	
		// Execute the query
		$res = oci_execute($query);
		if ($res)
			echo '<br><br> <p style="color:green;font-size:20px">Data successfully inserted</p>';
		else{
			$e = oci_error($query); 
        	echo $e['message']; 
		}
		OCILogoff($conn);	

		
    }
    function insertproblemstable($machineId, $problemId)
    {
		$conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu/db11g');
		if(!$conn) {
	     	print "<br> connection failed:";       
        	exit;
		}	
	
		$query = oci_parse($conn, "Insert Into Book_HighLights(machineId,problemId) values(upper(:machineID),:problemId)");
	
		// $problemID is an array containing all the values
		// selected from the multiple checkboxes
	
		foreach ( $problemID as $oneproblemId ) {
			oci_bind_by_name($query, ':machineId', $machineID);
			oci_bind_by_name($query, ':problemId', $oneproblemId);
			// Execute the query
			oci_execute($query);
    	}
		OCILogoff($conn);	
	}
?>

    </form>
</body>
</html>
