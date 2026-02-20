<?php
$output = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    require_once 'processNames.php';
    $output = addClearNames();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Names</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <h1 class="mt-4">Add Names</h1>
    
    <form method="post" action="">
        <button type="submit" name="addName" class="btn btn-primary mt-3">Add Name</button>
        <button type="submit" name="clearNames" class="btn btn-primary mt-3">Clear Names</button>
        
        <div class="mb-3 mt-3">
            <label for="enterName" class="form-label">Enter Name</label>
            <input type="text" class="form-control" id="enterName" name="enterName">
        </div>
        
        <div class="mb-3">
            <label for="namelist" class="form-label">List of Names</label>
            <textarea style="height: 500px;" class="form-control" id="namelist" name="namelist"><?php echo $output ?></textarea>
        </div>
    </form>
</body>
</html>