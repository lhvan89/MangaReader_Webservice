<?php include '../../header.php'; ?>
<?php include '../../base_response.php'; ?>

<?php

$sql = <<<EOT
SELECT m.id, m.title, m.url_image, m.status, c.title AS latest_chapter, c.update_date
FROM chapter c INNER JOIN(
    SELECT MAX(id) id, manga_id
    FROM chapter
    GROUP BY manga_id) j ON c.id = j.id AND c.manga_id = j.manga_id 
    
    INNER JOIN manga m
    ON m.id = c.manga_id  
ORDER BY c.update_date DESC
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