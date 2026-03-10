<?php 

require_once 'classes/Directories.php';

$directories = new Directories();
$message = '';
$isSuccess = false;
$filePath = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $dirName = trim($_POST['dir_name'] ?? '');
    $content 

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
