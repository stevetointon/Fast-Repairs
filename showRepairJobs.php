<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="utf-8"/>
    <title> Show Repair Jobs</title>
    </head>

    <body>

    <?php
        $conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu/db11g');
        if(!$conn){
            print "<br> connection failed:";
            exit;
        }
        // $query = oci_parse($conn, 'select * from customers natural join repairItems');

        // //Execute the query
        // oci_execute($query);

        // while (($row = oci_fetch_array($query, OCI_BOTH)) != false) 
        // {
  
        //     // We can use either numeric indexed starting at 0
        //     // or the column name as an associative array index to access the colum value
        //      // Use the uppercase column names for the associative array indices
        //     echo "Machine Id: <font color='green'>$row[2]</font></br>";
        //     echo "Customer Name: <font color='green'> $row[1] </font></br>";
        //     echo "Phone Number: <font color='green'> $row[0] </font></br>";
        //     echo "Model: <font color='green'> $row[3] </font></br>";
        //     echo "Price: <font color='green'> $row[4] </font></br>";
        //     echo "Year: <font color='green'> $row[5] </font></br>";
        //     echo "TimeIn: <font color='green'> $row[6] </font></br>";
        //     echo "Service Contract: <font color='green'> $row[7] </font></br>";
        //     echo "Repair Type: <font color='green'> $row[8] </font></br>";
        // }
        $query = oci_parse($conn, 'select * from customers natural join repairItems');
  //$query2 = oci_parse($conn, 'select status from repairJob');

  oci_execute($query);
  //oci_execute($query2);

  
  //TODO: add contractId if item has a contract
  while (($row = oci_fetch_array($query, OCI_BOTH)) != false) 
  {
      //$out = oci_fetch_array($query2, OCI_BOTH);
      //$status = $out[0];
  
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
      //echo "Status: <font color='green'> $status </font></br></br>";
  }

        OCILogoff($conn);
    ?>
    </body>
</html>     
