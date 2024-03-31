<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image'])) {
  $file = $_FILES['image'];

  // Check for errors
  if ($file['error'] === UPLOAD_ERR_OK) {
    // Move the uploaded file to a desired location
    move_uploaded_file($file['tmp_name'], 'uploads/' . $file['name']);
    echo 'Image uploaded successfully';
  } else {
    echo 'Error uploading image';
  }
} else {
  echo 'Invalid request';
}
?>
