<!--Asa Jacob, Steve Tointon
	COEN 178
	Final Project
	This page accepts a new machine for the database-->

<!-- Will take input from the user regarding the machine-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Customer Bill</title>

</head>
<h1> Please enter the following information to view your bill</h1>
<body>
     <form method="post" action="showStatus.php">
        <fieldset>
			


            <!--text field inputs-->
            <legend style="">Order Information:</legend>

			<!--radio button inputs-->
            <legend style ="">Search Method:
            <input type="radio" name="searchMethod" id="searchMethod" value="phoneNo">
            <label for="searchMethod">Phone Number: </label>

			<input type="radio" name="searchMethod" id="searchMethod" value="machineId">
            <label for="searchMethod">machineId: </label>

            <label for="searchVal"> </label>
            <input type="text" name ="searchVal" id = "searchVal">

            
        </fieldset>
		<input type="submit" value="Submit">
        <input type="reset" value="Reset">
		<form>
				<input type="button" value="Home" onclick="window.location.href='finalUI.html'" />
		</form>
<?php

    if($_SERVER["REQUEST_METHOD"] =="POST"){
         
        
        
        //get the phone number
        $searchMethod = $_POST['searchMethod'];
        $searchVal = $_POST['searchVal'];

		if (!empty($searchVal)){
			$searchVal = prepareInput($searchVal);		
     	} 
     	

		//calling function to find the status based on the phone number
		//into customers table

        viewcustomerbill($searchMethod, $searchVal);

    }

	function prepareInput($inputData){
	
		$inputData = trim($inputData);
  		$inputData  = htmlspecialchars($inputData);
  		return $inputData;
	}
	
    
    function viewcustomerbill($searchMethod, $searchVal)
    {
        $conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu/db11g');
		if(!$conn) {
	     	print "<br> connection failed:";       
        	exit;
			}		
		//need to make a count and crate a new cust id for each new customer inserted  
		if ($searchMethod == "machineId")           
		{
			$query = oci_parse($conn, 'select status from customerBill where machineId = :input');	
		}
		else
		{ 
    		$query = oci_parse($conn, 'select status from (Select * FROM customerBill where phoneNo = :input)');	    	
		}

		oci_bind_by_name($query, ':input', $searchVal); 

	
		// Execute the query
		$res = oci_execute($query);
		while (($row = oci_fetch_array($query, OCI_BOTH)) != false) {
		// to fill out all customers information 
			//asa do this part 
		echo "<font color='green'> $row[2]  </font></br>";
		}
		OCILogoff($conn);	

		
    }
?>
</html>
