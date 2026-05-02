<?php
function init() {
    global $formConfig, $message;

    require_once('includes/navigation.php');
    require_once('classes/StickyForm.php');

    $nav  = renderNav();
    $form = new StickyForm();

    $fname   = $form->renderInput($formConfig['fname'],    'col-md-6 mb-3');
    $lname   = $form->renderInput($formConfig['lname'],    'col-md-6 mb-3');
    $address = $form->renderInput($formConfig['address'],  'col-12 mb-3');
    $city    = $form->renderInput($formConfig['city'],     'col-md-4 mb-3');
    $state   = $form->renderSelect($formConfig['state'],   'col-md-4 mb-3');
    $phone   = $form->renderInput($formConfig['phone'],    'col-md-4 mb-3');
    $email   = $form->renderInput($formConfig['email'],    'col-md-4 mb-3');
    $dob     = $form->renderInput($formConfig['dob'],      'col-md-4 mb-3');
    $age     = $form->renderRadio($formConfig['age'],      'col-12 mb-3', 'horizontal');
    $contacts = $form->renderCheckboxGroup($formConfig['contacts'], 'col-12 mb-3', 'horizontal');

    return <<<HTML
    $nav
    <h1>Add Contact</h1>
    $message
    <form method="POST" action="index.php?page=addContact">
        <div class="row">
            $fname
            $lname
        </div>
        <div class="row">
            $address
        </div>
        <div class="row">
            $city
            $state
        </div>
        <div class="row">
            $phone
            $email
            $dob
        </div>
        <div class="row">
            $age
        </div>
        <div class="row">
            $contacts
        </div>
        <button type="submit" class="btn btn-primary">Add Contact</button>
    </form>
HTML;
}
?>