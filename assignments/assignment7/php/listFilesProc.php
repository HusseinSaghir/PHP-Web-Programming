<?php 

require_once __DIR__ . '/../classes/Pdo_methods.php';

$output = '';

$pdo = new PdoMethods();

$sql = "SELECT file_name, file_path FROM files";

$results = $pdo->selectNotBinded($sql);

//Check if any files exist in the database
if(empty($results)) {
    $output = '<p>No files have been uploaded yet.</p>';
} else {
    $output = '<ul>';

//Loop through each row returned from the database
foreach ($results as $row) {

$output .= '<li><a href="' . htmlspecialchars($row['file_path']) . '" target="_blank">' 
                        .htmlspecialchars($row['file_name'])
                        .'</a></li>';
}

$output .= '</ul>';
}

?>