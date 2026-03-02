<?php 

class Calculator {

public function calc() {
    $args = func_get_args();
    $errorMsg = "<p>Cannot perform operation. Try again but BETTER!!!! You must have three arguments. A string for the operator (+,-,*,/) and two integers or floats for the numbers.</p>\n"; 

    //makes sure we have 3 arguments
    if(count($args) !== 3) {
        return $errorMsg;
    }

    $operator = $args[0];
    $num1 = $args[1];
    $num2 = $args[2];

    if (!is_string($operator) || !in_array($operator, ['+', '-', '*', '/'])) {
        return $errorMsg;
    }

    if (!is_int($num1) && !is_float($num1)) {
        return $errorMsg;
    }

    if (!is_int($num2) && !is_float($num2)) {
        return $errorMsg;
    }
    // '===' Strict comparison vs '==' Loose comparison
    if($operator === '/' && $num2 == 0) {
       return "<p>The calculation is {$num1} {$operator} {$num2}. The answer is cannot divide a number by zero.</p>\n";
    }

    switch ($operator) {
            case '+':
                $answer = $num1 + $num2;
                break;
            case '-':
                $answer = $num1 - $num2;
                break;
            case '*':
                $answer = $num1 * $num2;
                break;
            case '/':
                $answer = $num1 / $num2;
                break;
        }

    return "<p>The calculation is {$num1} {$operator} {$num2}. The answer is {$answer}.</p>\n";
    }
}