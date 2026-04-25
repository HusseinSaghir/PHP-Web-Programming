<?php
$loginPath = "index.php?page=login";

//No login needed 
$publicPages = ['login'];
//Staff/admin pages
$staffPages =['welcome', 'addContact', 'deleteContacts'];
//Pages for just the addys
$adminPages = ['addAdmin', 'deleteAdmins'];

$allProtectedPages = array_merge($staffPages, $adminPages);

//Defaults to login if nothing provided
$page =$_GET['page']  ?? null;

//Go back to login if no page is recognized
$allKnownPages = array_merge($publicPages, $allProtectedPages);
if(!$page || !in_array($page, $allKnownPages)) {
    header('location: ' . $loginPath);
    exit;
}

if(in_array($page, $allProtectedPages) && !isset($_SESSION['user_id'])) {
    header('location: ' . $loginPath);
    exit;
}

if (in_array($page, $adminPages) && $_SESSION['status'] !== 'admin') {
    header('location: ' . $loginPath);
    exit;
}

//Routing
switch ($page) {
    case 'login':
        require_once('views/loginForm.php');
        $content = init();
        break;

    case 'welcome':
        require_once('views/welcome.php');
        $content = init();
        break;

    case 'addContact':
        require_once('controllers/addContactProc.php');
        require_once('views/addContactForm.php');
        $content = init();
        break;

    case 'deleteContacts':
        require_once('controllers/deleteContactProc.php');
        require_once('views/deleteContactsTable.php');
        $content = init();
        break;

    case 'addAdmin':
        require_once('controllers/addAdminProc.php');
        require_once('views/addAdminForm.php');
        $content = init();
        break;

    case 'deleteAdmins':
        require_once('controllers/deleteAdminProc.php');
        require_once('views/deleteAdminsTable.php');
        $content = init();
        break;
}
?>