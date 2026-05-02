<?php
function init() {
    global $admins, $message;

    require_once('includes/navigation.php');
    $nav = renderNav();

    if (empty($admins)) {
        return <<<HTML
        $nav
        <h1>Delete Admin(s)</h1>
        $message
        <p>There are no records to display</p>
HTML;
    }

    $rows = '';
    foreach ($admins as $admin) {
        $id       = $admin['id'];
        $fname    = $admin['fname'];
        $lname    = $admin['lname'];
        $email    = $admin['email'];
        $password = $admin['password'];
        $status   = $admin['status'];

        $rows .= <<<HTML
        <tr>
            <td>$fname</td>
            <td>$lname</td>
            <td>$email</td>
            <td>$password</td>
            <td>$status</td>
            <td><input type="checkbox" name="delete[]" value="$id"></td>
        </tr>
HTML;
    }

    return <<<HTML
    $nav
    <h1>Delete Admin(s)</h1>
    $message
    <form method="POST" action="index.php?page=deleteAdmins">
        <button type="submit" class="btn btn-danger mb-3">Delete</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Password</th>
                    <th>Status</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                $rows
            </tbody>
        </table>
    </form>
HTML;
}
?>