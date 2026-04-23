<?php
class Validation {
    private $errors = [];

    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            //Updated
            'name'     => '/^[a-zA-Z\s\-\']+$/',
            'phone'    => '/^\d{3}\.\d{3}\.\d{4}$/',
            'address'  => '/^\d+\s[a-zA-Z0-9\s,.\'-]+$/',
            'city'     => '/^[a-zA-Z\s]+$/',
            'zip'      => '/^\d{5}(-\d{4})?$/',
            'email'    => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            'password' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/',
            'dob'      => '/^\d{2}\/\d{2}\/\d{4}$/',
            'none'     => '/.*/',
        ];

        $pattern = $patterns[$type] ?? '/.*/';

        if (!preg_match($pattern, $value)) {
            $errorMessage = $customErrorMsg ?? "Invalid $type format.";
            $this->errors[$type] = $errorMessage;
            return false;
        }
        return true;
    }

    public function getErrors() {
        return $this->errors;
    }

    public function hasErrors() {
        return !empty($this->errors);
    }
}
?>