<?php 
function init() {
    require_once('includes/navigation.php');

    $nav = renderNav();
    $fname = $_SESSION['fname'];
    $lname = $_SESSION['lname'];
    
    return <<<HTML
     $nav
    <h1>Welcome Page</h1>
    <p>Welcome $fname $lname</p>
HTML;
}
?>