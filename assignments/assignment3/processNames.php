<?php
session_start();

function addClearNames() {
    // Initialize the names array 
    if (!isset($_SESSION['names'])) {
        $_SESSION['names'] = array();
    }
    
    // Check if Add Name button was clicked
    if (isset($_POST['addName'])) {
        
        $fullName = $_POST['enterName'];
        
        // Split the name by space to get first and last name
        $nameParts = explode(" ", $fullName);
        
        // Capitalize first letter of first and last name
        $firstName = ucfirst($nameParts[0]);
        $lastName = ucfirst($nameParts[1]);
        
        // Formatting
        $formattedName = $lastName . ", " . $firstName;
        
        // Add the formatted name to array
        array_push($_SESSION['names'], $formattedName);
        
        // Sort the array alphabetically
        sort($_SESSION['names']);
        
        // Convert array to string with newlines
        $output = implode("\n", $_SESSION['names']);
        
        return $output;
    }
    
    // Check if Clear Names button was clicked
    if (isset($_POST['clearNames'])) {
        
        $_SESSION['names'] = array();
        
        return "";
    }
}
?>