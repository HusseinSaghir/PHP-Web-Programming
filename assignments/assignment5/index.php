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
    $isSuccess = $directories->$isSuccess();

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
        <title>Assignment 5 - Directory Creator</title>

        <link 
            href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"
            rel="stylesheet">
        <style>
            body {
                background-color: #f0f4f8;
            }
            .card {
                border: none;
                border-radius: 12px;
                box-shadow: 0 4px 16px tgba(0,0,0,0.1);
            }
            .card-header {
                background-color: #343a40;
                color: #fff;
                border-radius: 12px 12px 0 0 !important;
            }
            .btn.primary {
                background-color: #343a40;
                border-color: #23272b;
            }
            .btn-primary:hover {
                background-color: #23272b;
                border-color: #23272b;
            }
            </style> 
        </head>
        <body>
            <div class= "container py-5">
                <div class= "row justify-content-center">
                    <div class= "col-md-7">

                    <?php if($isSuccess && $filePath !== ''): ?>
                        <div class= "alert alert-success mb-4" role= "alert">

                        <a href="<?= htmlspecialchars($filePath) ?>" target="_blank">
                            Path where the file is located
                    </a>
                      </div>
                         <?php endif; ?>

                         <?php if (!$isSuccess && $message !== ''): ?>
                            <div class= "alert alert-danger mb-4" role="alert"> 
                                <?= htmlsoecialchars($message) ?>
                         </div>
                         <?php endif; ?>

                         <div class="card">
                            <div class= "card-header py-3">
                                <h4 class="mb-0">Create a Directory &amp; File</h4>
                         </div>
                         <div class ="card-body p-4"> 
                            <form-method="post" action="index.php">

                            <div class = "mb-3">
                            <label for= "dir_name" class= "form-label fw-semibold">
                                    Directory Name
                                    <<small class="text-muted fw-normal">(alphabetic characters only)</small>
                            </label>
                            <input
                                type="text"
                                class="form-control"
                                id="dir_name"
                                name="dir_name"
                                placeholder="e.g. myFolder" 
                                pattern="[A_Za-z]+"
                                required>
                         </div>

                         <div class="mb-4">
                            <label for="file_content" class="form-label fw-semibold">
                                File content<small class="text-muted fw-normal">(written to readme.txt)</small>
                         </label>
                         <textarea
                            class="form-control"
                            id="file_content"
                            name="file_content"
                            rows="6"
                            placeholder="Enter the text tou want inside readme.txt"
                            required></textarea>
                         </div>

                         <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">
                                submit
                            </button>
                         </div>

                          </form>
                         </div>
                         </div>
                         </div>
                         </div>
                         </div>
                         
                         <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




                    
                            



