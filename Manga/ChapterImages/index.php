<?php include '../../header.php'; ?>
<?php include '../../base_response.php'; ?>

<?php

$id = $_GET['id'];

$sql = <<<EOT
SELECT *
FROM image
WHERE chapter_id = $id
EOT;

$result = $conn->query($sql);

$data = (array) null;

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $item = new stdClass();

    $item->id         = (int)$row["id"];
    $item->chapterId  = $row["chapter_id"];
    $item->urlImage   = $row["url_image"];

    $data[] = $item;
  }

  $response->Result = $data;
  echo json_encode($response);

} else {
  echo "0 results";
}
?>

<?php include '../../footer.php'; ?>