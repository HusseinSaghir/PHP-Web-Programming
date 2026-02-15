<?php //<--- php type


//Creates for loops
$evenNumbers = "Even Numbers: ";
foreach (range(1, 50) as $num) {
    if ($num % 2 == 0) {
        $evenNumbers .= $num . " - ";
    }
}
// Removes the trailing  -  sign from the last number
$evenNumbers = rtrim($evenNumbers, " - ");
$evenNumbers .= "<br><br>";

//Create form using heredoc & Bootstrap styling
$form = <<<FORM
<div class="mb-3">
    <label for="emailAddress" class="form-label">Email address</label>
    <input type="email" class="form-control" id="emailAddress" placeholder="name@example.com">
</div>
<div class="mb-3">
    <label for="exampleTextarea" class="form-label">Example text area</label>
    <textarea class="form-control" id="exampleTextarea" rows="3"></textarea>
</div>

FORM;

// Create table function & Nested loop
function createTable($rows, $columns) {
    $table = '<table class="table table-bordered">';
    for ($i = 1; $i <= $rows; $i++) {
        $table .= '<tr>';
        for ($j = 1; $j <= $columns; $j++) {
            $table .= '<td>Row ' . $i . ', Col ' . $j . '</td>';
        } //^^^^ td cell
        $table .= '</tr>';
    }
    $table .= '</table>';
    return $table;
}
//Below closing php
?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loops&Tables</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container">
    <?php
        echo $evenNumbers;
        echo $form;
        echo createTable(8, 6);
    ?>
</body>
</html>