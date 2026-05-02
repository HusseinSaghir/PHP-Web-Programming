<?php
function init() {
    global $formConfig, $message;

    require_once('includes/navigation.php');
    require_once('classes/StickyForm.php');

    $nav  = renderNav();
    $form = new StickyForm();

    $fname    = $form->renderInput($formConfig['fname'],    'col-md-6 mb-3');
    $lname    = $form->renderInput($formConfig['lname'],    'col-md-6 mb-3');
    $email    = $form->renderInput($formConfig['email'],    'col-md-4 mb-3');
    $password = $form->renderInput($formConfig['password'], 'col-md-4 mb-3');
    $status   = $form->renderSelect($formConfig['status'],  'col-md-4 mb-3');

    return <<<HTML
    $nav
    <h1>Add Admin</h1>
    $message
    <form method="POST" action="index.php?page=addAdmin">
        <div class="row">
            $fname
            $lname
        </div>
        <div class="row">
            $email
            $password
            $status
        </div>
        <button type="submit" class="btn btn-primary">Add Admin</button>
    </form>
HTML;
}
?>