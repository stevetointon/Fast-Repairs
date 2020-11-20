<!--Asa Jacob, Steve Tointon
	COEN 178
	Final Project
	This page accepts a new machine for the database-->

<!-- Will take input from the user regarding the machine-->

<?php

    if($_SERVER["REQUEST_METHOD"] =="POST"){
         
        
        
        //get the phone number
        //$searchMethod = $_POST['searchMethod'];
        $machineId = $_POST['machineId'];

		//if (!empty($machineId)){
		//	$machineId = prepareInput($machineId);		
     	//} 
     	

		//calling function to find the status based on the phone number
		//into customers table

        querytoshowstatus($machineId);

    }

	function prepareInput($inputData){
	
		$inputData = trim($inputData);
  		$inputData  = htmlspecialchars($inputData);
  		return $inputData;
	}
	
    
    function querytoshowstatus( $machineId)
    {
        $conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu/db11g');
		if(!$conn) {
	     	print "<br> connection failed:";       
        	exit;
			}		

		//if ($searchMethod == "machineId")           
		//{
		//	$query = oci_parse($conn, 'select status from repairjob where machineId = :machineId');	
		//}
		//else
		//{ 
    	//	$query = oci_parse($conn, 'select status from (Select * FROM repairjob where phoneNo = :input)');	    	
		//}

		//oci_bind_by_name($query, ':machineId', $machineId); 

	
		// Execute the query
		//$res = oci_execute($query);
		//if (!$res){
		//	$e = oci_error($query); 
        //	echo $e['message']; 
		//}	
		//while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
    	// Use the uppercase column names for the associative array indices
		//	echo " Test: <font color='blue'>$row[0]</font>";
		//}
		//echo "hello";
		//$row = oci_fetch_array($query, OCI_BOTH);
		// We can use either numeric indexed starting at 0
		// or the column name as an associative array index to access the colum value
		// Use the uppercase column names for the associative array indices
		//echo "<font color='green'> $row[0]  </font></br>";
		//echo "<font color='green'> $row[1]  </font></br>";
		//echo "<font color='green'> $row[2]  </font></br>";
			$query = oci_parse($conn, 'select * from customers natural join repairItems');
  $query2 = oci_parse($conn, 'select status from repairJob');

  oci_execute($query);
  oci_execute($query2);

  
  //TODO: add contractId if item has a contract
  while (($row = oci_fetch_array($query, OCI_BOTH)) != false) 
  {
      $out = oci_fetch_array($query2, OCI_BOTH);
      $status = $out[0];
  
      // We can use either numeric indexed starting at 0
      // or the column name as an associative array index to access the colum value
      // Use the uppercase column names for the associative array indices
      echo "Machine Id: <font color='green'>$row[2]</font></br>";
      echo "Customer Name: <font color='green'> $row[1] </font></br>";
      echo "Phone Number: <font color='green'> $row[0] </font></br>";
      echo "Model: <font color='green'> $row[3] </font></br>";
      echo "Price: <font color='green'> $row[4] </font></br>";
      echo "Year: <font color='green'> $row[5] </font></br>";
      echo "TimeIn: <font color='green'> $row[6] </font></br>";
      echo "Service Contract: <font color='green'> $row[7] </font></br>";
      echo "Repair Type: <font color='green'> $row[8] </font></br>";
      echo "Status: <font color='green'> $status </font></br></br>";
  }

		
		OCILogoff($conn);	

		
    }
?>