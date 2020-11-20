<!--Asa Jacob, Steve Tointon
	COEN 178
	Final Project
	This page accepts a new machine for the database-->

<!-- Will take input from the user regarding the machine-->

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8"/>
	<title>Enter Customer Info</title>

</head>
<h1> Please enter the following information to complete the order form:</h1>
<body>
     <form method="post" action="acceptMachine.php">
        <fieldset>

            <!--text field inputs-->
            <legend style="">Customer Information:</legend>

            <label for="name"> Customer Name:</label>
            <input type="text" name ="name" id = "name">
                
            <label for="phoneNo">Phone Number:</label>
            <input type="text" name="phoneNo" id="phoneNo">

            <!--radio button inputs-->
            <legend style ="">Service Contract:
            <input type="radio" name="serviceContractType" id="serviceContractType" value="none">
            <label for="serviceContractType">None</label>

            <input type="radio" name="serviceContractType" id="serviceContractType" value="single">
            <label for="serviceContractType">Single</label>
        
        
            <input type="radio" name="serviceContractType" id="serviceContractType" value="group">
            <label for="serviceContractType">Group</label>
        </fieldset>
        <!--Gets info about the item for repair-->
        <fieldset>
            <legend style = "">Item Information</legend>

            <label for="itemId"> Item Id: </label>
            <input type="number" name="itemId": min="1" step="1" max="300" value="1" id = "itemId">
			
			<!--radio button inputs-->
            <legend style ="">Type of Item:
            <input type="radio" name="itemType" id="none" value="none">
            <label for="itemType">Computer</label>

            <input type="radio" name="itemType" id="single" value="single">
            <label for="itemType">Printer</label><br>

            <!--text input-->
            <label for="modelNo"> Model:</label>
            <input type="text" name ="modelNo" id = "modelNo">

            <!--number input for price-->
            <label for="price"> Price: </label>
           $<input type="number" name="price" min="0.0" step="1" max="3000.00" value="100.00" id = "price">


            <!--drop down menu to get year-->
           <select name="year">
               <option value="2018">2018</option> 
               <option value="2017">2017</option> 
               <option value="2016">2016</option> 
               <option value="2015">2015</option> 
               <option value="2014">2014</option> 
               <option value="2013">2013</option> 
               <option value="2012">2012</option> 
               <option value="2011">2011</option> 
               <option value="2010">2010</option> 
               <option value="2009">2009</option> 
               <option value="2008">2008</option> 
               <option value="2007">2007</option> 
               <option value="2006">2006</option> 
               <option value="2005">2005</option> 
               <option value="2004">2004</option> 
               <option value="2003">2003</option> 
               <option value="2002">2002</option> 
               <option value="2001">2001</option> 
               <option value="2000">2000</option> 
               <option value="1999">1999</option> 
               <option value="1998">1998</option> 
               <option value="1997">1997</option> 
               <option value="1996">1996</option> 
               <option value="1995">1995</option> 
               <option value="1994">1994</option> 
               <option value="1993">1993</option> 
               <option value="1992">1992</option> 
               <option value="1991">1991</option> 
               <option value="1990">1990</option> 
            </select>
        </fieldset>
		<input type="submit" value="Submit">
        <input type="reset" value="Reset">
</form>

<?php
    if($_SERVER["REQUEST_METHOD"] =="POST"){
         
        //get the customer name  

        $name = $_POST['name']; 
        
        //get the phone number
        $phoneNo = $_POST['phoneNo'];

		if (!empty($name)){
			$name = prepareInput($name);		
     	} 
     	if (!empty($phoneNo)){
			$phoneNo = prepareInput($phoneNo);	
		}

        //get the service contract type
        $serviceContractType = $_POST['serviceContractType'];
        
		//get the item type
		$itemType = $_POST['itemType'];

		//get the item ID
		$itemId = $_POST['itemId'];
		
        //get model number
        $model = $_POST['modelNo'];

		 if (!empty($model)){
			$model = prepareInput($model);		
     	} 	

        //get the price
        $price = $_POST['price'];
        
        //get the year 
        $year = $_POST['year'];

		//calling function to insert name and phoneno
		//into customers table

        insertCustIntoDB($name, $phoneNo);

		//calling function to insert 
		//into customers table

        insertMachineIntoDB($itemId, $itemType, $model, $price, $year);

    }

	function prepareInput($inputData){
	
		$inputData = trim($inputData);
  		$inputData  = htmlspecialchars($inputData);
  		return $inputData;
	}
	
    
    function insertCustIntoDB($name1, $phoneNo)
    {
        $conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu/db11g');
		if(!$conn) {
	     	print "<br> connection failed:";       
        	exit;
			}		
		//need to make a count and crate a new cust id for each new customer inserted 
		$query = oci_parse($conn, "Insert Into Customers(name, phoneNo) values(upper(:name),upper(:phoneNo)); commit;");	
	
		oci_bind_by_name($query, ':name', $name1);
		oci_bind_by_name($query, ':phoneNo', $phoneNo);
	
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
    function insertMachineIntoDB($itemId, $itemType, $model, $price, $year)
    {
		 $conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu/db11g');
		 if(!$conn) {
	     	print "<br> connection failed:";       
        	exit;
			}	
	
		//need to make a count and crate a new item id for each new machine inserted 
		$query = oci_parse($conn, "Insert Into RepairItems(itemId,itemType,model, price, year) values(:itemId, upper(:model),:itemType, :price,:year");	
	  

    	oci_bind_by_name($query, ':itemId', $itemId);
		oci_bind_by_name($query, ':itemType', $itemType);
		oci_bind_by_name($query, ':model', $model);
		oci_bind_by_name($query, ':price', $price);
		oci_bind_by_name($query, ':year', $year);
    }
?>
		<input type="button" value="Home" onclick="window.location.href='finalUI.html'" />
</body>
</html>
