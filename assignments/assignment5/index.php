<?php 

require_once 'classes/Directories.php';

$directories = new Directories();
$message = '';
$isSuccess = false;
$filePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dirName = trim($_POST['dir_name'] ?? '');
    $content = $_POST['file_content'] ?? '';

    $directories->createDirectory($dirName, $content);

    $message = $directories->getMessage();
    $isSuccess = $directories->isSuccess();

    if ($isSuccess) {
        $filePath = $directories->getFilePath();
    } 
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>File and Directory Assignment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
 
    <h1>File and Directory Assignment</h1>
    <p>Enter a folder name and the contents of a file. Folder names should contain alpha numeric characters only.</p>
 
    <?php if (!$isSuccess && $message !== ''): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>
 
    <?php if ($isSuccess && $filePath !== ''): ?>
        <p>File and directory where created</p>
        <p><a href="<?= htmlspecialchars($filePath) ?>">Path where file is located</a></p>
    <?php endif; ?>
 
    <form method="post" action="index.php">
 
        <div class="mb-3">
            <label for="dir_name" class="form-label">Folder Name</label>
            <input
                type="text"
                class="form-control"
                id="dir_name"
                name="dir_name"
                required>
        </div>
 
        <div class="mb-3">
            <label for="file_content" class="form-label">File Content</label>
            <textarea
                class="form-control"
                id="file_content"
                name="file_content"
                rows="6"
                required></textarea>
        </div>
 
        <button type="submit" class="btn btn-primary">Submit</button>
 
    </form>
 
</div>
 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




                    
                            



