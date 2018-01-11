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

function savefile($destination, $picturenumber)
{
    if (!file_exists($destination))
    {
        mkdir($destination);
    }

    $temppath = $_FILES["file"]["tmp_name"][$picturenumber];
    $path = $destination."/".$_FILES["file"]["name"][$picturenumber];

    $pathinfo = pathinfo($path);
    $directory = $pathinfo["directoryname"];
    $filename = $pathinfo["filename"];
    $extension = $pathinfo["extension"];

    // make sure not to overwrite any existing files
    $i = "";
    while (file_exists($path))
    {
        $i++;
        $path = $dir."/".$filename."_".$i.".".$extension;
    }
    move_uploaded_file($temppath, $path);

    return $path;
}

function resamplefile($path, $destination, $maxwidth, $maxheight)
{
    if (!file_exists($destination))
    {
        mkdir($destination);
    }

    $details = getimagesize($path);

    $originalresource = null;

    if ($details[2] == IMAGETYPE_JPEG)
    {
        $originalresource = imagecreatefromjpeg($path);
    }
    elseif ($details[2] == IMAGETYPE_PNG)
    {
        $originalresource = imagecreatefrompng($path);
    }
    elseif ($details[2] == IMAGETYPE_GIF)
    {
        $originalresource = imagecreatefromgif($path);
    }

    $widthratio = $details[0] / $maxwidth;
    $heightratio = $details[1] / $maxheight;
    $ratio = max($widthratio, $heightratio);

    $newwidth = $details[0] / $ratio;
    $newheight = $details[1] / $ratio;

    $newimage = imagecreatetruecolor($newwidth, $newheight);

    $success = imagecopyresampled($newimage, $originalresource, 0, 0, 0, 0, $newwidth, $newheight, $details[0], $details[1]);

    if (!$success)
    {
        imagedestroy($newimage);
        imagedestroy($originalresource);
        return "";
    }

    $pathinfo = pathinfo($path);
    $newpath = $destination."/".$pathinfo["filename"];

    if ($details[2] == IMAGETYPE_JPEG)
    {
        $newpath .= ".jpg";
        $success = imagejpeg($newimage, $newpath, 100);
    }
    elseif ($details[2] == IMAGETYPE_PNG)
    {
        $newpath .= ".png";
        $success = imagepng($newimage, $newpath, 0);
    }
    elseif ($details[2] == IMAGETYPE_GIF)
    {
        $newpath .= ".gif";
        $success = imagegif($newimage, $newpath);
    }

    imagedestroy($newimage);
    imagedestroy($originalresource);

    if (!$success)
    {
        return "";
    }
    else
    {
        return $newpath;
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

// MyPictures.php

function rotatePicture($path, $direction) {
    $fileName = basename($path); // Name of FIle
    $originalPath = ORIGINAL_PICTURES_DIR . '/' . $fileName; // Original Picture
    $albumPath = ALBUM_PICTURES_DIR . '/' . $fileName;
    $thumbPath = ALBUM_THUMBNAILS_DIR . '/' . $fileName;
    $pathInfoOriginal = pathinfo($originalPath); // Get ALL the info
    $extOriginal = $pathInfoOriginal['extension']; // Get the extension of that picture

    if ($extOriginal == "png") {
        $originalType = imagecreatefrompng($originalPath);
        $albumType = imagecreatefrompng($albumPath);
        $thumbType = imagecreatefrompng($thumbPath);
    }
    elseif ($extOriginal == "jpg" || $extOriginal == "jpeg") {
        $originalType = imagecreatefromjpeg($originalPath);
        $albumType = imagecreatefromjpeg($albumPath);
        $thumbType = imagecreatefromjpeg($thumbPath);
    }
    elseif ($extOriginal == "gif") {
        $originalType = imagecreatefromgif($originalPath);
        $albumType = imagecreatefromgif($albumPath);
        $thumbType = imagecreatefromgif($thumbPath);
    }

    $originalRotate = imagerotate($originalType, $direction, 0);
    $albumRotate = imagerotate($albumType, $direction, 0);
    $thumbRotate = imagerotate($thumbType, $direction, 0);

    if ($extOriginal == "png") {
        imagepng($originalRotate, $originalPath);
        imagepng($albumRotate, $albumPath);
        imagepng($thumbRotate, $thumbPath);
    }
    elseif ($extOriginal == "jpg" || $extOriginal == "jpeg") {
        imagejpeg($originalRotate, $originalPath);
        imagejpeg($albumRotate, $albumPath);
        imagejpeg($thumbRotate, $thumbPath);
    }
    elseif ($extOriginal == "gif") {
        imagegif($originalRotate, $originalPath);
        imagegif($albumRotate, $albumPath);
        imagegif($thumbRotate, $thumbPath);
    }

    imagedestroy($originalRotate);
    imagedestroy($albumRotate);
    imagedestroy($thumbRotate);
    imagedestroy($originalType);
    imagedestroy($albumType);
    imagedestroy($thumbType);

    header("Location: MyPictures.php");
}

function downloadPicture($path) {
    $fileName = basename($path);
    $originalPath = './img/OriginalPictures/' . $fileName;
    $fileLength = filesize($originalPath);

    header("Content-Type: application/octet-stream");
    header("Content-Disposition: attachment; filename = \"$fileName\" ");
    header("Content-Length: $fileLength" );
    header("Content-Description: File Transfer");
    header("Expires: 0");
    header("Cache-Control: must-revalidate");
    header("Pragma: private");

    ob_clean();
    flush();
    readfile($originalPath);
    flush();
}

// Testing

function deletePicture($path) {
    $fileName = basename($path);
    unlink("." . ORIGINAL_PICTURES_DIR . "/" . $fileName);
    unlink("." . ALBUM_PICTURES_DIR . "/" . $fileName);
    unlink("." . ALBUM_THUMBNAILS_DIR . "/" . $fileName);
    header("Location: MyPictures.php");
}

?>