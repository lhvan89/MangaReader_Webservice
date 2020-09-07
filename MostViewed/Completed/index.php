<?php include '../../header.php'; ?>
<?php include '../../base_response.php'; ?>

<?php

$sql = <<<EOT
SELECT *
FROM manga m
WHERE m.status = "Completed"
EOT;

$result = $conn->query($sql);

$data = (array) null;

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $item = new stdClass();

    $item->id       = (int)$row["id"];
    $item->title    = $row["title"];
    $item->status   = $row["status"] == "Ongoing" ? $row["latest_chapter"] : $row["status"];
    $item->thumbnail = $row["url_image"];

    $data[] = $item;
  }
  $response->Result = $data;
  echo json_encode($response);
} else {
  echo "0 results";
}
?>

<?php include '../../footer.php'; ?>