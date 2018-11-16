<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");



$servername = "localhost";
$username = "root";
$password = "51623030";
$dbname = "RAIT";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM tblUsers";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        //echo "id: " . $row["ID"]. " - Name: " . $row["strName"]. " " . $row["strEmail"]. "<br>";
        $strReturn = $row["strEmail"];
    }
} else {
    echo "0 results";
}
$conn->close();


for($i = 0; $i<100; $i++){

  //if($i >= 10000){
    $strReturn = $i;
  //  break;
  //}

}


echo json_encode($strReturn);


 ?>
