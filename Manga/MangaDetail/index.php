<?php include '../../header.php'; ?>
<?php include '../../base_response.php'; ?>

<?php

class Manga {
  public $id;
  public $title;
}

// Get List Author
$sql = <<<EOT
SELECT a.name
FROM author a, manga_author ma
WHERE ma.author_id = a.id AND ma.manga_id = 1
EOT;
$result = $conn->query($sql);
$listAuthor = (array) null;
if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $listAuthor[] = $row["name"];
  }
  
}

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