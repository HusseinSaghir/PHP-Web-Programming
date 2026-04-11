<?php
class Validation {
    private $errors = [];

    public function checkFormat($value, $type, $customErrorMsg = null) {
        $patterns = [
            //Letters only, no spaces/hyphens/apostrophes
            'name'     => '/^[a-zA-Z]+$/',
            'phone'    => '/^\d{3}\.\d{3}\.\d{4}$/',
            'address'  => '/^[a-zA-Z0-9\s,.\'-]{1,100}$/',
            'zip'      => '/^\d{5}(-\d{4})?$/',
            'email'    => '/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/',
            //8+ chars, 1 uppercase, 1 number, 1 symbol
            'password' => '/^(?=.*[A-Z])(?=.*\d)(?=.*[^a-zA-Z0-9]).{8,}$/',
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