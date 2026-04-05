<?php
require_once 'classes/Date_time.php';
$dt    = new Date_time();
$notes = $dt->checkSubmit();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Display Notes</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">

    <h1>Display Notes</h1>
    <a href="index.php">Add Note</a>

    <br><br>

    <form method="post" action="display_notes.php">

        <div class="mb-3">
            <label for="begDate">Beginning Date</label>
            <input type="date" class="form-control"
                   id="begDate" name="begDate">
        </div>

        <div class="mb-3">
            <label for="endDate">Ending Date</label>
            <input type="date" class="form-control"
                   id="endDate" name="endDate">
        </div>

        <button type="submit" class="btn btn-primary">Get Notes</button>

    </form>

    <br>

    <!-- One spot for all messages and the results table -->
    <?= $notes ?>

</div>
</body>
</html>