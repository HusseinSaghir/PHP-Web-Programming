<?php

require_once "classes/Date_time.php";
$dt = new Date_time();
$notes = $dt->checkSubmit(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Add Note</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">

    <h1>Add Note</h1>
    <a href="display_notes.php">Display Notes</a>

    <br><br>

    <!-- One spot for all messages -->
    <?= $notes ?>

    <form method="post" action="index.php">

        <div class="mb-3">
            <label for="dataTime">Date and Time</label>
            <input type="datetime-local" class="form-control"
                   id="dataTime" name="dateTime">
        </div>

        <div class="mb-3">
            <label for="note">Note</label>
            <textarea class="form-control" id="note"
                      name="note" rows="10"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Add Note</button>

    </form>
</div>
</body>
</html>