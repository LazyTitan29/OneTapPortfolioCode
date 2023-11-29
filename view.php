<?php
include 'db_connect.php';

if(isset($_GET['id']) && !empty($_GET['id'])) {
  $qry = $conn->query("SELECT * FROM files where id=".$_GET['id'])->fetch_array();

  $file = "assets/uploads/".$qry['file_path'];
  $fileType = $qry['file_type'];
  $filename = $qry['name'].'.'.$qry['file_type'];
  $fileSize = filesize($file);

  // Set the appropriate Content-Type and Content-Disposition headers
  switch($fileType) {
    case 'pdf':
      header('Content-Type: application/pdf');
      break;
    case 'jpg':
      header('Content-Type: image/jpeg');
      break;
    case 'png':
      header('Content-Type: image/png');
      break;
    case 'gif':
      header('Content-Type: image/gif');
      break;
    default:
      // Set a default Content-Type if the file type is not recognized
      header('Content-Type: application/octet-stream');
      header("Content-Disposition: inline; filename=".$filename);
      break;
  }
  header("Content-Length: ".$fileSize);
  readfile($file);
} else {
  // Return an error or redirect to a different page
}

exit;

$conn->close();
?>