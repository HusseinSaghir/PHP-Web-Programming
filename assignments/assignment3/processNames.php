<?php
session_start();

function addClearNames() {
     
    if (!isset($_SESSION['names'])) {
        $_SESSION['names'] = array();
    }
    
   
    if (isset($_POST['addName'])) {
        
        $fullName = $_POST['enterName'];
        
        
        $nameParts = explode(" ", $fullName);
        
        e
        $firstName = ucfirst($nameParts[0]);
        $lastName = ucfirst($nameParts[1]);
        
        
        $formattedName = $lastName . ", " . $firstName;
        
        
        array_push($_SESSION['names'], $formattedName);
        
        
        sort($_SESSION['names']);
        
       
        $output = implode("\n", $_SESSION['names']);
        
        return $output;
    }
    
    if (isset($_POST['clearNames'])) {
        
        $_SESSION['names'] = array();
        
        return "";
    }
}
?>