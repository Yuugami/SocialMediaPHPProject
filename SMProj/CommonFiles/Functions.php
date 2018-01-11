<?php

//NewUser.php functions

function ValidateStudentID($studentid) {
    if (trim($studentid) && isset($studentid)) {
        if (checkUserId($studentid) == false) {
        } else {
            return "Student ID Already Exists";
        }
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
    $phoneregex = "/^\d{3}-\d{3}-\d{4}$/";
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
    $uppercaseregex = "/[A-Z]/";
    $lowercaseregex = "/[a-z]/";
    $digitregex = "/\d/";
    if ($password != null) {
        if (strlen($password) > 5) {
            if (preg_match($uppercaseregex, $password, $uppercasevalid)
                    && preg_match($lowercaseregex, $password, $lowercasevalid)
                    && preg_match($digitregex, $password, $digitvalid)) {
            } else {
                return "Password Must Contain At Least One Uppercase Character, One Lowercase Character, and One Digit";
            }
        } else {
            return "Password Must be At Least 6 Characters Long";
        }
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

// AddAlbum.php functions

function validateAddAlbum($target) {
    if (empty($target))
        return false;
    else
        return true;
}

//UploadPictures.php functions

function ValidateAlbum($album) {
    if (isset($album) && $album != "") {

    } else {
        return "Album Required";
    }
}

// MyAlbums.php Functions

function removeDirectory($path) {
    $files = glob($path . '/*');
    foreach ($files as $file) {
        is_dir($file) ? removeDirectory($file) : unlink($file);
    }
    rmdir($path);
    return;
}

?>