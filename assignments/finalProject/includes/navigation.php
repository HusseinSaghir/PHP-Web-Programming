<?php
function renderNav() {
    if (!isset($_SESSION['user_id'])) {
        return '';
    }

    $nav = '
    <nav class="mb-4">
        <a href="index.php?page=addContact" class="me-3">Add Contact</a>
        <a href="index.php?page=deleteContacts" class="me-3">Delete Contact(s)</a>';

    if ($_SESSION['status'] === 'admin') {
        $nav .= '
        <a href="index.php?page=addAdmin" class="me-3">Add Admin</a>
        <a href="index.php?page=deleteAdmins" class="me-3">Delete Admin(s)</a>';
    }

    $nav .= '
        <a href="logout.php">Logout</a>
    </nav>';

    return $nav;
}
?>