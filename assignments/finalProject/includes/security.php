<?php
//Sends back to login if not logged in for like security purposes
function requireLogin() {
    if(!isset($_SESSION['user_id'])) {
        header('location: index.php?page=login');
        exit;
    }
} 

//Go back to login if you aren't an admin 
function requireAdmin() {
    requireLogin();
    if($_SESSION['status'] !== 'admin') {
      header('location: index.php?page=login');
      exit;  
    }
}
?>