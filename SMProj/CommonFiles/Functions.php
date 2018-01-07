<?php

//NewUser.php functions

function ValidateStudentID($studentid) {
    if (trim($studentid) && isset($studentid)) {
        
    } else {
        return "Student ID Required";
    }
}

function ValidateName($name) {
    if (trim($name) && isset($name)) {
        
    } else {
        return "Name Required";
    }
}

function ValidatePhone($phone) {
    $phoneregex = "/[2-9][0-9]{2}-[2-9][0-9]{2}-\d{4}/";
    if (trim($phone) && isset($phone)) {
        if (preg_match($phoneregex, $phone, $phonevalid)) {
            
        } else {
            return "Phone Number Invalid";
        }
    } else {
        return "Phone Number Required";
    }
}

function ValidatePassword($password) {
    if (trim($password) && isset($password)) {
        
    } else {
        return "Password Required";
    }
}

function ValidatePassword2($password, $password2) {
    if (trim($password2) && isset($password2)) {
        if ($password == $password2) {
            
        } else {
            return "Passwords Must Match";
        }
    } else {
        return "Password Confirmation Required";
    }
}
        
?>