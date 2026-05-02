<?php 
require_once('classes/StickyForm.php');
require_once('classes/Pdo_methods.php');

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
    'address' => [
        'type' => 'text', 'id' => 'address', 'name' => 'address',
        'label' => 'Address', 'value' => '', 'regex' => 'address',
        'required' => true, 'error' => '',
        'errorMsg' => 'Address must start with a number followed by a street name.'
    ],
    'city' => [
        'type' => 'text', 'id' => 'city', 'name' => 'city',
        'label' => 'City', 'value' => '', 'regex' => 'city',
        'required' => true, 'error' => '',
        'errorMsg' => 'City must contain only letters.'
    ],
    'state' => [
        'type' => 'select', 'id' => 'state', 'name' => 'state',
        'label' => 'State', 'selected' => '0',
        'required' => true, 'error' => '',
        'errorMsg' => 'Please select a state.',
        'options' => [
            '0'  => 'Please Select a State',
            'mi' => 'Michigan',
            'oh' => 'Ohio',
            'in' => 'Indiana',
            'il' => 'Illinois',
            'wi' => 'Wisconsin'
        ]
    ],
    'phone' => [
        'type' => 'text', 'id' => 'phone', 'name' => 'phone',
        'label' => 'Phone', 'value' => '', 'regex' => 'phone',
        'required' => true, 'error' => '',
        'errorMsg' => 'Phone must be in the format 999.999.9999.'
    ],
    'email' => [
        'type' => 'text', 'id' => 'email', 'name' => 'email',
        'label' => 'Email', 'value' => '', 'regex' => 'email',
        'required' => true, 'error' => '',
        'errorMsg' => 'Please enter a valid email address.'
    ],
    'dob' => [
        'type' => 'text', 'id' => 'dob', 'name' => 'dob',
        'label' => 'Date of Birth', 'value' => '', 'regex' => 'dob',
        'required' => true, 'error' => '',
        'errorMsg' => 'Date of birth must be in the format mm/dd/yyyy.'
    ],
    'age' => [
        'type' => 'radio', 'id' => 'age', 'name' => 'age',
        'label' => 'Choose an Age Range',
        'required' => true, 'error' => '',
        'errorMsg' => 'You must select an age range.',
        'options' => [
            ['value' => '0-17',  'label' => '0-17',  'checked' => false],
            ['value' => '18-30', 'label' => '18-30', 'checked' => false],
            ['value' => '30-50', 'label' => '30-50', 'checked' => false],
            ['value' => '50+',   'label' => '50+',   'checked' => false],
        ]
    ],
    'contacts' => [
        'type' => 'checkbox', 'id' => 'contacts', 'name' => 'contacts',
        'label' => 'Select One or More Options',
        'required' => false, 'error' => '',
        'options' => [
            ['value' => 'newsletter', 'label' => 'newsletter', 'checked' => false],
            ['value' => 'email',      'label' => 'email',      'checked' => false],
            ['value' => 'text',       'label' => 'text',       'checked' => false],
        ]
    ],
];

$message = '';

if($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stickyForm = new StickyForm();
    $formConfig = $stickyForm->validateForm($_POST, $formConfig);

    if(!$formConfigp['masterStatus']['error']) {
        $contactArray = $_POST['contacts'] ?? [];

        $pdo = new PdoMethods();
        $sql = "INSERT INTO contacts (fname, lname, address, city, state, phone, email, dob, contacts, age)
                VALUES (:fname, :lname, :address, :city, :state, :phone, :email, :dob, :contacts, :age)";

        $bindings = [
            [':fname',    $formConfig['fname']['value'],    'str'],
            [':lname',    $formConfig['lname']['value'],    'str'],
            [':address',  $formConfig['address']['value'],  'str'],
            [':city',     $formConfig['city']['value'],     'str'],
            [':state',    $formConfig['state']['selected'], 'str'],
            [':phone',    $formConfig['phone']['value'],    'str'],
            [':email',    $formConfig['email']['value'],    'str'],
            [':dob',      $formConfig['dob']['value'],      'str'],
            [':contacts', $contactsStr,                     'str'],
            [':age',      $formConfig['age']['value'],      'str'],
        ];

        $result = $pdo->otherBinded($sql, $bindings);

        if($result === 'noerror') {
            $message = '<p class="text-success">Contact Information Added</p>';
            //Resets form to blank on success
            foreach($formConfig as $key => &$element) {
                if($key === 'masterStatus') continue;
               $element['value'] = '';
                $element['error'] = '';
                if (isset($element['selected'])) $element['selected'] = '0';
                if (isset($element['options'])) {
                    foreach ($element['options'] as &$opt) {
                        $opt['checked'] = false;
                    }
                }
            }
        } else {
            $message = '<p class="text-danger">There was an error adding the record</p>';
        }
    }
}
?>