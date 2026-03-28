<?php

require_once __DIR__ . '/../classes/Pdo_methods.php';

$output = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

//Grabs display name
$fileName = $_POST['fileName'];

$fileSize = $_FILES['uploadFile']['size']; //Size in bytes
$fileMime = $_FILES['uploadFile']['type']; //Make sure its PDF
$fileTmp  = $_FILES['uploadFile']['tmp_name']; //Where PHP temporarily stored the file
$fileOriginalName = basename($_FILES['uploadFile']['name']); //The original filename


//Validations Sections \0/

if($fileSize >= 100000) {
    $output = '<p style="color:red;">Error: File must be under 100,000 bytes. Womp Womp!</p>';
} elseif ($fileMime !== 'application/pdf') {
    $output = '<p style="color:red;">Error: File must be a PDF. No JPG Allowed >:) </p>';
} else {

    //If Valid
    $destination = __DIR__ . '/../files/' . $fileOriginalName;

    move_uploaded_file($fileTmp, $destination);

    $filePath = 'files/' . $fileOriginalName;

    $pdo = new PdoMethods();

    $sql = "INSERT INTO files (file_name, file_path) VALUES (:fileName, :filePath)";

    // Format: [ placeholder, value, type ]
     $bindings = [
            [':fileName', $fileName,  'str'],
            [':filePath', $filePath,  'str']
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if($result == 'noerror') {
            $output = '<p style="color:green;">File "' . htmlspecialchars($fileName) . '" uploaded successfully!</p>';
        } else {
            $output = '<p style="color:red;">Error saving to database.</p>';
        }
     }
  }
?>