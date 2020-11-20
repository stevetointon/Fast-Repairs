<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset ="utf-8"/>
        <title> Show Revenue</title>
</head>

<body>

<?php
    $conn=oci_connect('ajacob','Craigtheclaw97','//dbserver.engr.scu.edu/db11g');
    if(!$conn){
        print "<br> connection failed:";
        exit;
    }
    $query = oci_parse($conn, 'select sum(amountCharged) AS Total from customerBill');

    //Execute the query
    oci_execute($query);
    if(($row = oci_fetch_array($query, OCI_BOTH)) != false)
        echo "<font color='Black'> No revenue generated at this point. </font></br>";
    else        
        echo "Total revenue generated: <font:color = 'black'> $row['Total'] </font></br>";
    //echo "Total Revenue: <font color='Black'>$row['sum(amountcharged)']"</font></br>";
    OCILogoff($conn);
?>

</body>
</html>
