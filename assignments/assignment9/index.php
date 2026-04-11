<?php

require_once 'classes/StickyForm.php';
require_once 'classes/Pdo_methods.php';

$form = new StickyForm();
$pdo = new PdoMethods();

// StickyForm::validateForm() reads this array, fills in 'value' and 'error'
$formConfig = [

    'firstName' => [
        'type'     => 'text',
        'label'    => '*First Name',
        'id'       => 'firstName',
        'name'     => 'firstName',
        'value'    => '',
        'regex'    => 'name',
        'required' => true,
        'error'    => '',
        'errorMsg' => 'You must enter a first name and it must be alpha characters only.',
    ],

    'lastName' => [
        'type'     => 'text',
        'label'    => '*Last Name',
        'id'       => 'lastName',
        'name'     => 'lastName',
        'value'    => '',
        'regex'    => 'name',
        'required' => true,
        'error'    => '',
        'errorMsg' => 'You must enter a last name and it must be alpha characters only.',
    ],

    'email' => [
        'type'     => 'text',
        'label'    => '*Email',
        'id'       => 'email',
        'name'     => 'email',
        'value'    => '',
        'regex'    => 'email',
        'required' => true,
        'error'    => '',
        'errorMsg' => 'You must enter a email address and it must be in the format of example@example.com.',
    ],

    'password' => [
        'type'     => 'text',   // type is 'text' so validateForm processes it
        'label'    => '*Password',
        'id'       => 'password',
        'name'     => 'password',
        'value'    => '',
        'regex'    => 'password',
        'required' => true,
        'error'    => '',
        'errorMsg' => 'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)',
    ],

    'confirmPassword' => [
        'type'     => 'text',
        'label'    => '*Confirm Password',
        'id'       => 'confirmPassword',
        'name'     => 'confirmPassword',
        'value'    => '',
        'regex'    => 'password',
        'required' => true,
        'error'    => '',
        'errorMsg' => 'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)',
    ],

        'masterStatus' => ['error' => false],
];

$message =''; // Success or duplicate-email message shown above the form

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $formConfig = $form->validateForm($_POST, $formConfig);

if (!empty($formConfig['password']['value']) && !empty($formConfig['confirmPassword']['value'])) {
    if ($formConfig['password']['value'] !== $formConfig['confirmPassword']['value']) {
        $formConfig['confirmPassword']['error'] = 'Your passwords do not match';
    }
}

if (empty($formConfig['password']['error'])) {
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/', $formConfig['password']['value'])) {
        $formConfig['password']['error'] = 'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)';
    }
}

if (empty($formConfig['confirmPassword']['error'])) {
    if (!preg_match('/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/', $formConfig['confirmPassword']['value'])) {
        $formConfig['confirmPassword']['error'] = 'Must have at least (8 characters, 1 uppercase, 1 symbol, 1 number)';
    }
}

    $hasErrors = $formConfig['masterStatus']['error'];
    foreach (['firstName', 'lastName', 'email', 'password', 'confirmPassword'] as $field) {
        if(!empty($formConfig[$field]['error'])) {
            $hasErrors = true;
            break;
        }
    }

    if (!$hasErrors) {

    $sql = "SELECT id FROM users WHERE email = :email";
    $bindings = [[':email', $formConfig['email']['value'], 'str']];
    $existing = $pdo->selectBinded($sql, $bindings);

    if(count($existing) > 0) {
        $message = 'There is already a record with that email';
    } else {
            // Hash the password before storing — NEVER store plain text passwords
            $hashed = password_hash($formConfig['password']['value'], PASSWORD_BCRYPT);

            $sql = "INSERT INTO users (first_name, last_name, email, `password`)
            VALUES (:firstName, :lastName, :email, :password)";

            $bindings = [
                [':firstName', $formConfig['firstName']['value'], 'str'],
                [':lastName',  $formConfig['lastName']['value'], 'str'],
                [':email',     $formConfig['email']['value'], 'str'],
                [':password',  $hashed, 'str'],
            ];
            $pdo->otherBinded($sql, $bindings);

            $message = 'You have been added to the database';

            foreach (['firstName',  'lastName', 'email',  'password', 'confirmPassword'] as $field) {
                $formConfig[$field]['value'] = '';
            }
        }
    }
}

//Always fetch all records for the table at the bottom
$sql = "SELECT first_name, last_name, email, `password` FROM users";
$records = $pdo->selectNotBinded($sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Assignment 9 - Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">

<p>All fields are required.</p>

<?php if (!empty($message)): ?>
        <p><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

<form method="post" action="">

<!-- Names field -->
<div class="post">
    <?= $form->renderInput($formConfig['firstName'], 'col-6 mb-2') ?>
    <?= $form->renderInput($formConfig['lastName'], 'col-6 mb-2') ?>
</div>

<div class="row">
    <?= $form->renderInput($formConfig['email'], 'col-4 mb-2') ?>


    <!-- Password field -->
    <div class="col-4 mb-2">
                <label for="password"><?= $formConfig['password']['label'] ?></label>
                <input type="text"
                       class="form-control"
                       id="password"
                       name="password"
                       value="<?= htmlspecialchars($formConfig['password']['value']) ?>">
                <?php if (!empty($formConfig['password']['error'])): ?>
                    <span class="text-danger"><?= $formConfig['password']['error'] ?></span>
                <?php endif; ?>
            </div>

            <!-- Manual confirm password field -->
            <div class="col-4 mb-2">
                <label for="confirmPassword"><?= $formConfig['confirmPassword']['label'] ?></label>
                <input type="text"
                       class="form-control"
                       id="confirmPassword"
                       name="confirmPassword"
                       value="<?= htmlspecialchars($formConfig['confirmPassword']['value']) ?>">
                <?php if (!empty($formConfig['confirmPassword']['error'])): ?>
                    <span class="text-danger"><?= $formConfig['confirmPassword']['error'] ?></span>
                <?php endif; ?>
            </div>
        </div>

        <button type="submit" class="btn btn-primary">Register</button>

    </form>


    <!-- Record Tables -->
     <?php if (empty($records)): ?>
        <p>No records to display.</p>
    <?php else: ?>
        <table class="table table-bordered mt-3">
            <thead>
                <tr>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Password</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($records as $row): ?>
                <tr>
                    <td><?= htmlspecialchars($row['first_name']) ?></td>
                    <td><?= htmlspecialchars($row['last_name'])  ?></td>
                    <td><?= htmlspecialchars($row['email'])      ?></td>
                    <td><?= htmlspecialchars($row['password'])   ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>
</body>
</html>