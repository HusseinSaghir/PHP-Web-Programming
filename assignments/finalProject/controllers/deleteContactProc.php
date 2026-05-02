<?php
require_once(dirname(__DIR__) . '/classes/Pdo_methods.php');

$message = '';
$contacts = [];

$pdo = new PdoMethods();

// Handle delete submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idsToDelete = $_POST['delete'] ?? [];

    if (!empty($idsToDelete)) {
        foreach ($idsToDelete as $id) {
            $sql = "DELETE FROM contacts WHERE id = :id";
            $bindings = [
                [':id', $id, 'int']
            ];
            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'error') {
                $message = '<p class="text-danger">Could not delete the contacts</p>';
                break;
            }
        }
        if (empty($message)) {
            $message = '<p class="text-success">Contact(s) deleted</p>';
        }
    }
}

// Always fetch current records to display
$sql    = "SELECT * FROM contacts";
$contacts = $pdo->selectNotBinded($sql);

if ($contacts === 'error') {
    $contacts = [];
    $message  = '<p class="text-danger">Could not retrieve contacts</p>';
}
?>