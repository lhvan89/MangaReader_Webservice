<?php include '../../header.php'; ?>
<?php include '../../base_response.php'; ?>

<?php

class Manga {
  public $Id;
  public $Title;
}

$id = $_GET['id'];

// Get List Author
$sql = <<<EOT
SELECT a.name
FROM author a, manga_author ma
WHERE ma.author_id = a.id AND ma.manga_id = $id
ORDER BY a.name  ASC
EOT;
$result = $conn->query($sql);
$listAuthor = (array)null;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $listAuthor[] = $row["name"];
  }
}

// Get List Genere
$sql = <<<EOT
SELECT g.title
FROM genre g, manga_genre mg
WHERE mg.genre_id = g.id AND mg.manga_id = $id 
ORDER BY g.title  ASC
EOT;
$result = $conn->query($sql);
$listGenere = (array)null;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $listGenere[] = $row["title"];
  }
}

// Get List Chapter
$sql = <<<EOT
SELECT *
FROM chapter c
WHERE manga_id = $id
ORDER BY title DESC
EOT;
$result = $conn->query($sql);
$listChapter = (array)null;
if ($result->num_rows > 0) {
  while($row = $result->fetch_assoc()) {
    $item = new stdClass();
    $item->Id = (int)$row["id"];
    $item->Title = $row["title"];
    $item->View = $row["view"];
    $item->Update_date = $row["update_date"];
    $listChapter[] = $item;
  }
}

//
$sql = <<<EOT
SELECT *
FROM manga m
WHERE m.id = $id
EOT;

$result = $conn->query($sql);

$data = new stdClass;

if ($result->num_rows > 0) {
  // output data of each row
  while($row = $result->fetch_assoc()) {
    $item = new stdClass();

    $item->Id         = (int)$row["id"];
    $item->Title      = $row["title"];
    $item->Status     = $row["status"];
    $item->Thumbnail  = $row["url_image"];
    $item->Authors    = implode(", ",$listAuthor);
    $item->Generes    = implode(" - ",$listGenere);
    $item->Description = $row["description"];
    $item->Chapters   = $listChapter;
    $data = $item;

  }
  $response->Result = $data;
  echo json_encode($response);
} else {
  echo "0 results";
}
?>

<?php include '../../footer.php'; ?>