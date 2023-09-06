<?php

function validateUserForm($username, $email, $phone_number, $password, $confirmpassword) {
    $errorMessage = array();
    $passwordPattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/";

    if(empty($username)) {
        $errorMessage[] = "Username field is empty.";
    }

    if(empty($email)) {
        $errorMessage[] = "Email field is empty.";
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage[] = "Invalid email format.";
        }
    }

    if(empty($phone_number)) {
        $errorMessage[] = "Phone number field is empty.";
    }

    if(empty($password)) {
        $errorMessage[] = "Password field is empty.";
    }else {
        if (!preg_match($passwordPattern, $password)) {
            $errorMessage[] = "Password must be at least 6 characters long and contain at least one uppercase letter, one lowercase letter, and one number. No special symbols allowed.";
        }
    }
    if (empty($confirmpassword)) {
        $errorMessage[] = "Confirm password field is empty.";
    }
    if (!empty($password) && !empty($confirmpassword)) {
        if ($password !== $confirmpassword) {
            $errorMessage[] = "Password and confirm password do not match.";
        }
    }
    
    return $errorMessage;
}

function validateProfile($username, $phone_number, $email){
    $errorMessage = array();

    if(empty($username)) {
        $errorMessage[] = "Username field is empty.";
    }

    if(empty($phone_number)) {
        $errorMessage[] = "Phone number field is empty.";
    }

    if(empty($email)) {
        $errorMessage[] = "Email field is empty.";
    }else{
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errorMessage[] = "Invalid email format.";
        }
    }

    return $errorMessage;

}


?>