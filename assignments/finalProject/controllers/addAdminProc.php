<?php
require_once(dirname(__DIR__) . '/classes/StickyForm.php');
require_once(dirname(__DIR__) . '/classes/Pdo_methods.php');

$formConfig = [
    'masterStatus' => ['error' => false],
    'fname' => [
        'type' => 'text', 'id' => 'fname', 'name' => 'fname',
        'label' => 'First Name', 'value' => '', 'regex' => 'name',
        'required' => true, 'error' => '',
        'errorMsg' => 'First name must contain only letters, hyphens, apostrophes, or spaces.'
    ],
    'lname' => [
        'type' => 'text', 'id' => 'lname', 'name' => 'lname',
        'label' => 'Last Name', 'value' => '', 'regex' => 'name',
        'required' => true, 'error' => '',
        'errorMsg' => 'Last name must contain only letters, hyphens, apostrophes, or spaces.'
    ],
    'email' => [
        'type' => 'text', 'id' => 'email', 'name' => 'email',
        'label' => 'Email', 'value' => '', 'regex' => 'email',
        'required' => true, 'error' => '',
        'errorMsg' => 'Please enter a valid email address.'
    ],
    'password' => [
        'type' => 'text', 'id' => 'password', 'name' => 'password',
        'label' => 'Password', 'value' => '', 'regex' => 'none',
        'required' => true, 'error' => '',
        'errorMsg' => 'Password cannot be blank.'
    ],
    'status' => [
        'type' => 'select', 'id' => 'status', 'name' => 'status',
        'label' => 'Status', 'selected' => '0',
        'required' => true, 'error' => '',
        'errorMsg' => 'Please select a status.',
        'options' => [
            '0'     => 'Please Select a Status',
            'admin' => 'admin',
            'staff' => 'staff'
        ]
    ],
];

$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stickyForm = new StickyForm();
    $formConfig = $stickyForm->validateForm($_POST, $formConfig);

    if (!$formConfig['masterStatus']['error']) {
        $pdo = new PdoMethods();

        // Check for duplicate email
        $emailCheck = "SELECT id FROM admins WHERE email = :email";
        $checkBindings = [
            [':email', $formConfig['email']['value'], 'str']
        ];
        $existing = $pdo->selectBinded($emailCheck, $checkBindings);

        if ($existing !== 'error' && count($existing) > 0) {
            $message = '<p class="text-danger">That email address is already in use.</p>';
        } else {
            $hashedPassword = password_hash($formConfig['password']['value'], PASSWORD_DEFAULT);

            $sql = "INSERT INTO admins (fname, lname, email, password, status)
                    VALUES (:fname, :lname, :email, :password, :status)";

            $bindings = [
                [':fname',    $formConfig['fname']['value'],    'str'],
                [':lname',    $formConfig['lname']['value'],    'str'],
                [':email',    $formConfig['email']['value'],    'str'],
                [':password', $hashedPassword,                  'str'],
                [':status',   $formConfig['status']['selected'],'str'],
            ];

            $result = $pdo->otherBinded($sql, $bindings);

            if ($result === 'noerror') {
                $message = '<p class="text-success">Admin Added</p>';
                // Reset form on success
                foreach ($formConfig as $key => &$element) {
                    if ($key === 'masterStatus') continue;
                    $element['value'] = '';
                    $element['error'] = '';
                    if (isset($element['selected'])) $element['selected'] = '0';
                }
            } else {
                $message = '<p class="text-danger">There was an error adding the admin</p>';
            }
        }
    }
}
?>