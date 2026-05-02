<?php
function init() {
    global $contacts, $message;

    require_once('includes/navigation.php');
    $nav = renderNav();

    if (empty($contacts)) {
        return <<<HTML
        $nav
        <h1>Delete Contact(s)</h1>
        $message
        <p>There are no records to display</p>
HTML;
    }

    $rows = '';
    foreach ($contacts as $contact) {
        $id      = $contact['id'];
        $fname   = $contact['fname'];
        $lname   = $contact['lname'];
        $address = $contact['address'];
        $city    = $contact['city'];
        $state   = $contact['state'];
        $phone   = $contact['phone'];
        $email   = $contact['email'];
        $dob     = $contact['dob'];
        $contactPref = $contact['contacts'];
        $age     = $contact['age'];

        $rows .= <<<HTML
        <tr>
            <td>$fname</td>
            <td>$lname</td>
            <td>$address</td>
            <td>$city</td>
            <td>$state</td>
            <td>$phone</td>
            <td>$email</td>
            <td>$dob</td>
            <td>$contactPref</td>
            <td>$age</td>
            <td><input type="checkbox" name="delete[]" value="$id"></td>
        </tr>
HTML;
    }

    return <<<HTML
    $nav
    <h1>Delete Contact(s)</h1>
    $message
    <form method="POST" action="index.php?page=deleteContacts">
        <button type="submit" class="btn btn-danger mb-3">Delete</button>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>DOB</th>
                    <th>Contact</th>
                    <th>Age</th>
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