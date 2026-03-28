<?php require_once 'php/fileUploadProc.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>File Upload</title>
</head>
<body>

<h1>File Upload</h1>
<a href="listFiles.php">Show File List</a>

<!-- enctype="multipart/form-data" is REQUIRED for file uploads -->
<form action="index.php" method="post" enctype="multipart/form-data">
    <p>File Name</p>
    <p><input type="text" name="fileName"></p>
    <p><input type="file" name="uploadFile"></p>
    <p><button type="submit">Upload File</button></p>
</form>

<p><?php echo $output; ?></p>

</body>
</html>