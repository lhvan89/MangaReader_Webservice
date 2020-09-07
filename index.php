<?php include 'header.php'; ?>
<?php include 'base_response.php'; ?>

<?php

$sql = "SELECT * From manga";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    // echo "id: " . $row["id"]. " - Name: " . $row["firstname"]. " " . $row["lastname"]. "<br>";
    // echo $row["title"]; 
  }
  echo json_encode($response);
} else {
  echo "0 results";
}

?>

<?php include '../footer.php'; ?>