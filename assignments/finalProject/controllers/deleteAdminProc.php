<?php
require_once(dirname(__DIR__) . '/classes/Pdo_methods.php');

$message = '';
$admins = [];

$pdo = new PdoMethods();

// Handle delete submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $idsToDelete = $_POST['delete'] ?? [];

    if (!empty($idsToDelete)) {
        foreach ($idsToDelete as $id) {
            $sql = "DELETE FROM admins WHERE id = :id";
            $bindings = [
                [':id', $id, 'int']
            ];
            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'error') {
                $message = '<p class="text-danger">Could not delete the admins</p>';
                break;
            }
        }
        if (empty($message)) {
            $message = '<p class="text-success">Admin(s) deleted</p>';
        }
    }
}

// Always fetch current records to display
$sql    = "SELECT * FROM admins";
$admins = $pdo->selectNotBinded($sql);

if ($admins === 'error') {
    $admins  = [];
    $message = '<p class="text-danger">Could not retrieve admins</p>';
}
?>